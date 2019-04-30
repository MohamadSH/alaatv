<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditTransactionRequest;
use App\Http\Requests\InsertTransactionRequest;
use App\Order;
use App\Orderproduct;
use App\Paymentmethod;
use App\Product;
use App\Repositories\TransactionRepo;
use App\Traits\Helper;
use App\Traits\OrderCommon;
use App\Transaction;
use App\Transactiongateway;
use App\Transactionstatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Zarinpal\Zarinpal;

class TransactionController extends Controller
{
    use OrderCommon;
    use Helper;
    
    protected $response;
    
    function __construct()
    {
        $this->response = new Response();
        $this->middleware('permission:'.config('constants.LIST_TRANSACTION_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.SHOW_TRANSACTION_ACCESS'), ['only' => 'edit']);
        $this->middleware('permission:'.config('constants.EDIT_TRANSACTION_ACCESS'), ['only' => 'update']);
        $this->middleware('role:admin', ['only' => 'getUnverifiedTransactions']);
        //        $this->middleware('permission:'.config('constants.INSERT_TRANSACTION_ACCESS'),['only'=>'store']);
    }

    public function index()
    {
        try {
            $transactions = Transaction::orderBy('created_at', 'Desc');
            
            $createdSinceDate  = Input::get('createdSinceDate');
            $createdTillDate   = Input::get('createdTillDate');
            $createdTimeEnable = Input::get('createdTimeEnable');
            if (strlen($createdSinceDate) > 0 && strlen($createdTillDate) > 0 && isset($createdTimeEnable)) {
                $transactions = $this->timeFilterQuery($transactions, $createdSinceDate, $createdTillDate,
                    'completed_at');
            }
            
            $deadlineSinceDate  = Input::get('DeadlineSinceDate');
            $deadlineTillDate   = Input::get('DeadlineTillDate');
            $deadlineTimeEnable = Input::get('DeadlineTimeEnable');
            if (strlen($deadlineSinceDate) > 0 && strlen($deadlineTillDate) > 0 && isset($deadlineTimeEnable)) {
                $transactions = $this->timeFilterQuery($transactions, $deadlineSinceDate, $deadlineTillDate,
                    'deadline_at');
            }
            
            if (Input::has('transactionStatus')) {
                $transactionStatusFilter = Input::get('transactionStatus');
                $transactions            = $transactions->where("transactionstatus_id", $transactionStatusFilter);
            }
            
            $transactionCode = trim(Input::get("transactionCode"));
            if (isset($transactionCode[0])) {
                $transactions = $transactions->where(function ($q) use ($transactionCode) {
                    $q->where("traceNumber", "like", "%".$transactionCode."%")
                        ->orWhere("referenceNumber", "like",
                            "%".$transactionCode."%")
                        ->orWhere("paycheckNumber", "like", "%".$transactionCode."%")
                        ->orWhere("transactionID", "like",
                            "%".$transactionCode."%");
                });
            }
            
            $transactionManagerComment = Input::get("transactionManagerComment");
            if (isset($transactionManagerComment[0])) {
                $transactions = $transactions->where(function ($q) use ($transactionManagerComment) {
                    $q->where("managerComment", "like", "%".$transactionManagerComment."%");
                });
            }
            
            $firstName = trim(Input::get('firstName'));
            if (isset($firstName) && strlen($firstName) > 0) {
                $transactions = $transactions->whereHas("order", function ($query) use ($firstName) {
                    $query->whereHas('user', function ($q) use ($firstName) {
                        $q->where('firstName', 'like', '%'.$firstName.'%');
                    });
                });
            }
            
            $lastName = trim(Input::get('lastName'));
            if (isset($lastName) && strlen($lastName) > 0) {
                $transactions = $transactions->whereHas("order", function ($query) use ($lastName) {
                    $query->whereHas('user', function ($q) use ($lastName) {
                        $q->where('lastName', 'like', '%'.$lastName.'%');
                    });
                });
            }
            
            $nationalCode = trim(Input::get('nationalCode'));
            if (isset($nationalCode) && strlen($nationalCode) > 0) {
                $transactions = $transactions->whereHas("order", function ($query) use ($nationalCode) {
                    $query->whereHas('user', function ($q) use ($nationalCode) {
                        $q->where('nationalCode', 'like', '%'.$nationalCode.'%');
                    });
                });
            }
            
            $mobile = trim(Input::get('mobile'));
            if (isset($mobile) && strlen($mobile) > 0) {
                $transactions = $transactions->whereHas("order", function ($query) use ($mobile) {
                    $query->whereHas('user', function ($q) use ($mobile) {
                        $q->where('mobile', 'like', '%'.$mobile.'%');
                    });
                });
            }
            
            $productsId                            = Input::get('products');
            $transactionOrderproductCost           = collect();
            $transactionOrderproductTotalCost      = 0;
            $transactionOrderproductTotalExtraCost = 0;
            if (isset($productsId) && !in_array(0, $productsId)) {
                $products = Product::whereIn('id', $productsId)
                    ->get();
                foreach ($products as $product) {
                    if ($product->producttype_id == config("constants.PRODUCT_TYPE_CONFIGURABLE")) {
                        if ($product->hasChildren()) {
                            $productsId = array_merge($productsId,
                                Product::whereHas('parents', function ($q) use ($productsId) {
                                    $q->whereIn("parent_id", $productsId);
                                })
                                    ->pluck("id")
                                    ->toArray());
                        }
                    }
                }
                if (Input::has("checkoutStatusEnable")) {
                    $checkoutStatuses = Input::get("checkoutStatuses");
                    if (in_array(0, $checkoutStatuses)) {
                        $transactions = $transactions->whereIn('order_id',
                            Orderproduct::whereNull("checkoutstatus_id")
                                ->whereIn('product_id', $productsId)
                                ->pluck('order_id'));
                    }
                    else {
                        $transactions = $transactions->whereIn('order_id',
                            Orderproduct::whereIn("checkoutstatus_id", $checkoutStatuses)
                                ->whereIn('product_id', $productsId)
                                ->pluck('order_id'));
                    }
                }
                else {
                    $transactions = $transactions->whereIn('order_id', Orderproduct::whereIn('product_id', $productsId)
                        ->pluck('order_id'));
                }
            }
            else {
                if (Input::has("checkoutStatusEnable")) {
                    $checkoutStatuses = Input::get("checkoutStatuses");
                    if (in_array(0, $checkoutStatuses)) {
                        $transactions = $transactions->whereIn('order_id', Orderproduct::whereNull("checkoutstatus_id")
                            ->pluck('order_id'));
                    }
                    else {
                        $transactions = $transactions->whereIn('order_id',
                            Orderproduct::whereIn("checkoutstatus_id", $checkoutStatuses)
                                ->pluck('order_id'));
                    }
                }
            }
            
            $extraAttributevaluesId = Input::get('extraAttributes');
            if (isset($extraAttributevaluesId)) {
                $transactions = $transactions->whereIn('order_id',
                    Orderproduct::whereHas("attributevalues", function ($q) use ($extraAttributevaluesId) {
                        $q->whereIn('value_id', $extraAttributevaluesId);
                    })
                        ->pluck('order_id'));
            }
            
            //        if(isset($paymentMethodsId) && !in_array(0, $paymentMethodsId)){
            if (Input::has('paymentMethods')) {
                $paymentMethodsId = Input::get('paymentMethods');
                $transactions     = $transactions->whereIn('paymentmethod_id', $paymentMethodsId);
            }
            
            if (Input::has('orderStatuses')) {
                $orderStatusesId = Input::get('orderStatuses');
                //            $orders = Order::orderStatusFilter($orders, $orderStatusesId);
                $transactions = $transactions->whereHas("order", function ($q) use ($orderStatusesId) {
                    $q->whereIn("orderstatus_id", $orderStatusesId);
                });
            }
            
            if (Input::has('paymentStatuses')) {
                $paymentStatusesId = Input::get('paymentStatuses');
                $transactions      = $transactions->whereHas("order", function ($q) use ($paymentStatusesId) {
                    $q->whereIn("paymentstatus_id", $paymentStatusesId);
                });
            }
            
            $transactionType = Input::get("transactionType");
            if (isset($transactionType) && strlen($transactionType) > 0) {
                if ($transactionType == 0) {
                    $transactions = $transactions->where("cost", ">", 0);
                }
                else {
                    if ($transactionType == 1) {
                        $transactions = $transactions->where("cost", "<", 0);
                    }
                }
            }
            
            $transactions = $transactions->get();
            
            if (isset($productsId) && !in_array(0, $productsId)) {
                $checkedOrderproducts = [];
                foreach ($transactions as $transaction) {
                    if (Input::has("checkoutStatusEnable")) {
                        $checkoutStatuses = Input::get("checkoutStatuses");
                        if (in_array(0, $checkoutStatuses)) {
                            $transactionOrderproducts = $transaction->order->orderproducts(config("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
                                ->where(function ($q
                                ) use ($productsId) {
                                    $q->whereIn("product_id", $productsId)
                                        ->whereNull("checkoutstatus_id");
                                })
                                ->get();
                        }
                        else {
                            $transactionOrderproducts = $transaction->order->orderproducts(config("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
                                ->where(function ($q
                                ) use ($productsId) {
                                    $q->whereIn("product_id", $productsId);
                                })
                                ->get();
                        }
                    }
                    else {
                        $transactionOrderproducts = $transaction->order->orderproducts()
                            ->WhereNull("orderproducttype_id")
                            ->whereIn("product_id",
                                $productsId)
                            ->get();
                    }
                    
                    $cost      = 0;
                    $extraCost = 0;
                    if ($transactionOrderproducts->isNotEmpty()) {
                        $orderDiscount              = $transaction->order->discount;
                        $donateProducts             = [
                            Product::CUSTOM_DONATE_PRODUCT,
                            Product::DONATE_PRODUCT_5_HEZAR,
                        ];
                        $numOfOrderproducts         = $transaction->order->orderproducts(config("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
                            ->whereNotIn("product_id",
                                $donateProducts)
                            ->count();
                        $orderDiscountPerItem       = $orderDiscount / $numOfOrderproducts;
                        $orderSuccessfulTransaction = $transaction->order->transactions;
                        
                        //ToDo : Main wallet
                        $giftPaymentMethods = [config("constants.PAYMENT_METHOD_WALLET")];
                        $orderChunk         = 1; //For wallet
                        if (isset($paymentMethodsId)) {
                            $paymentMethodsDiff = array_diff($giftPaymentMethods, $paymentMethodsId);
                            if (empty($paymentMethodsDiff)) {
                                $paymentMethodsDiffReverse = array_diff($paymentMethodsId, $giftPaymentMethods);
                                if (empty($paymentMethodsDiffReverse)) {
                                    $orderChunk = $numOfOrderproducts;
                                }
                            }
                        }
                        
                        $orderWalletTransactionSum = 0;
                        if (!empty($paymentMethodsDiff)) {
                            $orderWalletTransactionSum = $orderSuccessfulTransaction->where("paymentmethod_id",
                                config("constants.PAYMENT_METHOD_WALLET"))
                                ->sum("cost");
                        }
                        
                        if (isset($transactionStatusFilter)) {
                            $orderSuccessfulTransaction = $orderSuccessfulTransaction->whereIn("transactionstatus_id",
                                $transactionStatusFilter);
                        }
                        
                        if (isset($paymentMethodsId)) {
                            $orderSuccessfulTransaction = $orderSuccessfulTransaction->whereIn("paymentmethod_id",
                                $paymentMethodsId);
                        }
                        
                        $orderSuccessfulTransactionPaidSum = $orderSuccessfulTransaction->where("cost", ">", 0)
                            ->sum("cost");
                        
                        $orderSuccessfulTransactionRefundSum = $orderSuccessfulTransaction->where("cost", "<", 0)
                            ->sum("cost");
                        
                        $orderRefundPerItem    = $orderSuccessfulTransactionRefundSum / $numOfOrderproducts; // it is a negative number
                        $orderWalletUsePerItem = $orderWalletTransactionSum / $numOfOrderproducts;
                        
                        foreach ($transactionOrderproducts as $orderproduct) {
                            if (in_array($orderproduct->id, $checkedOrderproducts)) {
                                continue;
                            }
                            $orderproductCost = (int) ($orderproduct->obtainOrderproductCost(false)["final"]);
                            
                            $orderproductCost = $orderproductCost - $orderDiscountPerItem;
                            $orderproductCost = $orderproductCost + $orderRefundPerItem;
                            if (($orderSuccessfulTransactionPaidSum / $orderChunk) > $orderproductCost) {
                                $orderproductCost                  = $orderproductCost - $orderWalletUsePerItem;
                                $cost                              += $orderproductCost;
                                $orderSuccessfulTransactionPaidSum = $orderSuccessfulTransactionPaidSum - $orderproductCost;
                            }
                            else {
                                $cost                              += ($orderSuccessfulTransactionPaidSum / $numOfOrderproducts);
                                $orderSuccessfulTransactionPaidSum = 0;
                            }
                            
                            if (isset($extraAttributevaluesId)) {
                                $extraCost = $orderproduct->getExtraCost($extraAttributevaluesId);
                            }
                            else {
                                $extraCost = $orderproduct->getExtraCost();
                            }
                            
                            array_push($checkedOrderproducts, $orderproduct->id);
                        }
                    }
                    $transactionOrderproductCost->put($transaction->id, [
                        "cost"      => $cost,
                        "extraCost" => $extraCost,
                    ]);
                }
                $transactionOrderproductTotalCost      = number_format($transactionOrderproductCost->sum("cost"));
                $transactionOrderproductTotalExtraCost = number_format($transactionOrderproductCost->sum("extraCost"));
            }
            
            $totaolCost = number_format($transactions->sum("cost"));
            
            return json_encode([
                'index'                      => View::make('transaction.index',
                    compact('transactions', "transactionOrderproductCost"))
                    ->render(),
                "totalCost"                  => $totaolCost,
                "orderproductTotalCost"      => $transactionOrderproductTotalCost,
                "orderproductTotalExtraCost" => $transactionOrderproductTotalExtraCost,
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception    $e) {
            $message = "unexpected error";
            
            return $this->response->setStatusCode(503)
                ->setContent([
                    "message" => $message,
                    "error"   => $e->getMessage(),
                    "line"    => $e->getLine(),
                    "file"    => $e->getFile(),
                ]);
        }
    }
    
    /**
     * @param  Transaction  $transaction
     * @param  array        $data
     *
     * @return array
     */
    public function modify(Transaction $transaction, array $data)
    {
        $result = [
            'statusCode'  => Response::HTTP_OK,
            'message'     => '',
            'transaction' => $transaction,
        ];
        
        $transaction->fill($data);
        $props = [
            'referenceNumber',
            'traceNumber',
            'transactionID',
            'authority',
            'paycheckNumber',
            'managerComment',
            'paymentmethod_id',
        ];
        
        foreach ($props as $prop) {
            if (strlen($transaction->$prop) == 0) {
                $transaction->$prop = null;
            }
        }
        
        if (isset($data["deadline_at"]) && strlen($data["deadline_at"]) > 0) {
            $transaction->deadline_at = Carbon::parse($data["deadline_at"])
                ->addDay()
                ->format('Y-m-d');
        }
        
        if (isset($data["completed_at"]) && strlen($data["completed_at"]) > 0) {
            $transaction->completed_at = Carbon::parse($data["completed_at"])
                ->addDay()
                ->format('Y-m-d');
        }
        
        if ($transaction->update()) {
            $result['statusCode'] = Response::HTTP_OK;
            $result['message']    = 'تراکنش با موفقیت اصلاح شد';
        }
        else {
            $result['statusCode'] = Response::HTTP_SERVICE_UNAVAILABLE;
            $result['message']    = 'خطای پایگاه داده';
        }
        
        $result['transaction'] = $transaction;
        
        return $result;
    }

    public function store(InsertTransactionRequest $request)
    {
        $order = Order::find($request->get('order_id'));
        if (!isset($order)) {
            $result = [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message'    => 'سفارش شما یافت نشد.',
            ];
            
            return response()->json([
                'error' => $result['message'],
            ], $result['statusCode']);
        }
        
        // ToDo: just admin can insert payed transaction (check request and user permission)
        
        $canInsertTransaction = $request->user()
            ->can(config("constants.INSERT_TRANSACTION_ACCESS"));
        $isOrderOwner         = ($order->user_id == $request->user()->id);
        
        if (!$canInsertTransaction && !$isOrderOwner) {
            $result = [
                'statusCode' => Response::HTTP_FORBIDDEN,
                'message'    => 'سفارش مورد نظر متعلق به شما نمی باشد',
            ];
            
            return response()->json([
                'error' => $result['message'],
            ], $result['statusCode']);
        }
        
        $result = $this->new($request->all());
        
        return response()->json([
            'error' => $result['message'],
        ], $result['statusCode']);
    }
    
    /**
     * @param  array  $data
     *
     * @return array
     */
    public function new(array $data)
    {
        $result = [
            'statusCode'  => Response::HTTP_OK,
            'message'     => '',
            'transaction' => null,
        ];
        
        $transaction = new Transaction();
        $transaction->fill($data);
        
        if ($transaction->save()) {
            $result['statusCode']  = Response::HTTP_OK;
            $result['message']     = 'تراکنش با موفقیت ثبت شد.';
            $result['transaction'] = $transaction;
        }
        else {
            $result['statusCode'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['message']    = 'خطای پایگاه داده در ثبت تراکنش';
        }
        
        return $result;
    }

    public function edit(Transaction $transaction)
    {
        $transactionPaymentmethods = Paymentmethod::pluck('displayName', 'id')
            ->toArray();
        $transactionStatuses       = Transactionstatus::where("name", "<>", "transferredToPay")
            ->orderBy("order")
            ->pluck('displayName', 'id')
            ->toArray();
        if (isset($transaction->deadline_at)) {
            $deadlineAt = Carbon::parse($transaction->deadline_at)
                ->format('Y-m-d');
        }
        if (isset($transaction->completed_at)) {
            $completedAt = Carbon::parse($transaction->completed_at)
                ->format('Y-m-d');
        }
        
        return view("transaction.edit",
            compact('transaction', 'transactionPaymentmethods', 'transactionStatuses', '$transactionStatuses',
                'deadlineAt', 'completedAt'));
    }

    public function limitedUpdate(Request $request, Transaction $transaction)
    {
        $order = Order::FindOrFail($request->get("order_id"));
        if (!$this->checkOrderAuthority($order)) {
            abort(404);
        }
        if ($order->id != $transaction->order_id) {
            abort(404);
        }
        
        $editRequest = new EditTransactionRequest();
        
        $paymentImplied = false;
        if ($request->has("referenceNumber")) {
            $editRequest->offsetSet("referenceNumber", $request->get("referenceNumber"));
            $paymentImplied = true;
        }
        if ($request->has("traceNumber")) {
            $editRequest->offsetSet("traceNumber", $request->get("traceNumber"));
            $paymentImplied = true;
        }
        
        if ($request->has("paymentmethod_id")) {
            $editRequest->offsetSet("paymentmethod_id", $request->get("paymentmethod_id"));
        }
        
        if ($paymentImplied) {
            $editRequest->offsetSet("transactionstatus_id", config("constants.TRANSACTION_STATUS_PENDING"));
            $editRequest->offsetSet("completed_at", Carbon::now());
            $editRequest->offsetSet("apirequest", true);
            $response = $this->update($editRequest, $transaction);
            if ($response->getStatusCode() == 200) {
                session()->put("success", "تراکنش با موفقیت ثبت شد");
            }
            else {
                if ($response->getStatusCode() == 503) {
                    session()->put("error", "خطای پایگاه داده ، لطفا مجددا اقدام نمایید.");
                }
                else {
                    session()->put("error", "خطای نا مشخص");
                }
            }
        }
        
        return redirect()->back();
    }

    public function update(EditTransactionRequest $request, Transaction $transaction)
    {
        $result = [];
        
        if (TransactionRepo::modify($request->all(), $transaction->id)) {
            $result['statusCode'] = Response::HTTP_OK;
            $result['message']    = 'تراکنش با موفقیت اصلاح شد';
        }
        else {
            $result['statusCode'] = Response::HTTP_SERVICE_UNAVAILABLE;
            $result['message']    = 'خطای پایگاه داده';
        }
        
        if ($request->expectsJson()) {
            return $this->response->setStatusCode($result['statusCode']);
        }
        session()->put("success", $result['message']);
        
        return redirect()->back();
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->delete()) {
            session()->put('success', 'تراکنش با موفقیت حذف شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        //        $transaction->delete();
        return response([
            'sessionData' => session()->all(),
        ]);
    }
    
    public function getUnverifiedTransactions()
    {
        try {
            $zarinGate    = Transactiongateway::all()
                ->where('name', 'zarinpal')
                ->first();
            $merchant     = $zarinGate->merchantNumber;
            $zarinPal     = new Zarinpal($merchant, new SoapDriver(), "zarinGate");
            $result       = $zarinPal->unverifiedTransactions();
            $transactions = collect();
            if (!isset($result["error"])) {
                $authorities = json_decode($result["Authorities"]);
                
                foreach ($authorities as $authority) {
                    $transaction = Transaction::where("authority", $authority->Authority)
                        ->first();
                    $firstName   = "";
                    $lastName    = "";
                    $mobile      = "";
                    $created_at  = "";
                    if (isset($transaction)) {
                        $created_at = $transaction->created_at;
                        $user       = $transaction->order->user;
                        if (isset($user)) {
                            $userId    = $user->id;
                            $firstName = $user->firstName;
                            $lastName  = $user->lastName;
                            $mobile    = $user->mobile;
                        }
                    }
                    
                    $transactions->push([
                        "userId"     => (isset($userId)) ? $userId : null,
                        "firstName"  => $firstName,
                        "lastName"   => $lastName,
                        "mobile"     => $mobile,
                        "authority"  => $authority->Authority,
                        "amount"     => $authority->Amount,
                        "created_at" => $created_at,
                    ]);
                }
            }
            else {
                $error = $result["error"];
            }
            $pageName = "admin";
            
            return view("transaction.unverifiedTransactions", compact("transactions", "error", 'pageName'));
        } catch (\Exception    $e) {
            $message = "unexpected error";
            
            return $this->response->setStatusCode(503)
                ->setContent([
                    "message" => $message,
                    "error"   => $e->getMessage(),
                    "line"    => $e->getLine(),
                    "file"    => $e->getFile(),
                ]);
        }
    }
    
    public function convertToDonate(Transaction $transaction)
    {
        if ($transaction->cost < 0 && !isset($transaction->traceNumber)) {
            $order                          = Order::FindOrFail($transaction->order->id);
            $donateOrderproduct             = new Orderproduct();
            $donateOrderproduct->order_id   = $order->id;
            $donateOrderproduct->product_id = 182;
            $donateOrderproduct->cost       = -$transaction->cost;
            if ($donateOrderproduct->save()) {
                if ($transaction->forceDelete()) {
                    $newOrder                    = Order::where("id", $order->id)
                        ->get()
                        ->first();
                    $orderCostArray              = $newOrder->obtainOrderCost(true, false, "REOBTAIN");
                    $newOrder->cost              = $orderCostArray["rawCostWithDiscount"];
                    $newOrder->costwithoutcoupon = $orderCostArray["rawCostWithoutDiscount"];
                    if ($newOrder->update()) {
                        return $this->response->setStatusCode(200)
                            ->setContent(["message" => "عملیات تبدیل با موفقیت انجام شد."]);
                    }
                    else {
                        return $this->response->setStatusCode(503)
                            ->setContent(["message" => "خطا در بروز رسانی سفارش . لطفا سفارش را دستی اصلاح نمایید."]);
                    }
                }
                else {
                    return $this->response->setStatusCode(503)
                        ->setContent(["message" => "خطا در بروز رسانی تراکنش . لطفا تراکنش را دستی اصلاح نمایید."]);
                }
            }
            else {
                return $this->response->setStatusCode(503)
                    ->setContent(["message" => "خطا در ایجاد آیتم کمک مالی . لطفا دوباره اقدام نمایید."]);
            }
        }
        else {
            return $this->response->setStatusCode(503)
                ->setContent(["message" => "این تراکنش بازگشت هزینه نمی باشد"]);
        }
    }
    
    public function completeTransaction(\Illuminate\Http\Request $request, Transaction $transaction)
    {
        if (!isset($transaction->traceNumber)) {
            $transaction->traceNumber      = $request->get("traceNumber");
            $transaction->paymentmethod_id = config("constants.PAYMENT_METHOD_ATM");
            $transaction->managerComment   = $transaction->managerComment."شماره کارت مقصد: \n".$request->get("managerComment");
            if ($transaction->update()) {
                return $this->response->setStatusCode(200)
                    ->setContent(["message" => "اطلاعات تراکنش با موفقیت ذخیره شد"]);
            }
            else {
                return $this->response->setStatusCode(503)
                    ->setContent(["message" => "خطا در ذخیره اطلاعات . لفطا مجددا اقدام نمایید"]);
            }
        }
    }
}
