<?php

namespace App\Http\Controllers;

use App\Helpers\ENPayment;
use App\Http\Requests\EditTransactionRequest;
use App\Http\Requests\InsertTransactionRequest;
use App\Orderproduct;
use App\Paymentmethod;
use App\Traits\Helper;
use App\Traits\OrderCommon;
use App\Transaction;
use App\Transactiongateway;
use App\Order;
use App\Product;
use App\Transactionstatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Zarinpal\Drivers\SoapDriver;
use Zarinpal\Zarinpal;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    use OrderCommon;
    use Helper;
    protected $response ;
    function __construct()
    {
        $this->response = new Response();
        $this->middleware('permission:'.Config::get('constants.LIST_TRANSACTION_ACCESS'),['only'=>'index']);
        $this->middleware('permission:'.Config::get('constants.SHOW_TRANSACTION_ACCESS'),['only'=>'edit']);
        $this->middleware('permission:'.Config::get('constants.EDIT_TRANSACTION_ACCESS'),['only'=>'update']);
        $this->middleware('role:admin' ,['only'=>'getUnverifiedTransactions']);
//        $this->middleware('permission:'.Config::get('constants.INSERT_TRANSACTION_ACCESS'),['only'=>'store']);
    }

    /** checks whether the order belongs to the user or not
     * @param  \app\Order
     * @return boolean
     */
    private function checkOrderAuthority(Order $order){
        if($order->user_id == Auth::user()->id)
            return true;
        else
            return false;
    }

    /**
     * Making request to ZarinPal gateway
     *
     * @param  \app\Order $order
     * @param  integer $cost
     * @param  String $description
     * @return \Illuminate\Http\Response
     */
    protected function zarinReqeust($order , $cost , $description )
    {
        $zarinGate = Transactiongateway::all()->where('name' ,'zarinpal')->first() ;
        $merchant = $zarinGate->merchantNumber;
        $zarinPal = new Zarinpal($merchant,new SoapDriver()  , "zarinGate");

        //ToDo : putting verify url in .env or database
        $answer = $zarinPal->request(action("OrderController@verifyPayment"),(int)$cost,$description) ;
        if(isset($answer['Authority']) && strlen($answer['Authority'])>0){
            $order->cancelOpenOnlineTransactions();

            $unpaidTransactions = $order->unpaidTransactions->where("cost" , $cost);
            if($unpaidTransactions->isNotEmpty())
            {
                $unpaidTransaction = $unpaidTransactions->first();
                $request = new EditTransactionRequest();
                $request->offsetSet("authority" ,  $answer['Authority']);
                $request->offsetSet("transactiongateway_id" ,   $zarinGate->id);
                $request->offsetSet("destinationBankAccount_id" ,  1);
                $request->offsetSet("paymentmethod_id" ,  Config::get("constants.PAYMENT_METHOD_ONLINE"));
                $request->offsetSet("apirequest" ,  true);
                $request->offsetSet("gateway" ,  $zarinPal);
                $response = $this->update($request , $unpaidTransaction);
                if($response->getStatusCode() == 200) $zarinPal->redirect();
                else dd("مشکل در برقراری ارتباط با درگاه زرین پال");
            }else{
                //ToDo: check if this order is paid for or not
                $request = new InsertTransactionRequest();
                $request->offsetSet("order_id" ,  $order->id);
                $request->offsetSet("cost" ,  $cost);
                $request->offsetSet("authority" ,  $answer['Authority']);
                $request->offsetSet("transactiongateway_id" ,   $zarinGate->id);
                $request->offsetSet("transactionstatus_id" ,  Config::get("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY"));
                $request->offsetSet("destinationBankAccount_id" ,  1);
                $request->offsetSet("paymentmethod_id" ,  Config::get("constants.PAYMENT_METHOD_ONLINE"));
                $request->offsetSet("gateway" ,  $zarinPal);
                $response = $this->store($request);
                if($response->getStatusCode() == 200) $zarinPal->redirect();
                else dd("مشکل در برقراری ارتباط با درگاه زرین پال");
            }
        }
        else return $answer['error'];
    }


    /**
     * Making request to ENBank gateway
     *
     * @param  integer $cost
     * @param  \app\Order $order
     * @return \Illuminate\Http\Response
     */
    protected function ENBankRequest($order , $cost)
    {
        $homeController = new HomeController() ;
        if(!Auth::user()->hasRole("admin")) {
            $message = "در حال حاضر استفاده از این سرویس مقدور نمی باشد" ;
            return $homeController->errorPage($message);
        }

        $enBankGate = Transactiongateway::all()->where('name' ,'enbank')->first() ;
        $request = new InsertTransactionRequest();
        $request->offsetSet("order_id" ,  $order->id);
        $request->offsetSet("cost" ,  $cost);
        $request->offsetSet("transactiongateway_id" ,   $enBankGate->id);
        $request->offsetSet("transactionstatus_id" ,  Config::get("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY"));
        $request->offsetSet("destinationBankAccount_id" ,  1);
        $onlinePaymentMethod = Paymentmethod::all()->where("name" , "online")->first();
        $request->offsetSet("paymentmethod_id" ,  $onlinePaymentMethod->id);
        $request->offsetSet("gateway" ,  $enBankGate);
        $transaction = $this->store($request) ;
        if(!isset($transaction))
        {
            $message = "خطا در ایجاد تراکنش" ;
            return $homeController->errorPage($message);
        }

        $resNumber = $transaction->id;
        $amount = ((int)$cost) * 10 ;   //tabdile gheymat be rial
        $csrfToken = csrf_token();
        $redirectUrl = action("OrderController@verifyPayment")."?_token=".$csrfToken;

        /////////////////state1
        $ENBank = new ENPayment();

        $login = $ENBank->login($enBankGate->merchantNumber,$enBankGate->merchantPassword);
        if(isset($login["error"]))
        {
            $message = "خطا در ورود" ;
            return $homeController->errorPage($message);
        }else{
            $sessionId = $login["sessionId"];
        }

        $params['resNum'] = $resNumber;
        $params['amount'] = $amount;
        $params['redirectUrl'] = $redirectUrl ;
        $params['transType'] = "enGoods" ;
        $params['WSContext'] = array('SessionId' => $sessionId , 'UserId' => $enBankGate->merchantNumber, 'Password' => $enBankGate->merchantPassword);

        $getPurchaseParamsToSign = $ENBank->getPurchaseParamsToSign($params);
        if(isset($getPurchaseParamsToSign['error']))
        {
            $message = "پاسخی از بانک دریافت نشد" ;
            return $homeController->errorPage($message);
        }else{
            $uniqueId =  $getPurchaseParamsToSign['uniqueId'];
            $dataToSign = $getPurchaseParamsToSign['dataToSign'];
        }
        dump($uniqueId );
        dump($dataToSign);
        ///////////////////////state2

        $fileToSign = "ENBank-toSign-".$transaction->id.".txt";
        Storage::disk(Config::get("constants.DISK17"))->put($fileToSign, $dataToSign);
        $fileToSignRealPath = Storage::disk(Config::get("constants.DISK17"))->path($fileToSign);

        $signedFile = "ENBank-signed-".$transaction->id.".txt";
        Storage::disk(Config::get("constants.DISK17"))->put($signedFile, "");
        $signedFileRealPath = Storage::disk(Config::get("constants.DISK17"))->path($signedFile);

        $myCertificate = Storage::disk(Config::get("constants.DISK16"))->path($enBankGate->certificatePrivateKeyFile);
        openssl_pkcs7_sign($fileToSignRealPath, $signedFileRealPath, 'file://'.$myCertificate,
            array('file://'.$myCertificate, $enBankGate->certificatePrivateKeyPassword),
            array(),PKCS7_NOSIGS
        );


        $data = Storage::disk(Config::get("constants.DISK17"))->get($signedFile);
        $parts = explode("\n\n", $data, 2);
        $string = $parts[1];

        $parts1 = explode("\n\n", $string, 2);
        $signature = $parts1[0];
        ///////////////////////state3

        $login = $ENBank->login($enBankGate->merchantNumber,$enBankGate->merchantPassword);
        if(isset($login["error"]))
        {
            $message = "خطا در ورود" ;
            return $homeController->errorPage($message);
        }else{
            $sessionId = $login["sessionId"];
        }

        $params['signature'] = $signature;
        $params['WSContext'] = array('SessionId' => $sessionId , 'UserId' => $enBankGate->merchantNumber, 'Password' => $enBankGate->merchantPassword);
        $params['uniqueId']= $uniqueId ;

        $generateSignedPurchase = $ENBank->generateSignedPurchaseToken($params);
        if(isset($generateSignedPurchase['error']))
        {
            $message = "در هنگام اتصال به درگاه ، پاسخی از بانک دریافت نشد" ;
            return $homeController->errorPage($message);
        }else{
            $generateSignedPurchaseToken = $generateSignedPurchase['token'];
            $redirectFormInfo = array();
            $redirectFormInfo["token"] = $generateSignedPurchaseToken;
            $redirectFormInfo["language"] = "fa" ;

//            $postUrl = "https://pna.shaparak.ir/CardServices/tokenController" ;
            $postUrl = "https://pna.shaparak.ir/_ipgw_/payment/" ;
            $requestMethod = "POST";
            $transaction->authority = $generateSignedPurchaseToken ;
            if($transaction->update()) {
                return view("order.checkout.paymentRedirect", compact("postUrl", "requestMethod", "redirectFormInfo"));
            }else{
                $message = "خطای پایگاه داده در ذخیره تراکنش" ;
                return $homeController->errorPage($message);
            }

        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
        $transactions = Transaction::orderBy('created_at', 'Desc');

        $createdSinceDate = Input::get('createdSinceDate');
        $createdTillDate = Input::get('createdTillDate');
        $createdTimeEnable = Input::get('createdTimeEnable');
        if(strlen($createdSinceDate)>0 && strlen($createdTillDate)>0 && isset($createdTimeEnable))
        {
            $transactions = $this->timeFilterQuery($transactions, $createdSinceDate, $createdTillDate, 'completed_at');
        }

        $deadlineSinceDate = Input::get('DeadlineSinceDate');
        $deadlineTillDate = Input::get('DeadlineTillDate');
        $deadlineTimeEnable = Input::get('DeadlineTimeEnable');
        if(strlen($deadlineSinceDate)>0 && strlen($deadlineTillDate)>0 && isset($deadlineTimeEnable))
        {
            $transactions = $this->timeFilterQuery($transactions, $deadlineSinceDate, $deadlineTillDate, 'deadline_at');
        }

        if(Input::has('transactionStatus'))
        {
            $transactions = $transactions->where("transactionstatus_id", Input::get('transactionStatus'));
        }

        $transactionCode = trim(Input::get("transactionCode"));
        if(isset($transactionCode[0])){
            $transactions = $transactions->where(function ($q) use ($transactionCode){
                $q->where("traceNumber" , "like" , "%" . $transactionCode . "%")
                    ->orWhere("referenceNumber" , "like" , "%" . $transactionCode . "%")
                    ->orWhere("paycheckNumber" , "like" , "%" . $transactionCode . "%")
                    ->orWhere("transactionID" , "like" , "%" . $transactionCode . "%");
            });
        }

        $transactionManagerComment = Input::get("transactionManagerComment");
        if(isset($transactionManagerComment[0])){
            $transactions = $transactions->where(function ($q) use ($transactionManagerComment){
                $q->where("managerComment" , "like" , "%" . $transactionManagerComment . "%") ;
            });
        }

        $firstName = trim(Input::get('firstName'));
        if(isset($firstName) && strlen($firstName)>0)
        {
            $transactions = $transactions->whereHas("order" , function ($query) use ($firstName){
                $query->whereHas('user', function($q) use ($firstName) {
                    $q->where('firstName', 'like', '%' . $firstName . '%');
                });
            });
        }

        $lastName = trim(Input::get('lastName'));
        if(isset($lastName) && strlen($lastName)>0)
        {
            $transactions = $transactions->whereHas("order" , function ($query) use ($lastName){
                $query->whereHas('user', function($q) use ($lastName) {
                    $q->where('lastName', 'like', '%' . $lastName . '%');
                });
            });
        }

        $nationalCode = trim(Input::get('nationalCode'));
        if(isset($nationalCode) && strlen($nationalCode)>0)
        {
            $transactions = $transactions->whereHas("order" , function ($query) use ($nationalCode){
                $query->whereHas('user', function($q) use ($nationalCode) {
                    $q->where('nationalCode', 'like', '%' . $nationalCode . '%');
                });
            });
        }

        $mobile = trim(Input::get('mobile'));
        if(isset($mobile) && strlen($mobile)>0)
        {
            $transactions = $transactions->whereHas("order" , function ($query) use ($mobile){
                $query->whereHas('user', function($q) use ($mobile) {
                    $q->where('mobile', 'like', '%' . $mobile . '%');
                });
            });
        }



        $productsId = Input::get('products');
        $transactionOrderproductCost = collect() ;
        $transactionOrderproductTotalCost = 0 ;
        $transactionOrderproductTotalExtraCost = 0 ;
        if(isset($productsId) && !in_array(0, $productsId))
        {
            $products = Product::whereIn('id', $productsId)->get();
            foreach ($products as $product) {
                if($product->producttype_id == Config::get("constants.PRODUCT_TYPE_CONFIGURABLE"))
                    if ($product->hasChildren())
                    {
                        $productsId = array_merge($productsId, Product::whereHas('parents', function ($q) use ($productsId) {
                            $q->whereIn("parent_id", $productsId);
                        })->pluck("id")->toArray());
                    }
            }
            if(Input::has("checkoutStatusEnable"))
            {
                $checkoutStatuses = Input::get("checkoutStatuses");
                if(in_array(0 , $checkoutStatuses))
                {
                    $transactions = $transactions->whereIn('order_id', Orderproduct::whereNull("checkoutstatus_id")->whereIn('product_id', $productsId)->pluck('order_id'));
                }else{
                    $transactions = $transactions->whereIn('order_id', Orderproduct::whereIn("checkoutstatus_id" , $checkoutStatuses)->whereIn('product_id', $productsId)->pluck('order_id'));
                }
            }else{
                $transactions = $transactions->whereIn('order_id', Orderproduct::whereIn('product_id', $productsId)->pluck('order_id'));
            }
        }elseif(Input::has("checkoutStatusEnable"))
        {
            $checkoutStatuses = Input::get("checkoutStatuses");
            if(in_array(0 , $checkoutStatuses))
            {
                $transactions = $transactions->whereIn('order_id', Orderproduct::whereNull("checkoutstatus_id")->pluck('order_id'));
            }else{
                $transactions = $transactions->whereIn('order_id', Orderproduct::whereIn("checkoutstatus_id" , $checkoutStatuses)->pluck('order_id'));
            }
        }

        $extraAttributevaluesId= Input::get('extraAttributes');
        if(isset($extraAttributevaluesId))
        {
                $transactions = $transactions->whereIn('order_id',  Orderproduct::whereHas("attributevalues" , function ($q) use ($extraAttributevaluesId ){
                    $q->whereIn('value_id' , $extraAttributevaluesId);
                })->pluck('order_id'));
        }

        $paymentMethodsId = Input::get('paymentMethods');
//        if(isset($paymentMethodsId) && !in_array(0, $paymentMethodsId)){
        if(isset($paymentMethodsId)){
            $transactions = $transactions->whereIn('paymentmethod_id' , $paymentMethodsId);
        }

        if(Input::has('orderStatuses'))
        {
            $orderStatusesId = Input::get('orderStatuses');
//            $orders = Order::orderStatusFilter($orders, $orderStatusesId);
            $transactions = $transactions->whereHas("order" , function ($q) use ($orderStatusesId)
            {
               $q->whereIn("orderstatus_id" , $orderStatusesId) ;
            });
        }

        $transactionType = Input::get("transactionType");
        if(isset($transactionType) && strlen($transactionType) > 0){
            if($transactionType == 0) $transactions = $transactions->where("cost" , ">" , 0);
            elseif($transactionType == 1) $transactions = $transactions->where("cost" , "<" , 0);
        }

        $transactions = $transactions->get();

        if(isset($productsId) && !in_array(0, $productsId))
        {
            $checkedOrderproducts = array();
            foreach($transactions as $transaction)
            {
                $cost = 0;
                $extraCost = 0 ;
                if(Input::has("checkoutStatusEnable"))
                {
                    $checkoutStatuses = Input::get("checkoutStatuses");
                    if(in_array(0 , $checkoutStatuses))
                    {
                        $transactionOrderproducts = $transaction->order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->whereIn("product_id", $productsId)->whereNull("checkoutstatus_id")->get();
                    }else{
                        $transactionOrderproducts = $transaction->order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->whereIn("product_id", $productsId)->whereIn("checkoutstatus_id" , $checkoutStatuses)->get();
                    }
                }
                else
                {
                    $transactionOrderproducts = $transaction->order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->whereIn("product_id", $productsId)->get();
                }

                if($transactionOrderproducts->isNotEmpty())
                {
                    $orderDiscount = $transaction->order->discount ;
                    $numOfOrderproducts = $transactionOrderproducts->count();
                    $orderDiscountPerItem = $orderDiscount/$numOfOrderproducts;
                    foreach ($transactionOrderproducts as $orderproduct) {
                        if(in_array($orderproduct->id , $checkedOrderproducts)) continue ;
                        $costArray = $orderproduct->obtainOrderproductCost(false);
                        $orderproductCost = 0 ;

                        $orderproductCost = (int)($orderproduct->calculatePayableCost());

                        if($orderproduct->order->successfulTransactions->sum("cost") > 0 )
                        {
                            $cost += $orderproductCost ;
                            $cost = $cost - $orderDiscountPerItem ;
                        }
                        if(isset($extraAttributevaluesId))
                            $extraCost =  $orderproduct->getExtraCost($extraAttributevaluesId) ;
                        else
                            $extraCost =  $orderproduct->getExtraCost() ;
                        array_push($checkedOrderproducts , $orderproduct->id) ;
                    }
                    if($cost > $transaction->cost) $cost = $transaction->cost;
                }
                $transactionOrderproductCost->put($transaction->id , ["cost"=>$cost , "extraCost"=>$extraCost]) ;

            }
            $transactionOrderproductTotalCost = number_format($transactionOrderproductCost->sum("cost")) ;
            $transactionOrderproductTotalExtraCost =  number_format($transactionOrderproductCost->sum("extraCost")) ;
        }

        $totaolCost = number_format($transactions->sum("cost"));
        return json_encode(array('index' => View::make('transaction.index', compact('transactions' , "transactionOrderproductCost" ))->render() , "totalCost" => $totaolCost , "orderproductTotalCost"=>$transactionOrderproductTotalCost , "orderproductTotalExtraCost"=>$transactionOrderproductTotalExtraCost));
        }catch (\Exception    $e) {
                $message = "unexpected error";
                return $this->response
                    ->setStatusCode(503)
                    ->setContent([
                        "message"=>$message ,
                        "error"=>$e->getMessage() ,
                        "line"=>$e->getLine() ,
                        "file"=>$e->getFile()
                    ]);
            }
    }

    /**
     * Show the form for creating a new resource  = making the request to payment gateway
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function paymentRedirect(Request $request)
    {
        $gateway = $request->get('gateway');
        $description = "";
        /**
         *  Finding and authorizing the order to be paid
         */

        if($request->has('order_id'))
            $order_id = $request->get('order_id');
        else
            $order_id = session()->get("order_id");

        $order = Order::findOrFail($order_id);
        if($order->orderproducts->isEmpty())
            return redirect(action("OrderController@checkoutReview"));
        if(!$this->checkOrderAuthority($order))
        {
            $message = "سفارش مورد نظر متعلق به شما نمی باشد";
            $controller = new HomeController();
            return $controller->errorPage($message);
        }

        if($request->has("transaction_id"))
        {
            $transaction = Transaction::FindOrFail($request->get("transaction_id"));
            if($transaction->order_id != $order->id)
                abort("403");
            $description .= "پرداخت قسط -";
        }
        /**
         *  end
         */

        /**
         *  Setting some info and description
         */
        $user = $order->user;
        $description .= "آلاء - ".$user->mobile." - محصولات: ";

        foreach ($order->orderproducts as $orderproduct)
        {
            if(isset($orderproduct->product->id))
                $description .=  $orderproduct->product->name." , ";
            else
                $description .= "یک محصول نامشخص , ";
        }

        if($request->has("customerDescription"))
        {
            $customerDescription = $request->get("customerDescription");
            $order->customerDescription = $customerDescription;
            $order->timestamps = false;
            $order->update();
            $order->timestamps = true;
        }
        /**
         *  end
         */
        if(!$request->has("forcePay_bhrk"))
            $order->refreshCost();

        if($order->hasCoupon()) {
            $validateCouponProduct = $order->reviewCoupon();
            if($validateCouponProduct["couponRemoved"])
            {
                $order = Order::where("id" , $order->id)->get()->first();
                $order->refreshCost();
            }
        }
        if(isset($transaction))
        {
            $cost = $transaction->cost;
        }
        else
        {
            $cost = $order->totalCost() - $order->totalPaidCost();
            $walletCost = 0 ;
            if($request->has("payByWallet"))
            {
                if(isset($user))
                {
                    $walletCost = $cost ;
                    if($order->hasProducts(Config::get("constants.DONATE_PRODUCT")))
                        $walletCost = $walletCost - config("constants.DONATE_PRODUCT_COST") ;

                    $walletPayResult = $this->payOrderCostByWallet($user , $order , $walletCost);
                    if($walletPayResult["result"])
                    {
//                        $walletCost = $walletPayResult["cost"];
                        $order->close(Config::get("constants.PAYMENT_STATUS_INDEBTED")) ;
                        $order->timestamps = false;
                        $order->update();
                        $order->timestamps = true;
                    }
                }
            }
        }

        $cost = $cost - $walletCost ;
        switch ($gateway)
        {
            case "zarinpal":
                if(isset($cost) && $cost > 0)
                {
                    $this->zarinReqeust($order , (int)$cost , $description );
                }
                else
                {
                    session()->put("closedOrder_id" , $order->id) ;
                    return redirect(action("OrderController@verifyPayment"));
                }
                break;
            case "enbank":
                if(isset($cost)) return $this->ENBankRequest($order , (int)$cost  );
                else return redirect(action("OrderController@verifyPayment"));
                break;
            default:break;
        }
        return redirect(action("HomeController@error404"));
    }
    /**
     * Store a newly created resource in storage
     *
     * @param  \app\Http\Requests\InsertTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertTransactionRequest $request)
    {
        $order = Order::findOrFail($request->get("order_id"));

        /**
         *  Check to find whether it comes from admin panel or user panel
         */
        $previousRoute = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();
        if(strcmp($previousRoute , "order.edit") == 0) $comesFromAdmin = true;
        else $comesFromAdmin = false;
        /**
         *  end
         */

        if($request->has("comesFromAdmin"))
        {
            if(!Auth::user()->can(Config::get("constants.INSERT_TRANSACTION_ACCESS"))){
                $message = "سفارش مورد نظر متعلق به شما نمی باشد";
                $controller = new HomeController();
                return $controller->errorPage($message);
            }

            $comesFromAdmin = true;
        }

        /**
         * Check the order authority
         */
        if(!$comesFromAdmin && !$this->checkOrderAuthority($order))  {
            $message = "سفارش مورد نظر متعلق به شما نمی باشد";
            $controller = new HomeController();
            return $controller->errorPage($message);
        }
        /**
         *  end
         */

        $newTransaction = true;
        /**
         *  For inserting online transactions
         */
        if($request->has("authority"))
        {
            $transaction = Transaction::all()->where("authority" , $request->get("authority"))->first();
            if(isset($transaction)) $newTransaction = false;
        }
        /**
         *  end
         */
        if($newTransaction)
        {
            $transaction = new Transaction() ;
            $transaction->fill($request->all());
        }else
        {/**
         *  For inserting online transactions
         */

            if($transaction->order->user->id != $order->user->id) {
                session()->put("error" , "تراکنشی با این شماره Authority قبلا برای شخص دیگری ثبت شده است");
                return redirect()->back();
            }
            if($request->get("cost")!= $transaction->cost)
            {
                session()->put("error" , "مبلغ وارد شده با تراکنش تصدیق نشده ای که یافت شد همخوانی ندارد");
                return redirect()->back();
            }
            /**
             * Verifying transactions
             **/
            $zarinGate = Transactiongateway::all()->where('name' ,'zarinpal')->first() ;
            $merchant = $zarinGate->merchantNumber;
            $zarinPal = new Zarinpal($merchant,new SoapDriver()  , "zarinGate");
            $result = $zarinPal->verifyWithExtra($transaction->cost,$transaction->authority);
            if(strcmp($result["Status"] , "success") == 0)
            {
                $transaction->transactionID = $result["RefID"];
                $transaction->order_id = $order->id;
                $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL");
                $transactionMessage = "تراکنش با موفقیت تصدیق شد و اطلاعات آن ثبت گردید";
                if($transaction->update())
                {
                    session()->put("success" , $transactionMessage);
                    return redirect()->back();
                }else{
                    session()->put("error" , "خطای پایگاه داده در ثبت تراکنش");
                    return redirect()->back();
                }
            }
            elseif(strcmp($result["Status"] , "verified before") == 0)
            {
                $transaction->transactionID = $result["RefID"];
                $transaction->order_id = $order->id;
                $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL");
                $transactionMessage = "این تراکنش قبلا تصدیق شده بود. اطلاعات تراکنش ثبت شد";
                if($transaction->update())
                {
                    session()->put("success" , $transactionMessage);
                    return redirect()->back();
                }else{
                    session()->put("error" , "خطای پایگاه داده در ثبت تراکنش");
                    return redirect()->back();
                }
            }elseif(strcmp($result["Status"] , "error") == 0){
                $transactionMessage = "پاسخ سرویس دهنده خطای ".$result["error"]." می باشد";
                session()->put("error" , $transactionMessage);
                return redirect()->back();
            }else {
                $transactionMessage = "پاسخ نامعتبر از سرویس دهنده";
                session()->put("error" , $transactionMessage);
                return redirect()->back();
            }


            /**
             *  end
             */
        }

        if(strlen($transaction->referenceNumber) == 0) $transaction->referenceNumber = null;
        if(strlen($transaction->traceNumber) == 0) $transaction->traceNumber = null ;
        if(strlen($transaction->transactionID) == 0) $transaction->transactionID = null ;
        if(strlen($transaction->authority) == 0) $transaction->authority = null ;
        if(strlen($transaction->paycheckNumber) == 0) $transaction->paycheckNumber = null ;
        $gateway = $request->get("gateway");//for requests coming from checkout/payment and user order list

        if ($request->has("completed_at") && strlen($request->get("completed_at")) > 0)
        {
            $completed_at = Carbon::parse($request->get("completed_at"))->format('Y-m-d');
            $transaction->completed_at = $completed_at;

        }else
        {
            $transaction->completed_at = Carbon::now();
        }

        if ($request->has("deadline_at") && strlen($request->get("deadline_at")) > 0)
        {
            $deadline_at = Carbon::parse($request->get("deadline_at"))->format('Y-m-d');
            $transaction->deadline_at = $deadline_at;
            $transaction->completed_at = null ;
        }
        if($transaction->save())
        {
            /**
             *  An online transaction
             */
            if(isset($gateway))
            {
                return $this->response->setStatusCode(200);
            } /**
             *  An offline transaction
             */
            else
            {
                if(!$comesFromAdmin)
                    if($order->totalPaidCost() >= (int)$order->totalCost())
                    {
                        $order->paymentstatus_id = Config::get("constants.PAYMENT_STATUS_PAID");
                        $transactionMessage = "تراکنش شما با موفقیت درج شد.مسئولین سایت در اسرع وقت اطلاعات بانکی ثبت شده را بررسی خواهند کرد  و سفارش شما را تایید خواهند نمود. سفارش شما در حال حاضر در وضعیت منتظر تایید می باشد.";
                    }else{
                        $order->paymentstatus_id = Config::get("constants.PAYMENT_STATUS_INDEBTED");
                        $transactionMessage = "تراکنش شما با موفقیت درج شد.مسئولین سایت در اسرع وقت اطلاعات بانکی ثبت شده را بررسی خواهند کرد  و تراکنش شما را تایید خواهند نمود.";
                    }
                else $transactionMessage = "تراکنش با موفقیت درج شد";
                $order->timestamps = false;
                if(!$order->update())
                {
                    session()->put("error" , "خطای پایگاه داده در به روز رسانی سفارش شما");
                    return redirect()->back();
                }
                $order->timestamps = true;
                session()->put("success" , $transactionMessage);
                return redirect()->back();
            }
        }else
        {
            session()->put("error" , "خطای پایگاه داده در ثبت تراکنش");
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $transactionPaymentmethods = Paymentmethod::pluck('displayName', 'id')->toArray();
        $transactionStatuses = Transactionstatus::where("name" ,"<>","transferredToPay")->orderBy("order")->pluck('displayName', 'id')->toArray();
        if (isset($transaction->deadline_at)) {
            $deadlineAt = Carbon::parse($transaction->deadline_at)->format('Y-m-d');
        }
        if (isset($transaction->completed_at)) {
            $completedAt = Carbon::parse($transaction->completed_at)->format('Y-m-d');
        }

        return view("transaction.edit" , compact('transaction' , 'transactionPaymentmethods' , 'transactionStatuses' , '$transactionStatuses' ,'deadlineAt' , 'completedAt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditTransactionRequest  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(EditTransactionRequest $request, Transaction $transaction)
    {
        $transaction->fill($request->all());
        if(strlen($transaction->referenceNumber) == 0) $transaction->referenceNumber = null;
        if(strlen($transaction->traceNumber) == 0) $transaction->traceNumber = null ;
        if(strlen($transaction->transactionID) == 0) $transaction->transactionID = null ;
        if(strlen($transaction->authority) == 0) $transaction->authority = null ;
        if(strlen($transaction->paycheckNumber) == 0) $transaction->paycheckNumber = null ;
        if(strlen($transaction->managerComment) == 0) $transaction->managerComment = null ;
        if(strlen($transaction->paymentmethod_id) == 0) $transaction->paymentmethod_id = null ;
        if ($request->has("deadline_at") && strlen($request->get("deadline_at")) > 0)
        {
            $deadline_at = Carbon::parse($request->get("deadline_at"))->addDay()->format('Y-m-d');
            $transaction->deadline_at = $deadline_at;
        }

        if ($request->has("completed_at") && strlen($request->get("completed_at")) > 0)
        {
            $completed_at = Carbon::parse($request->get("completed_at"))->addDay()->format('Y-m-d');
            $transaction->completed_at = $completed_at;
        }
        if($transaction->update()){
            if($request->ajax() || $request->has("apirequest"))
            {
                return $this->response->setStatusCode(200);

            }else
            {
                session()->put("success" , "تراکنش با موفقیت اصلاح شد");
                return redirect()->back();
            }
        }else{
            if($request->ajax() || $request->has("apirequest"))
            {
                return $this->response->setStatusCode(503);
            }else{
                session()->put("success" , "خطای پایگاه داده");
                return redirect()->back();
            }
        }
    }

    /**
     * Limited update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function limitedUpdate(Request $request, Transaction $transaction)
    {
        $order = Order::FindOrFail($request->get("order_id"));
        if(!$this->checkOrderAuthority($order)) abort(404);
        if($order->id != $transaction->order_id) abort(404);

        $editRequest = new EditTransactionRequest();

        $paymentImplied = false;
        if($request->has("referenceNumber")) {
            $editRequest->offsetSet("referenceNumber" , $request->get("referenceNumber"));
            $paymentImplied = true;
        }
        if($request->has("traceNumber")) {
            $editRequest->offsetSet("traceNumber" , $request->get("traceNumber"));
            $paymentImplied = true;
        }

        if($request->has("paymentmethod_id")) {
            $editRequest->offsetSet("paymentmethod_id" , $request->get("paymentmethod_id"));
        }

        if($paymentImplied)
        {
            $editRequest->offsetSet("transactionstatus_id" , Config::get("constants.TRANSACTION_STATUS_PENDING") );
            $editRequest->offsetSet("completed_at" , Carbon::now());
            $editRequest->offsetSet("apirequest" , true);
            $response = $this->update($editRequest , $transaction);
           if($response->getStatusCode() == 200)
            {
                session()->put("success" , "تراکنش با موفقیت ثبت شد");
            }elseif($response->getStatusCode() == 503)
            {
                session()->put("error" , "خطای پایگاه داده ، لطفا مجددا اقدام نمایید.");
            }else
           {
               session()->put("error" , "خطای نا مشخص");
           }
        }

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \app\Transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->delete()) session()->put('success', 'تراکنش با موفقیت حذف شد');
        else session()->put('error', 'خطای پایگاه داده');
//        $transaction->delete();
        return response([
            'sessionData' => session()->all()
        ]);
    }

    public function getUnverifiedTransactions()
    {
        $zarinGate = Transactiongateway::all()->where('name' ,'zarinpal')->first() ;
        $merchant = $zarinGate->merchantNumber;
        $zarinPal = new Zarinpal($merchant,new SoapDriver()  , "zarinGate");
        $result = $zarinPal->unverifiedTransactions();
        if(!isset($result["error"]))
        {
            $transactions = json_decode($result["Authorities"]);
        }else $error = $result["error"];
        $pageName="admin";
        return view("transaction.unverifiedTransactions" , compact("transactions" , "error" , 'pageName'));
    }

    public function convertToDonate(Transaction $transaction)
    {
        if($transaction->cost < 0 && !isset($transaction->traceNumber))
        {
            $order = Order::FindOrFail($transaction->order->id);
            $donateOrderproduct = new Orderproduct();
            $donateOrderproduct->order_id = $order->id;
            $donateOrderproduct->product_id = 182;
            $donateOrderproduct->cost =  -$transaction->cost;
            if($donateOrderproduct->save())
            {
                if($transaction->forceDelete())
                {
                    $newOrder = Order::where("id" , $order->id)->get()->first();
                    $orderCostArray = $newOrder->obtainOrderCost(true , false , "REOBTAIN");
                    $newOrder->cost = $orderCostArray["rawCostWithDiscount"] ;
                    $newOrder->costwithoutcoupon = $orderCostArray["rawCostWithoutDiscount"];
                    if($newOrder->update())
                    {
                        return $this->response->setStatusCode(200)->setContent(["message"=>"عملیات تبدیل با موفقیت انجام شد."]);
                    }else{
                        return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در بروز رسانی سفارش . لطفا سفارش را دستی اصلاح نمایید."]);
                    }


                }else
                {
                    return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در بروز رسانی تراکنش . لطفا تراکنش را دستی اصلاح نمایید."]);
                }
            }else
            {
                return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در ایجاد آیتم کمک مالی . لطفا دوباره اقدام نمایید."]);
            }
        }else{
            return $this->response->setStatusCode(503)->setContent(["message"=>"این تراکنش بازگشت هزینه نمی باشد"]);
        }
    }

    public function completeTransaction( \Illuminate\Http\Request $request , Transaction $transaction)
    {
        if(!isset($transaction->traceNumber)) {
            $transaction->traceNumber = $request->get("traceNumber");
            $transaction->paymentmethod_id = Config::get("constants.PAYMENT_METHOD_ATM");
            $transaction->managerComment = $transaction->managerComment . "شماره کارت مقصد: \n" . $request->get("managerComment");
            if ($transaction->update()) {
                return $this->response->setStatusCode(200)->setContent(["message" => "اطلاعات تراکنش با موفقیت ذخیره شد"]);
            } else {
                return $this->response->setStatusCode(503)->setContent(["message" => "خطا در ذخیره اطلاعات . لفطا مجددا اقدام نمایید"]);
            }
        }
    }

}
