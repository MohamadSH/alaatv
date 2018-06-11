<?php

namespace App\Http\Controllers;

use App\Afterloginformcontrol;
use App\Attributevalue;
use App\Bankaccount;
use App\Bon;
use App\Coupon;
use App\Helpers\ENPayment;
use App\Http\Requests\DonateRequest;
use App\Http\Requests\InsertTransactionRequest;
use App\Http\Requests\SendSMSRequest;
use App\Http\Requests\SubmitCouponRequest;
use App\Notifications\InvoicePaid;
use App\Ordermanagercomment;
use App\Orderpostinginfo;
use App\Paymentmethod;
use App\Traits\APIRequestCommon;
use App\Traits\Helper;
use App\Traits\ProductCommon;
use App\Traits\RequestCommon;
use App\Transaction;
use App\Transactiongateway;
use App\Order;
use App\Orderproduct;
use App\Orderstatus;
use App\Paymentstatus;
use App\Product;
use App\Transactionstatus;
use App\User;
use App\Userbon;
use App\Websitesetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\EditOrderRequest;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Zarinpal\Drivers\SoapDriver;
use Zarinpal\Zarinpal;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use SEO;

class OrderController extends Controller
{
    use APIRequestCommon ;
    use Helper;
    protected $response ;
    protected $setting;
    use ProductCommon ;
    use RequestCommon;
    function __construct()
    {
        $this->response = new Response();

        $this->middleware('permission:'.Config::get('constants.LIST_ORDER_ACCESS'),['only'=>'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_ORDER_ACCESS'),['only'=>'create']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_ORDER_ACCESS'),['only'=>'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_ORDER_ACCESS'),['only'=>'edit']);
        $this->middleware('permission:'.Config::get('constants.INSERT_ORDER_ACCESS'),['only'=>'exitAdminInsertOrder']);
        $this->setting = json_decode(app('setting')->setting);
    }

    private function renewOrderproducs($orderproducts)
    {
        $renewedOrderproducts = collect();
        $orderproductsRawCost =  0;
        /**
         * Updating each orderproduct
         */
        foreach ($orderproducts as $orderproduct)
        {
            //ToDo : Make it better
            if(!$orderproduct->product->isEnableToPurchase() && !$orderproduct->isGiftType() && !session()->has("adminOrder_id")) {
                $orderproductController =  new OrderproductController();
                $orderproductController->destroy($orderproduct) ;
            }
            else {
                $extraAttributes = $orderproduct->attributevalues;
                foreach($extraAttributes as $extraAttribute)
                {
                    $myParent = $this->makeParentArray($orderproduct->product);
                    $myParent = end($myParent);
                    $productAttributevalue = $myParent->attributevalues->where("id" ,  $extraAttribute->id)->first();

                    if(!isset($productAttributevalue))
                    {
                        $orderproduct->attributevalues()->detach($productAttributevalue);
                    }
                    else
                    {
                        $newExtraCost = $productAttributevalue->pivot->extraCost;
                        $orderproduct->attributevalues()->updateExistingPivot($extraAttribute->id,["extraCost"=>$newExtraCost]);
                    }
                }
                $userbons = $orderproduct->userbons;
                if(!$userbons->isEmpty())
                {
                    $bonName = Config::get("constants.BON1");
                    $bons = $orderproduct->product->bons->where("name" , $bonName)->where("pivot.discount",">","0")->where("isEnable" , 1);
                    if($bons->isEmpty())
                    {
                        $parentsArray = $this->makeParentArray($orderproduct->product);
                        if(!empty($parentsArray))
                        {
                            foreach ($parentsArray as $parent)
                            {
                                $bons= $parent->bons->where("name", $bonName)->where("isEnable" , 1);
                                if(!$bons->isEmpty()) break ;
                            }
                        }
                    }

                    if($bons->isEmpty())
                    {
                        foreach ($userbons as $userBon)
                        {
                            $orderproduct->userbons()->detach($userBon);
                            $userBon->usedNumber = 0;
                            $userBon->userbonstatus_id = Config::get("constants.USERBON_STATUS_ACTIVE");
                            $userBon->update();
                        }

                    }
                    else
                    {
                        $bon = $bons->first();
                        foreach ($userbons as $userbon)
                        {
                            $newDiscount = $bon->pivot->discount;
                            $orderproduct->userbons()->updateExistingPivot($userbon->id , ["discount"=>$newDiscount]);
                        }
                    }
                }

                $newOrderproduct = Orderproduct::where("id" , $orderproduct->id)->get()->first();

                if(!isset($newOrderproduct)) continue;

                $renewedOrderproducts->push($newOrderproduct);
                $orderproductCost = $newOrderproduct->obtainOrderproductCost();

                $newOrderproduct->fillCostValues($orderproductCost);

                if(isset($orderproductCost["cost"]))
                    $orderproductsRawCost +=  $newOrderproduct->cost + $orderproductCost["extraCost"] ;

                $newOrderproduct->update();

            }
        }

        /**
         *  end
         */

        return array("rawCost" => $orderproductsRawCost , 'orderproducts'=>$renewedOrderproducts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->can(Config::get('constants.SHOW_OPENBYADMIN_ORDER')))
            $orders = Order::where("orderstatus_id","<>", Config::get("constants.ORDER_STATUS_OPEN"));
        else
            $orders = Order::where("orderstatus_id","<>",Config::get("constants.ORDER_STATUS_OPEN"))->where("orderstatus_id","<>",Config::get("constants.ORDER_STATUS_OPEN_BY_ADMIN"));


        $createdSinceDate = Input::get('createdSinceDate');
        $createdTillDate = Input::get('createdTillDate');
        $createdTimeEnable = Input::get('createdTimeEnable');
        if(strlen($createdSinceDate)>0 && strlen($createdTillDate)>0 && isset($createdTimeEnable))
        {
            $orders = $this->timeFilterQuery($orders, $createdSinceDate, $createdTillDate, 'created_at');
        }

        $updatedSinceDate = Input::get('updatedSinceDate');
        $updatedTillDate = Input::get('updatedTillDate');
        $updatedTimeEnable = Input::get('updatedTimeEnable');
        if(strlen($updatedSinceDate)>0 && strlen($updatedTillDate)>0 && isset($updatedTimeEnable))
        {
            $orders = $this->timeFilterQuery($orders, $updatedSinceDate, $updatedTillDate, 'updated_at');
        }

        $completedSinceDate = Input::get('completedSinceDate');
        $completedTillDate = Input::get('completedTillDate');
        $completedTimeEnable = Input::get('completedTimeEnable');
        if(strlen($completedSinceDate)>0 && strlen($completedTillDate)>0 && isset($completedTimeEnable))
        {
            $orders = $this->timeFilterQuery($orders, $completedSinceDate, $completedTillDate, 'completed_at');
        }

        $firstName = trim(Input::get('firstName'));
        if(isset($firstName) && strlen($firstName)>0)
        {
            $orders = $orders->whereHas('user', function($q) use ($firstName) {
                $q->where('firstName', 'like', '%' . $firstName . '%');
            });
        }

        $lastName = trim(Input::get('lastName'));
        if(isset($lastName) && strlen($lastName)>0)
        {
            $orders = $orders->whereHas('user', function($q) use ($lastName) {
                $q->where('lastName', 'like', '%' . $lastName . '%');
            });
        }

        $nationalCode = trim(Input::get('nationalCode'));
        if(isset($nationalCode) && strlen($nationalCode)>0)
        {
            $orders = $orders->whereHas('user', function($q) use ($nationalCode) {
                $q->where('nationalCode', 'like', '%' . $nationalCode . '%');
            });
        }

        $mobile = trim(Input::get('mobile'));
        if(isset($mobile) && strlen($mobile)>0)
        {
            $orders = $orders->whereHas('user', function($q) use ($mobile) {
                $q->where('mobile', 'like', '%' . $mobile . '%');
            });
        }

        $orderStatusesId = Input::get('orderStatuses');
//        if(isset($orderStatusesId) && !in_array(0, $orderStatusesId))
        if(isset($orderStatusesId))
        {
            $orders = Order::orderStatusFilter($orders, $orderStatusesId);
        }

        $paymentStatusesId = Input::get('paymentStatuses');
//        if(isset($paymentStatusesId) && !in_array(0, $paymentStatusesId))
        if(isset($paymentStatusesId))
        {
            $orders = Order::paymentStatusFilter($orders, $paymentStatusesId);
        }

        $productsId = Input::get('products');
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

            $orders = $orders->whereHas("orderproducts", function ($q) use ($productsId) {
                    $q->whereIn("product_id", $productsId);
                });
        }

        $extraAttributevaluesId= Input::get('extraAttributes');
        if(isset($extraAttributevaluesId))
        {
            if(isset($productsId) && !in_array(0, $productsId))
            {
                $orders = $orders->whereHas("orderproducts" , function ($q) use ($extraAttributevaluesId,$productsId){
                    $q->whereHas("attributevalues", function ($q) use ($extraAttributevaluesId) {
                        $q->whereIn("value_id", $extraAttributevaluesId);
                    })->whereIn("product_id",$productsId);
                });
            }else{
                $orders = $orders->whereHas("orderproducts" , function ($q) use ($extraAttributevaluesId){
                    $q->whereHas("attributevalues", function ($q) use ($extraAttributevaluesId) {
                        $q->whereIn("value_id", $extraAttributevaluesId);
                    });
                });
            }
        }


        $majorEnable = Input::get('majorEnable');
        $majorsId = Input::get('majors');
        if(isset($majorEnable) && isset($majorsId))
        {
            $orders = Order::UserMajorFilter($orders, $majorsId);
        }


        $couponEnable = Input::get('couponEnable');
        $couponsId = Input::get('coupons');
        if(isset($couponEnable) && isset($couponsId))
        {
            if (in_array(0, $couponsId))
                $orders = $orders->whereDoesntHave("coupon");
            elseif(in_array(-1, $couponsId))
                $orders = $orders->whereHas("coupon");
            else
                $orders = $orders->whereIn("coupon_id", $couponsId);
        }

        $transactionStatusEnable = Input::get('transactionStatusEnable');
        $transactionStatusesId = Input::get('transactionStatuses');
        if(isset($transactionStatusEnable) && isset($transactionStatusesId))
        {
            $orders = $orders->whereHas("transactions", function ($q) use ($transactionStatusesId) {
                $q->whereIn("transactionstatus_id", $transactionStatusesId);
            });
        }

        $checkoutStatusEnable = Input::get('checkoutStatusEnable');
        $checkoutStatusesId = Input::get('checkoutStatuses');
        if(isset($checkoutStatusEnable) && isset($checkoutStatusesId))
        {
            if(isset($productsId) && !in_array(0, $productsId))
            {
                $orders = $orders->whereHas("orderproducts", function ($q) use ($checkoutStatusesId , $productsId) {
                    $q->whereIn("product_id" , $productsId)->where(function ($q2) use ($checkoutStatusesId){
                        if(in_array("0" , $checkoutStatusesId))
                        {
                            $q2->whereIn("checkoutstatus_id", $checkoutStatusesId)->orWhereNull("checkoutstatus_id");
                        }else{
                            $q2->whereIn("checkoutstatus_id", $checkoutStatusesId);
                        }
                    });
                });
            }else{
                    $orders = $orders->whereHas("orderproducts", function ($q) use ($checkoutStatusesId) {
                        if(in_array("0" , $checkoutStatusesId))
                        {
                            $q->whereIn("checkoutstatus_id", $checkoutStatusesId)->orWhereNull("checkoutstatus_id");
                        }else{
                            $q->whereIn("checkoutstatus_id", $checkoutStatusesId);
                        }
                    });
            }

        }

        $withoutPostalCode = Input::get("withoutPostalCode");
        if(isset($withoutPostalCode)) {
            $orders = $orders->whereHas("user" , function ($q){
                $q->where(function ($q){
                    $q->whereNull("postalCode")->orWhere("postalCode" , "");
                });
            });
        }
        else{
            $postalCode = Input::get("postalCode");
            if(isset($postalCode) && strlen($postalCode) > 0) {
                $orders = $orders->whereHas("user" , function ($q) use ($postalCode){
                    $q->where('postalCode', 'like', '%' . $postalCode . '%');
                });
            }
        }

        $withoutProvince = Input::get("withoutProvince");
        if(isset($withoutProvince)) {
            $orders = $orders->whereHas("user" , function ($q){
                $q->where(function ($q){
                    $q->whereNull("province")->orWhere("province" , "");
                });
            });
        }
        else{
            $province = Input::get("province");
            if(isset($province) && strlen($province) > 0) {
                $orders = $orders->whereHas("user" , function ($q) use ($province){
                    $q->where('province', 'like', '%' . $province . '%');
                });
            }
        }

        $withoutCity = Input::get("withoutCity");
        if(isset($withoutCity)) {
            $orders = $orders->whereHas("user" , function ($q){
                $q->where(function ($q){
                    $q->whereNull("city")->orWhere("city" , "");
                });
            });
        }
        else{
            $city = Input::get("city");
            if(isset($city) && strlen($city) > 0) {
                $orders = $orders->whereHas("user" , function ($q) use ($city){
                    $q->where('city', 'like', '%' . $city . '%');
                });
            }
        }

//        $withoutAddress = Input::get("withoutAddress");
//        if(isset($withoutAddress)) {
//            $orders = $orders->whereHas("user" , function ($q){
//                $q->where(function ($q){
//                    $q->whereNull("address")->orWhere("address" , "");
//                });
//            });
//        }
//        else{
//            $address = Input::get("address");
//            if(isset($address) && strlen($address) > 0) {
//                $orders = $orders->whereHas("user" , function ($q) use ($address){
//                    $q->where('address', 'like', '%' . $address . '%');
//                });
//            }
//        }

        $addressSpecialFilter = Input::get("addressSpecialFilter");
        if(isset($addressSpecialFilter)) {
            switch ($addressSpecialFilter){
                case "0":
                    $address = Input::get("address");
                    if(isset($address) && strlen($address) > 0) {
                        $orders = $orders->whereHas("user" , function ($q) use ($address){
                            $q->where('address', 'like', '%' . $address . '%');
                        });
                    }
                    break;
                case "1":
                    $orders = $orders->whereHas("user" , function ($q){
                        $q->where(function ($q){
                            $q->whereNull("address")->orWhere("address" , "");
                        });
                    });
                    break;
                case  "2":
                    $orders = $orders->whereHas("user" , function ($q){
                        $q->where(function ($q){
                            $q->whereNotNull("address")->Where("address" ,"<>", "");
                        });
                    });
                    break;
                default:
                    break;
            }

        }
        else{
            $address = Input::get("address");
            if(isset($address) && strlen($address) > 0) {
                $orders = $orders->whereHas("user" , function ($q) use ($address){
                    $q->where('address', 'like', '%' . $address . '%');
                });
            }
        }

        $withoutSchool = Input::get("withoutSchool");
        if(isset($withoutSchool)) {
            $orders = $orders->whereHas("user" , function ($q){
                $q->where(function ($q){
                    $q->whereNull("school")->orWhere("school" , "");
                });
            });
        }
        else{
            $school = Input::get("school");
            if(isset($school) && strlen($school) > 0) {
                $orders = $orders->whereHas("user" , function ($q) use ($school){
                    $q->where('school', 'like', '%' . $school . '%');
                });

            }
        }

        //customer description , manager comment
        $withoutCustomerDescription = Input::get("withoutOrderCustomerDescription");
        if(isset($withoutCustomerDescription)){
            $orders = $orders->where(function ($q){
                $q->whereNull("customerDescription")->orWhere("customerDescription" , "");
            });
        }
        else{
            $customerDescription = Input::get("orderCustomerDescription");
            if(isset($customerDescription) && strlen($customerDescription) > 0){
                $orders = $orders->where("customerDescription" , "like" , "%" . $customerDescription . "%");
            }
        }

        $withoutManagerComments = Input::get("withoutOrderManagerComments");
        if(isset($withoutManagerComments)){
            $orders = $orders->whereDoesntHave("ordermanagercomments")
                ->orWhereHas("ordermanagercomments" , function ($q){
                    $q->whereNull("comment")->orWhere("comment" , "");
            });
        }
        else{
            $managerComments = Input::get("orderManagerComments");
            if(isset($managerComments) && strlen($managerComments) > 0) {
                $orders = $orders->whereHas("ordermanagercomments", function ($q) use ($managerComments) {
                    $q->where("comment", "like", "%" . $managerComments . "%");
                });
            }
        }

//        $orderCost = Input::get("cost");
//        if(isset($orderCost) && strlen($orderCost) > 0){
//            $compareBy = Input::get("filterByCost");
//            if(isset($compareBy) && (strcmp("$compareBy" , "=") == 0
//                || strcmp("$compareBy" , ">") == 0
//                || strcmp("$compareBy" , "<") == 0))
//            {
//                $orders = $orders
//                    ->whereNull("costwithoutcoupon")->where("cost" , $compareBy , $orderCost)
//                    ->orwhereNull("cost")->where("costwithoutcoupon" , $compareBy , $orderCost)
//                    ->orwhere(function ($q) use ($compareBy, $orderCost){
//                        $q->whereNotNull("costwithoutcoupon")->whereNotNull("cost")->whereRaw("cost+costwithoutcoupon ".$compareBy." ".$orderCost);
//                    });
//            }
//        }
//
//        $discountCost = Input::get("discountCost");
//        if(isset($discountCost) && strlen($discountCost) > 0){
//            $discountCompareBy = Input::get("filterByDiscount");
//            if(isset($discountCompareBy) && (strcmp("$discountCompareBy" , "=") == 0
//                || strcmp("$discountCompareBy" , ">") == 0
//                || strcmp("$discountCompareBy" , "<") == 0))
//            {
//                $orders->where("discount" , $discountCompareBy , $discountCost);
//            }
//        }


        $sortBy = Input::get("sortBy");
        $sortType = Input::get("sortType");
        if(strlen($sortBy) > 0 && strlen($sortType) > 0){
            if(strcmp($sortBy, "userLastName") == 0){
                $orders = $orders->join('users', 'orders.user_id', '=', 'users.id')
                    ->orderBy('users.lastName' , $sortType)
                    ->select('orders.*');
            }
            elseif(strcmp($sortBy, "userFirstName") == 0){
                $orders = $orders->join('users', 'orders.user_id', '=', 'users.id')
                    ->orderBy('users.firstName' , $sortType)
                    ->select('orders.*');
            }
//            elseif(strcmp($sortBy, "productName") == 0){
//                $orders = $orders->join('orderproducts', 'orders.id', '=', 'orderproducts.order_id')->join('products' , 'products.id', '=', 'orderproducts.product_id')->orderBy('products.name' , $sortType)
//                    ->select('orders.*');
//            }
            else {
                $orders = $orders->orderBy($sortBy, $sortType);
            }
        }else
        {
            $orders = $orders->orderBy("updated_at", "desc");
        }


        $orders = $orders->get();

        /**
         *  obtaining orderproducts for checkout
         */
        $myOrderproducts = collect();
        if(isset($productsId))
            foreach ($orders as $order)
            {
                    $checkoutOrderproducts = $order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"));
                    if(in_array(0, $productsId))
                    {
                        foreach ($checkoutOrderproducts->get() as $item)
                        {
                            $myOrderproducts->push($item);
                        }
                    }else
                    {
                        foreach ($checkoutOrderproducts->whereHas("product", function ($q) use ($productsId) {
                            $q->whereIn("id", $productsId)->where(function ($q2){
                                $q2->where("checkoutstatus_id" , 1)->orWhereNull("checkoutstatus_id") ;
                            });
                        })->get() as $item)
                        {
                            $myOrderproducts->push($item);
                        }
                    }
            }
        $result =  array(
            'index' => View::make("order.index", compact('orders' , 'orderstatuses'))->render()
        , 'myOrderproducts'=>$myOrderproducts,
        );

        return response(json_encode($result),200)->header('Content-Type','application/json') ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $customer_id = Input::get("customer_id");
            $customer = User::FindOrFail($customer_id);
            $openOrders = $customer->orders->where("orderstatus_id" , Config::get("constants.ORDER_STATUS_OPEN_BY_ADMIN"));
            if($openOrders->isEmpty()) {
                $request = new Request();
                $request->offsetSet("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_UNPAID"));
                $request->offsetSet("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN_BY_ADMIN"));
                $request->offsetSet("user_id", $customer->id);
                $controller = new OrderController();
                $order = $controller->store($request);
            }
            else
            {
                $order = $openOrders->first();
            }

            if($order){
                session()->put("customer_id" , $customer_id);
                if(strlen($customer->firstName) > 0 ) session()->put("customer_firstName" , $customer->firstName);
                if(strlen($customer->lastName) > 0 )  session()->put("customer_lastName" , $customer->lastName);

                session()->put("adminOrder_id" , $order->id);
                session()->save();
            }else{
                return redirect(action("HomeController@error500"));
            }

        return redirect(action("ProductController@search"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Order
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->fill($request->all());
        if($order->save()) return $order;
        else return false ;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($order)
    {
        $orderstatuses = Orderstatus::pluck('displayName', 'id')->toArray();
        $paymentstatuses = Paymentstatus::pluck('displayName', 'id')->toArray();

        if(!isset($order->coupon->id)){ $order->coupon_id = 0; }

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_add($coupons , 0 , "بدون کپن");
        $coupons = array_sort_recursive($coupons);


        $orderTransactions = $order->successfulTransactions->merge(  $order->pendingTransactions)->merge($order->unpaidTransactions);
        $orderArchivedTransactions = $order->archivedSuccessfulTransactions;
        $transactionPaymentmethods = Paymentmethod::pluck('displayName', 'name')->toArray();
        $offlineTransactionPaymentMethods = Paymentmethod::where("id" ,"<>",Config::get("constants.PAYMENT_METHOD_ONLINE" ))->pluck('displayName', 'id')->toArray();
        $transactionStatuses = Transactionstatus::where("name" ,"<>","transferredToPay")->orderBy("order")->pluck('displayName', 'id')->toArray();

        $products = $this->makeProductCollection();

        return view('order.edit', compact('order', 'orderstatuses','paymentstatuses' , 'coupons', 'orderTransactions', 'transactionstatuses', 'productBon' , 'transactionPaymentmethods' , 'transactionStatuses' , 'products' , 'orderArchivedTransactions' , 'products' , 'offlineTransactionPaymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \app\Http\Requests\EditOrderRequest  $request
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(EditOrderRequest $request, Order $order)
    {
        $oldOrderStatus = $order->orderstatus_id;
        $user = Auth::user();

        if(isset($order->coupon->id)) {
            $oldCoupon = $order->coupon;
        }

        $order->fill($request->all());

        if($request->has("coupon_id"))
        {
            if(isset($oldCoupon)) {
                $oldCoupon->usageNumber = $oldCoupon->usageNumber - 1;
                $oldCoupon->update();//ToDo put if
            }
            if ($order->coupon_id == 0) {
                $order->coupon_id = NULL;
                $order->couponDiscount = 0 ;
                $order->couponDiscountAmount = 0 ;
            }
            else {
                /** Muhammad Shahrokhi
                 * Attention : I don't check coupon validation intentionally because it is admin
                 * update and I beleive it should be able to update submit any coupon for the order
                 * with out any limitations
                 */
                $coupon = Coupon::all()->where("id", $order->coupon_id)->first();
                $order->couponDiscount = $coupon->discount ;
                $coupon->usageNumber = $coupon->usageNumber + 1;
                $coupon->update();

                if(!isset($oldCoupon) )
                {
                    if(!isset($order->cost) || $order->cost == 0)
                    {
                        $order->cost = $order->costwithoutcoupon ;
                        $order->costwithoutcoupon = 0 ;
                    }
                }
                //ToDo put if
            }
        }


        if($request->has('managerDescription')) {
            if ($order->ordermanagercomments->isEmpty()) {
                $managerComment = new Ordermanagercomment();
                if($request->has('managerDescription'))
                    $managerComment->comment = $request->get('managerDescription');
                $managerComment->order_id = $order->id;
                $managerComment->user_id = $user->id;
                $managerComment->save();
            }
            else{
                $order->ordermanagercomments->first()->comment = $request->get('managerDescription');
                $order->ordermanagercomments->first()->user_id = $user->id;
                $order->ordermanagercomments->first()->update();
            }
        }else{
            if (!$order->ordermanagercomments->isEmpty())
            {
                $order->ordermanagercomments->first()->comment = null;
                $order->ordermanagercomments->first()->user_id = $user->id;
                $order->ordermanagercomments->first()->update();
            }
        }

        if ($order->update()) {
            if($request->has("orderstatusSMS"))
            {
                $controller = new HomeController();
                $smsRequest = new SendSMSRequest();
                $fullName = "";
                if(strlen($order->user->firstName)>0)
                    $fullName .= $order->user->firstName;
                if(strlen($order->user->lastName)>0)
                    $fullName .= " ".$order->user->lastName;
                if(strlen($fullName)>0)
                    $smsRequest["message"] = $fullName;
                else
                    $smsRequest["message"] = "کاربر گرامی";
                $smsRequest["message"]  .= " سلام، وضعیت سفارش شما در آلاء به ".$order->orderstatus->displayName." تغییر کرد";
                $smsRequest["users"] = $order->user_id;
                $controller->sendSMS($smsRequest);
            }

            if($request->has('postCode'))
            {
                $postCode = $request->get('postCode');
                if(strlen(preg_replace('/\s+/', '', $postCode ))>0 )
                {
                    $insertPostingInfo = false;
//                    if ($order->orderpostinginfos->isEmpty()) {
                        $postingInfo = new Orderpostinginfo();
                        $postingInfo->postCode = $request->get('postCode');
                        $postingInfo->order_id = $order->id;
                        $postingInfo->user_id = $user->id;
                        if($postingInfo->save())
                            $insertPostingInfo=true;
//                    }
//                    else{
//                        $order->orderpostinginfos->first()->postCode = $request->get('postCode');
//                        if($order->orderpostinginfos->first()->update()) $insertPostingInfo=true;
//                    }
                    if($insertPostingInfo && $request->has('postingSMS')){
                        $myParents  = Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT")->get()->first()->product->parents;
                        if (!empty($myParents)){
                            $rootParent = end($myParents);
                            $productName =$rootParent->name  ;
                        }else{
                             $productName =$order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->get()->first()->product->first()->name ;
                        }


                        $controller = new HomeController();
                        $smsRequest = new SendSMSRequest();
                        $fullName = "";
                        if(strlen($order->user->firstName)>0)
                            $fullName .= $order->user->firstName;
                        if(strlen($order->user->lastName)>0)
                            $fullName .= " ".$order->user->lastName;
                        if(strlen($fullName)>0)
                            $smsRequest["message"] = $fullName;
                        else
                            $smsRequest["message"] = "کاربر گرامی";
                        $smsRequest["message"]  .= " شماره مرسوله پستی ".$productName." ".$request->get('postCode')." می باشد - آلاء";
//                        $smsRequest["message"]  .= " برنامه و دفترچه عید نوروز برای شما پست شد"."\n"."کد رهگیری مرسوله: ".$request->get('postCode')."\n"."آلاء - K96.IR";
                        $smsRequest["users"] = $order->user_id;
                        $response = $controller->sendSMS($smsRequest);
                        if($response->getStatusCode() == 200)
                            $smsMessageSuccess = "پیامک کد رهگیری برای کاربر ارسال شد";
                        else
                            $smsMessageError = "خطا در ارسال پیامک کد رهگیری";

                    }
                }else{}
            }
            $file = $this->requestHasFile($request , "file");
            if ($file !== false) {
                $extension = $file->getClientOriginalExtension();
                $fileName = basename($file->getClientOriginalName() , ".".$extension) . "_" . date("YmdHis") . '.' . $extension;
                if (Storage::disk(Config::get('constants.DISK10'))->put($fileName, File::get($file))) {
                    $orderFileRequest = new Request();
                    $orderFileRequest->offsetSet("order_id" ,  $order->id);
                    $orderFileRequest->offsetSet("user_id" , $user->id);
                    $orderFileRequest->offsetSet("file" , $fileName );
                    $orderFileController = new OrderFileController();
                    $responseStatus = $orderFileController->store($orderFileRequest);
                    if($responseStatus->getStatusCode() != 200)
                        session()->put('error', 'خطا در ذخیره اطلاعات فایل');
                } else {
                    session()->put('error', 'بارگذاری فایل سفارش با مشکل مواجه شد!');
                }
            }
            if(isset($smsMessageSuccess))
                session()->put("success", "اطلاعات سفارش با موفقیت اصلاح شد.".$smsMessageSuccess);
            else
                session()->put("success", "اطلاعات سفارش با موفقیت اصلاح شد");

            if(isset($smsMessageError))
                session()->put("error", $smsMessageError);
        }
        else {
        session()->put("error", "خطای پایگاه داده");
    }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($order)
    {
//        if ($order->delete()) session()->flash('success', 'سفارش با موفقیت اصلاح شد');
//        else session()->flash('error', 'خطای پایگاه داده');
        $order->delete();
        return redirect()->back() ;
    }

    /**
     * Showing authentication step in the checkout process
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function checkoutAuth()
    {
        if(Auth::check())
            return redirect(action("OrderController@checkoutReview"));
        return view("order.checkout.auth");
    }

    /**
     * Showing information completion step in the checkout process
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function checkoutCompleteInfo()
    {
        if(!Auth::check())
            return redirect(action("OrderController@checkoutAuth"));
        $user = Auth::user();
        if($user->completion("afterLoginForm") == 100) {
            session()->pull("success");
            session()->pull("tab");
            session()->pull("belongsTo");
            return redirect(action("OrderController@checkoutReview"));
        }
        $formFields =Afterloginformcontrol::getFormFields();
        $tables = [];
        foreach ($formFields as $formField){
            if(strpos($formField->name, "_id")) {
                $tableName = $formField->name;
                $tableName = str_replace("_id" ,"s" , $tableName);
                $tables[$formField->name] = DB::table($tableName)->pluck('name', 'id');
            }
        }
        $note = "لطفا برای ادامه مراحل اطلاعات زیر را تکمیل نمایید";

        return view("order.checkout.completeInfo" , compact("formFields" , "note" , "tables"));
    }

    private function getUserOrder(){
        $user = Auth::user();
        if(session()->has("adminOrder_id"))
        {
            if(!$user->can(Config::get('constants.INSERT_ORDER_ACCESS')))
                return redirect(action("HomeController@error403"));
            $user_id = session()->get("customer_id");
            $user = User::FindOrFail($user_id);
            $orderstatus_id = Config::get("constants.ORDER_STATUS_OPEN_BY_ADMIN");
        }else
        {
            $orderstatus_id = Config::get("constants.ORDER_STATUS_OPEN");
        }

        $order = $user->orders->where("orderstatus_id" , $orderstatus_id)->first();

        $orderproducts = $order->orderproducts->sortByDesc("created_at");
        return [$user, $order , $orderproducts ] ;
    }
    /**
     * Showing authentication step in the checkout process
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function checkoutReview(Request $request)
    {
        if(!Auth::check())
            return redirect(action("OrderController@checkoutAuth"));

        $url = $request->url();
        $title = "آلاء|بازبینی سفارش";
        SEO::setTitle($title);
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);

        [$user, $order , $orderproducts ] = $this->getUserOrder();

            $renewedOrderproducts = $this->renewOrderproducs($orderproducts);
            $orderproductsRawCost = (int)$renewedOrderproducts["rawCost"];
            $orderproducts = $renewedOrderproducts["orderproducts"];
            $costCollection = collect();
            $orderproductLinks = collect();
            foreach ($orderproducts as $orderproduct)
            {
                $costArray  = $orderproduct->obtainOrderproductCost(false);
                $costCollection->put( $orderproduct->id , ["cost"=>$costArray["cost"] , 'extraCost'=>$costArray["extraCost"] , 'bonDiscount'=>$costArray['bonDiscount'] , "productDiscount"=>$costArray['productDiscount'] , "productDiscountAmount"=>$costArray['productDiscountAmount']]);
                $orderproductLink = $this->makeProductLink($orderproduct->product);
                if(strlen($orderproductLink) > 0)
                    $orderproductLinks->put($orderproduct->id , $orderproductLink);
            }
            $renewedOrder = Order::where("id" , $order->id)->get()->first() ;
            $orderCostArray = $renewedOrder->obtainOrderCost(true);
            $orderCost = $orderCostArray["rawCostWithDiscount"] + $orderCostArray["rawCostWithoutDiscount"];
        $orderHasOrdrooGheireHozoori = $order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
            ->whereIn("product_id" , Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_NOT_DEFAULT"))
            ->get()
            ->isNotEmpty();

        $orderHasDonate = $order->hasProducts(Config::get("constants.DONATE_PRODUCT")) ;

        $donateCost = 0 ;
        if($orderHasDonate)
        {
            $donateCost = config("constants.DONATE_PRODUCT_COST")  ;
        }

        $credit = $user->getTotalWalletBalance();
        $costWithWallet = $orderCost - $donateCost ;
        $walletUse = min($costWithWallet , $credit) ;
        $payableCost = max($orderCost - $walletUse , 0);

        return view("order.checkout.review" , compact("user","orderproducts" , "orderCost" , "orderproductsRawCost" ,
            'costCollection' ,'orderproductLinks' , 'orderHasOrdrooGheireHozoori' , 'credit' , 'walletUse' , 'payableCost'));
    }

    /**
     * Showing the checkout invoice for printing
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function checkoutInvoice()
    {
        if(!Auth::check())
            return redirect(action("OrderController@checkoutAuth"));

        [$user, $order , $orderproducts ] = $this->getUserOrder();
        $costCollection = collect();
        foreach ($orderproducts as $orderproduct)
        {
            $costArray  = $orderproduct->obtainOrderproductCost(false);
            $costCollection->put( $orderproduct->id , ["cost"=>$costArray["cost"] , 'extraCost'=>$costArray["extraCost"] , 'bonDiscount'=>$costArray['bonDiscount']]);

        }
        $orderCostArray = $order->obtainOrderCost(true);
        $orderCost = $orderCostArray["rawCostWithDiscount"] + $orderCostArray["rawCostWithoutDiscount"];
        $user = $order->user ;

        $todayDate = $this->convertDate(Carbon::now()->toDateTimeString() , "toJalali" );
        return view("order.checkout.invoice" , compact("orderproducts" , "orderCost"  , 'costCollection' , 'user' , 'todayDate'));


    }

    /**
     * Showing payment step in checkout the process
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function checkoutPayment(Request $request)
    {
        if(!Auth::check())
            return redirect(action("OrderController@checkoutAuth"));


        $url = $request->url();
        $title = "آلاء | پرداخت";
        SEO::setTitle($title);
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);

        if(session()->has("couponMessageSuccess"))
            session()->flash('success', session()->pull("couponMessageSuccess"));
        elseif(session()->has("couponMessageError"))
            session()->flash('error', session()->pull("couponMessageError"));
        elseif(session()->has("couponMessageInfo"))
            session()->flash('info', session()->pull("couponMessageInfo"));

        $previousPath = url()->previous();
        if(strcmp($previousPath , action("OrderController@checkoutReview"))==0
            || strcmp($previousPath , action("OrderController@checkoutPayment"))==0)
        {
            [$user, $order , $orderproducts ] = $this->getUserOrder();

            if($orderproducts->isNotEmpty())
            {
                $gateways = Transactiongateway::all()->where("enable",1)->sortBy("order")->pluck("displayName" , "name");

                $this->renewOrderproducs($orderproducts);

                $renewedOrder = Order::where("id" , $order->id)->get()->first();
                $orderCost = $renewedOrder->refreshCost()["newCost"];
                $cost = $renewedOrder->totalCost();
                $totalRawCost = $orderCost["rawCostWithDiscount"] + $orderCost["rawCostWithoutDiscount"];

                if($renewedOrder->hasCoupon()) {
                    $validateCouponProduct = $renewedOrder->reviewCoupon();
                    if(strlen($validateCouponProduct["warning"]) >0)  session()->flash('warning', $validateCouponProduct["warning"]);
                    if(strlen($validateCouponProduct["info"]) >0)  session()->flash('info', $validateCouponProduct["info"]);
                    if(strlen($validateCouponProduct["error"]) >0)  session()->flash('error', $validateCouponProduct["error"]);
                    if($validateCouponProduct["couponRemoved"])
                    {
                        $renewedOrder = Order::where("id" , $order->id)->get()->first();
                        $orderCost = $renewedOrder->refreshCost()["newCost"];
                        $cost = $renewedOrder->totalCost();
                        $totalRawCost = $orderCost["rawCostWithDiscount"] + $orderCost["rawCostWithoutDiscount"];
                    }
                }
                $coupon = $renewedOrder->coupon;

                if($cost == 0) {
                    $paymentMethods = array("offlinePayment" => "کارت به کارت");
                }
                else{
//                    $paymentMethods = array("onlinePayment" => "آنلاین" , "offlinePayment" => "کارت به کارت");
                    $paymentMethods = array("onlinePayment" => "آنلاین" );
                }

                $orderHasDonate = $order->hasProducts(Config::get("constants.DONATE_PRODUCT")) ;
                $donateCost = 0 ;
                if($orderHasDonate)
                {
                    $donateCost = config("constants.DONATE_PRODUCT_COST")  ;
                }

                $credit = $user->getTotalWalletBalance();
                $costWithWallet = $cost - $donateCost ;
                $walletUse = min($costWithWallet , $credit) ;
                $payableCost = max($cost - $walletUse , 0);

                return view("order.checkout.payment" , compact("gateways" , "cost" , "coupon" , "paymentMethods" , "orderHasDonate" ,
                    "totalRawCost" , "credit" , "walletPaymentAmount" , "walletUse"  , "payableCost"));
            }else
            {
                return redirect(action("OrderController@checkoutReview"));
            }
        }else {
            return redirect(action("OrderController@checkoutReview"));
        }

    }

    /**
     * Verify customer online payment after comming back from payment gateway
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyPayment(Request $request)
    {
        $sendSMS = false;
        $user = Auth::user();
        if($request->has('Authority') && $request->has('Status') )
        {    // Come back from ZarinPal
            $result["isAdminOrder"] = false;
            $authority = $request->get('Authority');
            $status = $request->get('Status');

            $transaction = Transaction::where('authority' ,$authority)->firstOrFail() ;
            $order = Order::FindorFail($transaction->order_id);

            $usedCoupon = $order->hasUsedCoupon();
            if(!$usedCoupon)
            {
                /** if order has not used coupon reverse it    */

                $order->detachCoupon() ;
            }

            $zarinPal = new Zarinpal($transaction->transactiongateway->merchantNumber,new SoapDriver());

            $result = $zarinPal->verify($status,$transaction->cost,$authority);
            //return $result["status"] = success / canceled
//            if(Auth::user()->hasRole("admin")){
//                $result["Status"]="success";
//                $result["RefID"] = "mohamad1";
//            }
            if(!isset($result))
                    abort(404) ;
            if(strcmp(array_get($result,"Status"),'success')==0)
            {
                $user = $order->user;
                $transaction->transactionID = $result["RefID"] ;
                $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL") ;
                $transaction->completed_at = Carbon::now();
                $transaction->update();

                /** Wallet transactions */
                $order->closeWalletPendingTransactions();
                /** End */
                $order->close(Config::get("constants.PAYMENT_STATUS_PAID")) ;
                if($transaction->cost < (int)$order->totalCost() )
                {
                    if((int)$order->totalPaidCost() < (int)$order->totalCost())
                        $order->paymentstatus_id = Config::get("constants.PAYMENT_STATUS_INDEBTED");
                }

                $order->timestamps = false;
                if($order->update())
                    $result = array_add($result , "saveOrder" , 1);
                else
                    $result = array_add($result , "saveOrder" , 0);
                $order->timestamps = true;

                /** Attaching user bons for this order */
                $bonName = Config::get("constants.BON1");
                $bon = Bon::where("name" , $bonName)->first();
                if(isset($bon))
                {
                    [
                        $givenBonNumber ,
                        $failedBonNumber ] = $order->giveUserBons($bonName);

                    if($givenBonNumber == 0 )
                        if($failedBonNumber > 0)
                            $result = array_add($result , "saveBon" , -1);
                        else
                            $result = array_add($result , "saveBon" , 0);
                    else
                        $result = array_add($result , "saveBon" , $givenBonNumber);

                    $bonDisplayName = $bon->displayName ;
                    $result = array_add($result , "bonName" , $bonDisplayName);
                }

                $sendSMS = true;
            }
            elseif(strcmp(array_get($result,"Status"),'canceled')==0 ||
                (strcmp(array_get($result,"Status"),'error')==0 && strcmp(array_get($result,"error"),'-22')==0) )
            {
                $result["Status"] = 'canceled' ;
                $user = $order->user ;
                if($order->orderstatus_id == Config::get("constants.ORDER_STATUS_OPEN"))
                {
                    $result["tryAgain"] = true;

                    $order->close( Config::get("constants.PAYMENT_STATUS_UNPAID"),Config::get("constants.ORDER_STATUS_CANCELED")) ;
                    $order->timestamps = false;
                    if ($order->update())
                    {
                        $request = new Request();
                        $request->offsetSet("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_UNPAID"));
                        $request->offsetSet("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
                        $response = $this->copy($order , $request);
                    }else
                    {
                        //last order is not closed and no action is necessary
                    }
                    $order->timestamps = true;
                }elseif($order->orderstatus_id == Config::get("constants.ORDER_STATUS_OPEN_DONATE"))
                {
//                    $order->close( Config::get("constants.PAYMENT_STATUS_UNPAID"),Config::get("constants.ORDER_STATUS_CANCELED")) ;
//                    $order->timestamps = false;
//                    $order->update();
//                    $order->timestamps = true;
                    $result["tryAgain"] = false;
                }
                else
                {
                    $result["tryAgain"] = false;
                    $walletTransactions = $order->suspendedTransactions
                                                ->where("paymentmethod_id" , config("constants.PAYMENT_METHOD_WALLET"));
                    $totalWalletRefund = 0 ;
                    $closeOrderFlag = false;
                    foreach ($walletTransactions as $transaction)
                    {
                        $wallet = $transaction->wallet ;
                        $amount = $transaction->cost;
                        if(isset($wallet))
                        {
                            $response =  $wallet->deposit($amount);
                            if($response["result"])
                            {
                                $transaction->delete();
                                $totalWalletRefund += $amount;
                            }
                            else
                            {

                            }
                        }
                        else
                        {
                            $response = $user->deposit($amount , config("constants.WALLET_TYPE_GIFT")) ;
                            if($response["result"])
                            {
                                $transaction->delete();
                                $totalWalletRefund += $amount;
                            }
                            else
                            {

                            }
                        }
                        $closeOrderFlag = true ;

                    }
                    if($totalWalletRefund > 0)
                    {
                        $result["walletAmount"] = $totalWalletRefund;
                        $result["walletRefund"] = true;
                    }

                    if($closeOrderFlag)
                    {
                        $order->close( Config::get("constants.PAYMENT_STATUS_UNPAID"),Config::get("constants.ORDER_STATUS_CANCELED")) ;
                        $order->timestamps = false;
                        $order->update() ;
                        $order->timestamps = true;
                    }
                }
            }
        }
        elseif( $request->has("State") && $request->has("token"))
        {// ENBank gateway
            $result = array();
            $homeController = new HomeController() ;
            $result["isAdminOrder"] = false;
            $state = $request->get("State");
            $token = $request->get("token") ;
            $refNumber = $request->get("RefNum");
            $result["RefID"] = $refNumber ;
            $transaction = Transaction::all()->where('authority' ,$token)->first() ;
            if(!isset($transaction) || $transaction->transactionstatus->id != Config::get("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY") ) return redirect(action(("HomeController@error403")));
            $order = Order::FindorFail($transaction->order_id);

            $usedCoupon = $order->hasUsedCoupon();
            if(!$usedCoupon)
            {
                /** if order has not used coupon reverse it    */

                $order->detachCoupon() ;
            }

            if(strcasecmp($state , "ok") == 0) {
                $result["Status"] = "success" ;
                $enBankGate = Transactiongateway::all()->where('name' ,'enbank')->first() ;
                $amount = $transaction->cost*10 ; // tabdile mablaghe transaction be rial

                $ENBank = new ENPayment();

                $login = $ENBank->login($enBankGate->merchantNumber,$enBankGate->merchantPassword);
                if(isset($login['return']))
                {
                    $login = $login['return'];

                }else{
                    $message = "خطای لاگین در اتصال به بانک" ;
                    return $homeController->errorPage($message);
                }


                $params['login'] = $login;
                $params['amount'] = $amount;
                $params['token']= $token;
                $params['RefNum']= $refNumber;
                $verifyTrans = $ENBank->tokenPurchaseVerifyTransaction($params);
                $logout = $ENBank->logout($login);
                if(isset($verifyTrans['faultcode']))
                {
                    $result["Status"] = "error";
                    $faultDetail = key($verifyTrans["detail"]) ;
                    switch ($faultDetail)
                    {
                        case "WsTransactionNotFoundException":
                            $result["error"] = "-21" ;
                            break;
                        default :
                            break;
                    }


                }elseif(isset($verifyTrans['return'])){
                    $verifyTrans = $verifyTrans['return'];
                    $verifiedTotalAmount = $verifyTrans['resultTotalAmount'];

                    //ToDo : what the verifiedTotalAmount is not number
                    if((int)$verifiedTotalAmount != $amount)
                    {
                        $transaction->cost = $verifiedTotalAmount/10 ;
                    }
                    if($order->orderstatus_id == Config::get("constants.ORDER_STATUS_OPEN"))
                    {
                        session()->forget("order_id");
                    }
                    $user = $order->user;
                    $transaction->referenceNumber = $refNumber ;
                    $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL") ;
                    $transaction->completed_at = Carbon::now();
                    $transaction->update();
                    $order->paymentstatus_id = Config::get("constants.PAYMENT_STATUS_PAID");

                    $order->orderstatus_id = Config::get("constants.ORDER_STATUS_CLOSED");
                    if($transaction->cost < (int)$order->totalCost() )
                    {
                        if((int)$order->totalPaidCost() < (int)$order->totalCost()) $order->paymentstatus_id = Config::get("constants.PAYMENT_STATUS_INDEBTED");
                    }
                    $order->timestamps = false;
                    $order->completed_at = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran');
                    if($order->update())
                        $result = array_add($result , "saveOrder" , 1);
                    else
                        $result = array_add($result , "saveOrder" , 0);
                    $order->timestamps = true;

                    /** Attaching user bons for this order */
                    $bonName = Config::get("constants.BON1");
                    [
                        $givenBonNumber ,
                        $failedBonNumber ] = $order->giveUserBons($bonName);

                    if($givenBonNumber == 0 )
                        if($failedBonNumber > 0)
                            $result = array_add($result , "saveBon" , -1);
                        else
                            $result = array_add($result , "saveBon" , 0);
                    else
                        $result = array_add($result , "saveBon" , $givenBonNumber);
                    $result = array_add($result , "bonName" , $bonName);
                }

            }
            elseif(strcasecmp($state , "Canceled By User") == 0){
                $result["Status"] = "canceled" ;
                $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_UNSUCCESSFUL") ;
                $transaction->update();
                if($order->orderstatus_id == Config::get("constants.ORDER_STATUS_OPEN")) {
                    $result["tryAgain"] = true;
                    $order->orderstatus_id = Config::get("constants.ORDER_STATUS_CANCELED");
                    $order->paymentstatus_id = Config::get("constants.PAYMENT_STATUS_UNPAID");
                    $order->timestamps = false;
                    $order->completed_at = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran');
                    if ($order->update()) {
                        $request = new Request();
                        $request->offsetSet("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_UNPAID"));
                        $request->offsetSet("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
                        $response = $this->copy($order , $request);
                    } else {
                        //last order is not closed and no action is necessary
                    }
                    $order->timestamps = true;
                }else{
                    $result["tryAgain"] = false;
                }

            }
        }
        else
        {
            $result = array();
            if(session()->has("adminOrder_id"))
            {
                $result["isAdminOrder"] = true;

                if(!$user->can(Config::get('constants.INSERT_ORDER_ACCESS')))
                    return redirect(action("HomeController@error403"));

                $order_id = session()->get("adminOrder_id");
                $order = Order::FindorFail($order_id);

                $result["customer_firstName"] = session()->get("customer_firstName");
                $result["customer_lastName"] = session()->get("customer_lastName");
                session()->forget("adminOrder_id");
                session()->forget("customer_id");
                session()->forget("customer_firstName");
                session()->forget("customer_lastName");
            }
            elseif(session()->has("closedOrder_id"))
            {
                $result["isAdminOrder"] = false;

                $order_id = session()->get("closedOrder_id");
                session()->forget("closedOrder_id");
                $order = Order::FindorFail($order_id);

                if($order->user->id != $user->id)
                    abort(403);
            }
            elseif(session()->has("order_id"))
            {
                $result["isAdminOrder"] = false;

                $order_id = session()->get("order_id");
                session()->forget("order_id");
                $order = Order::FindorFail($order_id);

                if($order->orderstatus_id != Config::get("constants.ORDER_STATUS_OPEN"))
                    abort(403);
                if($order->user->id != $user->id)
                    abort(403);
            }
            else
            {
                abort(404);
            }

            if($order->orderproducts->isEmpty())
                return redirect(action("OrderController@checkoutReview"));

            if($request->has("customerDescription"))
            {
                $customerDescription = $request->get("customerDescription");
                $order->customerDescription = $customerDescription;
            }
            if($request->has('paymentmethod'))
            {
                $paymentMethod = $request->get('paymentmethod');

                $usedCoupon = $order->hasUsedCoupon();
                if(!$usedCoupon)
                {
                    /** if order has not used coupon reverse it    */
                    $order->detachCoupon() ;
                }

                $debitCard = Bankaccount::all()->where("user_id" , 2)->first();
                if(isset($debitCard))
                {
                    $result["debitCardNumber"] = $debitCard->cardNumber;
                    $result["debitCardBank"] = $debitCard->bank->name ;
                    $result["debitCardOwner"] = $debitCard->user->firstName ." ".$debitCard->user->lastName;
                }

                switch ($paymentMethod)
                {
                    case "inPersonPayment" :
                        $result["Status"] = "inPersonPayment";
                        break;
                    case "offlinePayment":

                        $result["Status"] = "offlinePayment";
                        break;
                    default :
                        return redirect(action(("HomeController@error404"))) ;
                        break;
                }

                $order->close(Config::get("constants.PAYMENT_STATUS_UNPAID")) ;
                $order->timestamps = false;
                if($order->update())
                    $result = array_add($result , "saveOrder" , 1);
                else
                    $result = array_add($result , "saveOrder" , 0);
                $order->timestamps = true;
                $sendSMS = true;

            }
            else
            {
                /** Wallet transactions */
                $order->closeWalletPendingTransactions();
                /** End */
                $cost = $order->totalCost() - $order->totalPaidCost();

                if($cost == 0 &&
                    (isset($order->cost) || isset($order->costwithoutcoupon)) )
                {
                    $order->close(Config::get("constants.PAYMENT_STATUS_PAID")) ;
                    $order->timestamps = false;
                    if($order->update())
                        $result = array_add($result , "saveOrder" , 1);
                    else
                        $result = array_add($result , "saveOrder" , 0);
                    $order->timestamps = true;
                    /** Attaching user bons for this order */
                    $bonName = Config::get("constants.BON1");
                    $bon = Bon::where("name" , $bonName)->first();
                    if(isset($bon))
                    {
                        [
                            $givenBonNumber ,
                            $failedBonNumber ] = $order->giveUserBons($bonName);

                        if($givenBonNumber == 0 )
                            if($failedBonNumber > 0)
                                $result = array_add($result , "saveBon" , -1);
                            else
                                $result = array_add($result , "saveBon" , 0);
                        else
                            $result = array_add($result , "saveBon" , $givenBonNumber);

                        $bonDisplayName = $bon->displayName ;
                        $result = array_add($result , "bonName" , $bonDisplayName);
                    }
                    $result["Status"] = "freeProduct";
                    $sendSMS = true;
                }
            }
        }

        /**
         * Sending SMS to Ordoo 97 customers
         */
        if($sendSMS && isset($order))
        {
            $user = $order->user;
            $user->notify(new InvoicePaid($order));
            Cache::tags('bon')->flush();
        }


        if(isset($result["Status"]))
        {
            if(isset($result["RefID"]) || strcmp($result["Status"],'freeProduct')==0)
            {
                session()->put("verifyPayment" , 1) ;
                return redirect(action("OrderController@successfulPayment" , [
                    "result" => $result
                ]));
            }elseif(strcmp($result["Status"],'canceled')==0 ||
                (strcmp($result["Status"],'error')==0 && isset($result["error"]) && strcmp($result["error"],'-22')==0))
            {
                if(isset($result["tryAgain"]) && $result["tryAgain"])
                {
                    session()->put("verifyPayment" , 1) ;
                    return redirect(action("OrderController@failedPayment" , [
                        "result" => $result
                    ]));
                }
            }
        }

        return redirect(action("OrderController@otherPayment" , [
            "result" => $result
        ]));

//        return view('order.checkout.verification',compact('result')) ;
        //'Status'(index) going to be 'success', 'error' or 'canceled'
    }

    /**
     * Successful payments
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     function successfulPayment(Request $request)
     {
         if(session()->has("verifyPayment"))
         {
             $flag = true;
             session()->forget("verifyPayment") ;
         }
         else
         {
             $flag = false;
         }

         if(!$flag)
             return redirect(action("HomeController@error403"));
         if($request->has("result"))
         {
             $result = $request->get("result");
             return view('order.checkout.verification',compact('result')) ;
         }
         else
         {
             return redirect(action("HomeController@error403"));
         }
     }

    /**
     *  repeat an old payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function failedPayment(Request $request)
    {
        if(session()->has("verifyPayment"))
        {
            $flag = true;
            session()->forget("verifyPayment") ;
        }
        else
        {
            $flag = false;
        }

        if(!$flag)
            return redirect(action("HomeController@error403"));
        if($request->has("result"))
        {
            $result = $request->get("result");
            return view('order.checkout.verification',compact('result')) ;
        }
        else
        {
            return redirect(action("HomeController@error403"));
        }
    }

    /**
     *  Payments other than successful and failed
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function otherPayment(Request $request)
    {
        if($request->has("result"))
        {
            $result = $request->get("result");
            return view('order.checkout.verification',compact('result')) ;
        }
        else
        {
            abort(404);
        }
    }


    /**
     * Submits a coupon for the order
     *
     * @param \App\Http\Requests\SubmitCouponRequest $request
     * @return \Illuminate\Http\Response
     */
    public function submitCoupon(SubmitCouponRequest $request){
        $couponCode = $request->coupon;
        $coupon = Coupon::all()->where("code" , $couponCode)->first();
        $user = Auth::user();
        if(isset($coupon)){
            if(session()->has("adminOrder_id"))
            {
                if(!$user->can(Config::get('constants.INSERT_ORDER_ACCESS')))
                    return redirect(action("HomeController@error403"));
                $order_id = session()->get("adminOrder_id");
                $order = Order::FindorFail($order_id);
            }else
            {
                $order_id = session()->get("order_id");
                $order = Order::where("id" , $order_id)->get()->first() ;
                if($order->user->id != $user->id )
                    return redirect(action("HomeController@error403"));
            }

            [
                $validateCoupon ,
                $validateCouponCode
            ] = $coupon->validateCoupon();

            if(strlen($validateCoupon)==0)
            {
                $order->refreshCost();
                $cost = $order->totalCost();
                if(!isset($coupon->maxCost) || $cost <= $coupon->maxCost)
                {
                    if(isset($order->coupon->id)) {
                        $oldCoupon = $order->coupon;
                        $flag = ($oldCoupon->usageNumber > 0);
                        if ($oldCoupon->id != $coupon->id)
                        {
                            if ($flag) $oldCoupon->usageNumber = $oldCoupon->usageNumber - 1;
                            if ($oldCoupon->update()) {
                                $coupon->usageNumber = $coupon->usageNumber + 1;
                                if ($coupon->update()) {
                                    $order->coupon_id = $coupon->id;
                                    if($coupon->discounttype_id == Config::get("constants.DISCOUNT_TYPE_COST")) {
                                        $order->couponDiscount = 0;
                                        $order->couponDiscountAmount = (int)$coupon->discount;
                                    }
                                    else {
                                        $order->couponDiscount = $coupon->discount;
                                        $order->couponDiscountAmount = 0;
                                    }
                                    $order->timestamps = false;
                                    if ($order->update()) {
                                        session()->put('couponMessageSuccess', 'کپن شما با موفقیت ثبت شد!');
                                    } else {
                                        if ($flag) $oldCoupon->usageNumber = $oldCoupon->usageNumber + 1;
                                        $oldCoupon->update();
                                        $coupon->usageNumber = $coupon->usageNumber - 1;
                                        $coupon->update();
                                        session()->put('couponMessageError', "خطای پایگاه داده در ثبت کپن!");
                                    }
                                    $order->timestamps = true;
                                } else {
                                    if ($flag) $oldCoupon->usageNumber = $oldCoupon->usageNumber + 1;
                                    $oldCoupon->update();
                                    session()->put('couponMessageError', "خطای پایگاه داده در ثبت کپن!");
                                }
                            } else {
                                session()->put('couponMessageError', "خطای پایگاه داده در ثبت کپن!");
                            }
                        }
                    }else
                    {
                        $coupon->usageNumber = $coupon->usageNumber + 1 ;
                        if($coupon->update())
                        {
                            $order->coupon_id = $coupon->id;
                            if($coupon->discounttype_id == Config::get("constants.DISCOUNT_TYPE_COST")) {
                                $order->couponDiscount = 0;
                                $order->couponDiscountAmount = (int)$coupon->discount;
                            }
                            else {
                                $order->couponDiscount = $coupon->discount;
                                $order->couponDiscountAmount = 0;
                            }
                            $order->timestamps = false;
                            if($order->update()) {
                                session()->put('couponMessageSuccess', 'کپن شما با موفقیت ثبت شد!');
                            }
                            else{
                                $coupon->usageNumber = $coupon->usageNumber - 1 ;
                                $coupon->update();
                                session()->put('couponMessageError', "خطای پایگاه داده در ثبت کپن!");
                            }
                            $order->timestamps = true;
                        }else
                        {
                            session()->put('couponMessageError', "خطای پایگاه داده در ثبت کپن!");
                        }
                    }
                }
                else{
                    session()->put('couponMessageError', "حداکثر مبلغ سبد خرید برای استفاده از این کپن ".number_format($coupon->maxCost)." تومان  می باشد.");
                }
            }else{
                session()->put('couponMessageError', $validateCoupon);
            }

        }else{
            session()->put('couponMessageError', "کد وارد شده اشتباه می باشد");
        }
        return redirect()->back();
    }

    /**
     * Cancels a coupon for the order
     *
     * @return \Illuminate\Http\Response
     */
    public function removeCoupon(){
        $user = Auth::user();
        if(session()->has("adminOrder_id"))
        {
            if(!$user->can(Config::get('constants.INSERT_ORDER_ACCESS')))
                return redirect(action("HomeController@error403"));
            $order_id = session()->get("adminOrder_id");
            $order = Order::FindorFail($order_id);
        }else
        {
            $order_id = session()->get("order_id");
            $order = Order::FindorFail($order_id);
            if($order->user->id != $user->id)
                return redirect(action("HomeController@error403"));
        }

        $result = $order->detachCoupon();
        if($result)
        {
            if($order->update())
                session()->put('couponMessageSuccess', "کپن سفارش شما با موفیت حذف شد");
            else
                session()->put('couponMessageError', "خطای پایگاه داده");
        }
        else
        {
            session()->put('couponMessageError', "خطای پایگاه داده");
        }

        return redirect()->back();
    }

    public function exitAdminInsertOrder(){
        Session::forget("customer_id") ;
        Session::forget("customer_firstName") ;
        Session::forget("customer_lastName") ;
        Session::forget("adminOrder_id") ;
        return redirect(action("ProductController@search"));
    }

    public function addOrderproduct(Request $request , Product $product)
    {
        try
        {
            $user = Auth::user();
            if($request->has("cost"))
                $cost = $request->get("cost");

            $orderMode = "";
            if($request->has("mode"))
                $orderMode = $request->get("mode");

            $forceStore = false;
            switch ($orderMode)
            {
                case "normal":
                    $openOrder = $user->openOrders()
                        ->get()
                        ->first();
                    break;
                case "donate":
                    $openOrder = Order::where("user_id" , $user->id)
                                        ->where("orderstatus_id" , config()->get("constants.ORDER_STATUS_OPEN_DONATE"))
                                        ->first();
                    // chon order taze sakhte shode in code order ro peida nemikonad va user->fresh ham kar nemikone
//                    $openOrder = $user->orders
//                        ->where("orderstatus_id" , config()->get("constants.ORDER_STATUS_OPEN_DONATE"))
//                        ->first();
                    break;
                default:
                    if($request->has("orderId_bhrk"))
                    {
                        $orderId = $request->get("orderId_bhrk");
                        $openOrder = Order::where("id" , $orderId)
                                    ->first();
                        $forceStore = true;
                    }
                    break;
            }

            if(isset($openOrder))
            {
                $restorableProducts = Config::get("constants.DONATE_PRODUCT") ;
                $createFlag = true;
                if(in_array($product->id , $restorableProducts))
                {
                    $oldOrderproduct = $openOrder->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))
                        ->whereIn("product_id" , $restorableProducts )
                        ->onlyTrashed()
                        ->get() ;
                    if( $oldOrderproduct->isNotEmpty())
                    {
                        $deletedOrderproduct = $oldOrderproduct->first() ;
                        $deletedOrderproduct->restore();
                        $createFlag = false;
                    }
                }

                if($createFlag)
                {
                    $request = new Request();
                    $request->offsetSet("product_id" ,  $product->id);
                    $request->offsetSet("order_id" ,  $openOrder->id);
                    if($forceStore)
                        $request->offsetSet("forceStore_bhrk" ,  true);
                    if(isset($cost))
                        $request->offsetSet("cost_bhrk" ,  $cost);
                    $orderproductController = new OrderproductController();
                    $orderproductController->store($request) ;
                }

                $openOrder->fresh();
                $orderCost = $openOrder->obtainOrderCost(true , false) ;
                $openOrder->cost = $orderCost["rawCostWithDiscount"];
                $openOrder->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
                $openOrder->timestamps = false;
                $updateFlag = $openOrder->update();
                $openOrder->timestamps = true;
                $cost = $openOrder->totalCost();

                if($updateFlag)
                    return $this->response
                        ->setStatusCode(200)
                        ->setContent(["cost"=>$cost]);
                else
                    return $this->response
                        ->setStatusCode(503)
                        ->setContent(["errorMessage"=>"could not update order"]);
            }
            return $this->response
                ->setStatusCode(503)
                ->setContent(["errorMessage"=>"cound not find order"]);
        }catch (\Exception    $e)
        {
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

    public function removeOrderproduct(Product $product , Request $request , OrderproductController $orderproductController)
    {
        $user = Auth::user();

        $openOrder = $user->openOrders()->get()->first();
        //ToDo : if($openOrders->count()>1)

        if(isset($openOrder))
        {
            $orderproduct = $openOrder->orderproducts->where("product_id" , $product->id)->first();
            if(!isset($orderproduct))
                return $this->response->setStatusCode(503)->setContent(["message"=>"محصول مورد نظر در سبد وجود ندارد"]);
            $orderproductController->destroy($orderproduct) ;

            $newOpenOrder = $user->orders->where("id" , $openOrder->id)->first();

            $orderCost = $newOpenOrder->obtainOrderCost(true , false) ;
            $newOpenOrder->cost = $orderCost["rawCostWithDiscount"];
            $newOpenOrder->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
            $newOpenOrder->timestamps = false;
            $updateFlag = $newOpenOrder->update();
            $newOpenOrder->timestamps = true;
            $cost = $newOpenOrder->totalCost();

            if($updateFlag)
                return $this->response->setStatusCode(200)->setContent(["cost"=>$cost]);
            else
                return $this->response->setStatusCode(503)->setContent(["message"=>"خطای پایگاه داده"]);
        }

        return $this->response->setStatusCode(503)->setContent(["message"=>"خطای غیر منتظره"]);

    }

    /**
     * Detach orderproducts from their order
     *
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function detachOrderproduct(Request $request)
    {
        $orderproductsId = $request->get("orderproducts");
        $orderId = $request->get("order") ;

        $orderproducts = Orderproduct::whereIn("id" , $orderproductsId)->get();
        $flagOrder = $orderproducts->first()->order->id ;
        foreach ($orderproducts as $orderproduct)
        {
            if($flagOrder == $orderproduct->order->id) {
                if ($orderproduct->order->id != $orderId)
                    return $this->response->setStatusCode(503)->setContent(["message"=>"درخواست غیر مجاز"]);
            }else{
                return $this->response->setStatusCode(503)->setContent(["message"=>"درخواست غیر مجاز"]);
            }
                $flagOrder = $orderproduct->order->id ;
        }

        $oldOrder = Order::FindOrFail($orderId) ;

        if($orderproducts->count() >= $oldOrder->orderproducts ->where("orderproducttype_id" , "<>" , Config::get("constants.ORDER_PRODUCT_GIFT"))->count()) return $this->response->setStatusCode(503)->setContent(["message"=>"شما نمی توانید سفارش را خالی کنید"]);

        $oldOrderBackup = $oldOrder->replicate() ;
        $newOrder = $oldOrder->replicate() ;
        if(!$newOrder->save())
        {
            return $this->response->setStatusCode(503)->setContent(["message"=>"خطا درایجاد سفارش جدید"]);
        }

        foreach ($orderproducts as $orderproduct)
        {
            $gifts = $orderproduct->children;
            foreach ($gifts as $gift)
            {
                $gift->order_id = $newOrder->id ;
                $gift->update();
            }
            $orderproduct->order_id = $newOrder->id ;
            $orderproduct->update() ;
        }

        /**
         * Reobtaining old order cost
         */
        $oldOrder = Order::where("id" , $oldOrder->id)->get()->first();
        $orderCost = $oldOrder->obtainOrderCost(true , false , "REOBTAIN") ;
        $oldOrder->cost = $orderCost["rawCostWithDiscount"];
        $oldOrder->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
        $oldOrder->timestamps = false;
        $oldOrderDone = $oldOrder->update();
        $oldOrder->timestamps = true;
        if($oldOrderDone)
        {

            /**
             * obtaining new order cost
             */
                $newOrder = Order::where("id" , $newOrder->id)->get()->first();
                $newOrder->created_at =  Carbon::now();
                $newOrder->updated_at =  Carbon::now();
                $newOrder->completed_at =  Carbon::now();
                $newOrder->discount = 0 ;
                $orderCost = $newOrder->obtainOrderCost(true , false , "REOBTAIN") ;
                $newOrder->cost = $orderCost["rawCostWithDiscount"];
                $newOrder->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
                $newOrderDone = $newOrder->update();
                if($newOrderDone)
                {
                    /**
                     * Transactions
                     */
                    $newCost = $newOrder->totalCost() ; //$newOrder->totalCost() ;
//                  if(($newOrder->totalCost() + $oldOrder->totalCost()) != $oldOrder->successfulTransactions->sum("cost") ) abort("403") ;
                    $transactions = $oldOrder->successfulTransactions->where("cost",">" , 0 )->sortBy("cost");
                    foreach ($transactions as $transaction)
                    {
                        if($newCost <= 0 ) break ;
                        if($transaction->cost > $newCost)
                        {
                            $newTransaction = new Transaction() ;
                            $newTransaction->destinationBankAccount_id = $transaction->destinationBankAccount_id;;
                            $newTransaction->paymentmethod_id = $transaction->paymentmethod_id ;
                            $newTransaction->transactiongateway_id = $transaction->transactiongateway_id;
                            $newTransaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL") ;
                            $newTransaction->cost = $newCost ;
                            $newTransaction->order_id = $newOrder->id;
                            $newTransaction->save();

                            $newTransaction2 = new \App\Transaction() ;
                            $newTransaction2->cost = $transaction->cost - $newCost ;
                            $newTransaction2->destinationBankAccount_id = $transaction->destinationBankAccount_id;
                            $newTransaction2->paymentmethod_id = $transaction->paymentmethod_id ;
                            $newTransaction2->transactiongateway_id = $transaction->transactiongateway_id;
                            $newTransaction2->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL") ;
                            $newTransaction2->order_id = $oldOrder->id;
                            $newTransaction2->save();

                            if($transaction->getGrandParent() !== false)
                            {
                                $grandTransaction = $transaction->getGrandParent() ;
                                $newTransaction->parents()->attach($grandTransaction->id,["relationtype_id"=>Config::get("constants.TRANSACTION_INTERRELATION_PARENT_CHILD")]) ;
                                $newTransaction2->parents()->attach($grandTransaction->id,["relationtype_id"=>Config::get("constants.TRANSACTION_INTERRELATION_PARENT_CHILD")]) ;
                                $grandTransaction->children()->detach($transaction->id) ;
                                $transaction->delete() ;
                            }else{
                                $newTransaction->parents()->attach($transaction->id,["relationtype_id"=>Config::get("constants.TRANSACTION_INTERRELATION_PARENT_CHILD")]) ;
                                $newTransaction2->parents()->attach($transaction->id,["relationtype_id"=>Config::get("constants.TRANSACTION_INTERRELATION_PARENT_CHILD")]) ;
                                $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_ARCHIVED_SUCCESSFUL") ;
                                $transaction->update();
                            }

                            $newCost = 0 ;

                        }else
                        {
                            $transaction->order_id = $newOrder->id;
                            $transaction->update();
                            $newCost = $newCost - $transaction->cost ;
                        }
                    }
                    /**
                     * End
                     */

                    if($newOrder->totalPaidCost() >= (int)$newOrder->totalCost())
                    {
                        $newOrder->paymentstatus_id = Config::get("constants.PAYMENT_STATUS_PAID");
                        $newOrder->update();
                    }

                session()->put("success" , "سفارش با موفقیت تفکیک شد . رفتن به سفارش جدید : "."<a target='_blank' href='".action('OrderController@edit' , $newOrder)."'>".$newOrder->id."</a>");
                return $this->response->setStatusCode(200)->setContent(["orderId"=>$newOrder->id]);
            }   else{
                $oldOrder->fill($oldOrderBackup->toArray());
                foreach ($orderproducts as $orderproduct)
                {
                    $orderproduct->order_id = $oldOrder->id ;
                    $orderproduct->update() ;
                }
                if($oldOrder->update()){
                    return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در آپدیت سفارش جدید ایجاد شده . سفارش قدیم بدون تغییر ماند."]);
                }else{
                    return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در آپدیت سفارش جدید ایجاد شده . سفارش قدیم دچار تغییرات شد."]);
                }
            }
        }else{
            return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در آپدیت اطلاعات سفارش قدیم"]);
        }


    }

    /**
     * Exchange some order products
     *
     * @param Order $order
     * @param  \Illuminate\Http\Request $request
     * @param TransactionController $transactionController
     * @return \Illuminate\Http\RedirectResponse
     */
    public function exchangeOrderproduct(Order $order , Request $request , TransactionController $transactionController)
    {
        $done = false;
        $exchangeArray1 = $request->get("exchange-a");
        foreach ($exchangeArray1 as $key => $item)
        {
            $newProduct = Product::where("id" , $item["orderproductExchangeNewProduct"])->get()->first();
            if(isset($newProduct)) {
                $done = true;
                $orderproduct = Orderproduct::where("id", $key)->get()->first();
                if ($orderproduct->order_id != $order->id) continue;
                if (isset($orderproduct)) {
                    $orderproduct->product_id = $newProduct->id;
                    if(strlen( preg_replace('/\s+/', '',$item["orderproductExchangeNewCost"])) > 0)
                        $orderproduct->cost = $item["orderproductExchangeNewCost"];
                    if(strlen( preg_replace('/\s+/', '',$item["orderproductExchangeNewDiscountAmount"])) > 0)
                        $orderproduct->discountAmount = $item["orderproductExchangeNewDiscountAmount"];
                    $orderproduct->discountPercentage = 0;
                    $orderproduct->includedInCoupon = 0;
                    $orderproduct->userbons()->detach($orderproduct->userbons->pluck("id")->toArray());
                    $orderproduct->update();
                }
            }
        }

        $exchangeArray2 = $request->get("exchange-b");
            foreach ($exchangeArray2 as $item)
            {
                $newProduct = Product::where("id" , $item["newOrderproductProduct"])->get()->first();
                if(isset($newProduct)) {
                    $done = true;
                    $orderproduct = new Orderproduct();
                    $orderproduct->product_id = $newProduct->id;
                    $orderproduct->order_id = $order->id;
                    if(strlen( preg_replace('/\s+/', '',$item["neworderproductCost"])) > 0)
                        $orderproduct->cost = $item["neworderproductCost"];
                    $orderproduct->save();
                }
            }
        if($request->has("orderproductExchangeTransacctionCheckbox"))
        {
            $done = true;
            $request->offsetSet("order_id" , $order->id);
            $transactionRequest =  new InsertTransactionRequest();
            $transactionRequest->offsetSet("order_id" , $order->id);
            $cost = $request->get("cost");
            if($request->has("cost")) $transactionRequest->offsetSet("cost" , -$cost);
            if(strlen( preg_replace('/\s+/', '',$request->get("traceNumber"))) != 0  )
                $transactionRequest->offsetSet("traceNumber" , $request->get("traceNumber"));
            if(strlen(preg_replace('/\s+/', '',$request->get("referenceNumber"))) != 0  )
                $transactionRequest->offsetSet("referenceNumber" , $request->get("referenceNumber"));
            if(strlen(preg_replace('/\s+/', '',$request->get("paycheckNumber"))) != 0 )
                $transactionRequest->offsetSet("paycheckNumber" , $request->get("paycheckNumber"));
            if(strlen( preg_replace('/\s+/', '',$request->get("managerComment"))) != 0  )
                $transactionRequest->offsetSet("managerComment" , $request->get("managerComment"));
            $transactionRequest->offsetSet("destinationBankAccount_id" , 1);
            if($request->has("paymentmethod_id"))
                $transactionRequest->offsetSet("paymentmethod_id" , $request->get("paymentmethod_id"));
            if($request->has("transactionstatus_id"))
                $transactionRequest->offsetSet("transactionstatus_id" , $request->get("transactionstatus_id"));

            $transactionController->store($transactionRequest);
            session()->forget("success");
            session()->forget("error");
        }

        if($done)
        {
            $newOrder = Order::where("id" , $order->id)->get()->first();
            $orderCost = $newOrder->obtainOrderCost(true , false , "REOBTAIN") ;
            $newOrder->cost = $orderCost["rawCostWithDiscount"];
            $newOrder->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
            $newOrderDone = $newOrder->update();
            if($newOrderDone) session()->put("success" , "عملیات تعویض آیتم های سفارش یا موفقیت انجام شد");
            else session()->put("error" , "خطا در بروز رسانی قیمت سفارش");
            return redirect()->back();
        }else{
            session()->put("warning" , "عملیاتی انجام نشد");
            return redirect()->back();
        }

    }

    /**
     * Makes a copy from an order
     *
     * @param Order $order
     * @param  \Illuminate\Http\Request $request
     * @param \App\Http\Controllers\OrderController $orderController
     */
    public  function copy(Order $order ,Request $request)
    {
        $failed = true;
        $copyOrderRequest = new Request();
        if($request->has("paymenrstatus_id"))
            $copyOrderRequest->offsetSet("paymentstatus_id", $request->get("paymenrstatus_id"));
        if($request->has("orderstatus_id"))
            $copyOrderRequest->offsetSet("orderstatus_id", $request->get("orderstatus_id"));
        $copyOrderRequest->offsetSet("user_id", $order->user_id);
        $copyOrderRequest->offsetSet("coupon_id", $order->coupon_id);
        $copyOrderRequest->offsetSet("couponDiscount", $order->couponDiscount);
        $copyOrderRequest->offsetSet("couponDiscountAmount", $order->couponDiscountAmount);
        $copyOrderRequest->offsetSet("checkOutDateTime", $order->checkOutDateTime);
        $orderController = new  OrderController() ;
        $newOrder = $orderController->store($copyOrderRequest);
        if ($newOrder) {
            $orderproducts = $order->orderproducts;
            foreach ($orderproducts as $orderproduct)
            {
                $newOrderproduct = new Orderproduct();
                $newOrderproduct->product_id = $orderproduct->product_id;
                $newOrderproduct->order_id = $newOrder->id;
                $newOrderproduct->quantity = $orderproduct->quantity;
                if ($newOrderproduct->save())
                {
                    $userbons = $orderproduct->userbons;
                    foreach ($userbons as $userbon)
                    {
                        $newOrderproduct->userbons()
                            ->attach($userbon->id, ["usageNumber" => $userbon->pivot->usageNumber , "discount"=>$userbon->pivot->discount]);
                    }
                    foreach ($orderproduct->attributevalues as $value)
                    {
                        if ($orderproduct->product->hasParents()) {
                            $myParent = $this->makeParentArray($orderproduct->product);
                            $myParent = end($myParent);
                            $attributevalue = $myParent->attributevalues->where("id", $value->id);
                        }
                        else
                        {
                            $attributevalue = $orderproduct->product->attributevalues->where("id", $value->id);
                        }
                        if (!$attributevalue->isEmpty()) {
                            $newOrderproduct->attributevalues()
                                ->attach($attributevalue->first()->id, ["extraCost" => $attributevalue->first()->pivot->extraCost]);
                        } else {
                        }
                    }
                    $failed = false;
                } else
                {
                    // he just lost one of last orders items in his new order
                }
            }

        } else
        {
            // the new order was not created and no action is necessary.in fact he just lost his last order to add to.
        }

        if($request->has("fromAPI"))
        {
            if(!$failed)
                return $this->response
                            ->setStatusCode(200);
            else
                return $this->response
                    ->setStatusCode(503);
        }
        else{

        }
    }

    /**
     * Makes a donate request
     *
     * @param Order $order
     * @param \App\Http\Requests\DonateRequest $request
     */
    public function donateOrder(DonateRequest $request)
    {
        $amount = $request->get("amount") ;
        $user = Auth::user();
        $donateOrders = $user->orders->where("orderstatus_id", config("constants.ORDER_STATUS_OPEN_DONATE")) ;
        if($donateOrders->isNotEmpty())
        {
            $donateOrder = $donateOrders->first();
        }
        else
        {
            $donateOrder = new Order();
            $donateOrder->orderstatus_id = config("constants.ORDER_STATUS_OPEN_DONATE") ;
            $donateOrder->paymentstatus_id = config("constants.PAYMENT_STATUS_PAID") ;
            $donateOrder->user_id = $user->id ;
            if($donateOrder->save())
            {
                $user->fresh();
                //ToDo
            }
        }
        $request->offsetSet("mode" , "donate");
        $request->offsetSet("cost" , $amount);
        $product = Product::FindOrFail(config("constants.CUSTOM_DONATE_PRODUCT")) ;
        $response = $this->addOrderproduct($request , $product) ;
        $responseStatus = $response->getStatusCode();
        $result = json_decode($response->getContent());
        if($responseStatus == 200)
        {
            if(isset($result->cost))
                $cost = $result->cost;
            if(isset($cost))
            {
                $request = new Request();
                $request->offsetSet("gateway" , "zarinpal");
                $request->offsetSet("order_id" , $donateOrder->id);
                $request->offsetSet("forcePay_bhrk" , true);
                $transactionController = new TransactionController();
                $result =  $transactionController->paymentRedirect($request);
//                dd($result);
            }
        }
        else
        {
//            dd($result);
        }
        return redirect()->back();

    }

    public function addToArabiHozouri(Request $request)
    { //Adding user to Hamayesh Houzori Arabi 27 Khordad
        try
        {
            $user = Auth::user();
            $done =false;
            $hamayeshHozouriProductId = 223;
            $hamayeshTalaiProductId = 214;
            $hamayeshTalai = $user->orders()
                                ->whereHas("orderproducts" , function ($q) use ($hamayeshTalaiProductId){
                                    $q->where("product_id" , $hamayeshTalaiProductId);
                                })
                                ->where("orderstatus_id" , config("constants.ORDER_STATUS_CLOSED"))
                                ->where("paymentstatus_id" , config("constants.PAYMENT_STATUS_PAID"))
                                ->first();

            if(!isset($hamayeshTalai))
                return $this->response
                    ->setStatusCode(503)
                    ->setContent([
                        "message"=>"شما همایش طلایی عربی ندارد"
                    ]);

            $hozouriOrders = $user->orders()
                ->whereHas("orderproducts" , function ($q) use ($hamayeshHozouriProductId){
                    $q->where("product_id" , $hamayeshHozouriProductId);
                })
                ->where("orderstatus_id" , config("constants.ORDER_STATUS_CLOSED"))
                ->where("paymentstatus_id" , config("constants.PAYMENT_STATUS_PAID"))
                ->get();
            if($hozouriOrders->isNotEmpty())
            {
                return $this->response
                    ->setStatusCode(503)
                    ->setContent(["message"=>"شما قبلا در همایش حضوری ثبت نام کرده اید"]);
            }
            else
            {
                $hozouriOrder = new Order();
                $hozouriOrder->orderstatus_id = config("constants.ORDER_STATUS_CLOSED") ;
                $hozouriOrder->paymentstatus_id = config("constants.PAYMENT_STATUS_PAID") ;
                $hozouriOrder->cost = 0 ;
                $hozouriOrder->costwithoutcoupon = 0;
                $hozouriOrder->user_id = $user->id ;
                $hozouriOrder->completed_at = Carbon::now()->setTimezone("Asia/Tehran");
                if($hozouriOrder->save())
                {
                    $request->offsetSet("cost" , 0);
                    $request->offsetSet("orderId_bhrk" , $hozouriOrder->id);
                    $product =  Product::where("id" , $hamayeshHozouriProductId)->first();
                    if(isset($product))
                    {
                        $response = $this->addOrderproduct($request , $product) ;
                        $responseStatus = $response->getStatusCode();
                        $result = json_decode($response->getContent());
                        if($responseStatus == 200)
                        {
                            $done = true;
                        }
                        else
                        {
                            $done = false;
                        }
                    }
                    else
                    {
                        $done = false;
                    }
                }
                else
                {
                    $done =false;
                }
            }

            if($done)
            {
                return $this->response->setStatusCode(200);
            }
            else
            {
                return $this->response->setStatusCode(503);
            }
        }
        catch (\Exception    $e) {
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
}
