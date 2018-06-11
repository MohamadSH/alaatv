<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Bon;
use App\Checkoutstatus;
use App\Http\Requests\InsertUserBonRequest;
use App\Order;
use App\Orderproduct;
use App\Product;
use App\Traits\ProductCommon;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class OrderproductController extends Controller
{
    use ProductCommon;
    protected $response ;

    function __construct()
    {
        $this->response = new Response();
        $this->middleware('auth', ['only' => ['destroy' , 'edit' , 'update']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_id = $request->get("product_id");
        $product = Product::FindorFail($product_id) ;
        $user = Auth::user();
        $ajax = request()->ajax();

        if( ( Auth::check() &&
                !$user->can(Config::get('constants.ORDER_ANY_THING')) ) &&
                !session()->has("adminOrder_id") &&
                ! $request->has("forceStore_bhrk"))
        {
            $validateProduct = $product->validateProduct();
            if (strlen($validateProduct) != 0) {
                if($ajax)
                {
                    return $this->response->setStatusCode(503)->setContent(["message"=>$validateProduct]);
                }
               else
               {
                    session()->put("error", $validateProduct);
                    return redirect()->back();
               }

            }
        }

        $parentProductType = $product->producttype->name;
        if($request->has("attribute") ||
            $product->producttype_id == Config::get("constants.PRODUCT_TYPE_SIMPLE")
          )
        {
            switch ($parentProductType)
            {
                case "configurable" :
                    if(session()->has("adminOrder_id"))$children = $product->children;
                    else $children = $product->children->where("enable" , 1);

                    foreach($children as $child)
                    {
                        $attributevalues = $child->attributevalues;
                        $flag = true;
                        foreach($request->get("attribute") as $value)
                        {
                            if(!$attributevalues->contains($value)) {
                                $flag = false;
                                break;
                            }
                        }
                        if($flag && $attributevalues->count() == count($request->get("attribute"))) {
                            $simpleProducts = [$child];
                            break;
                        }

                    }
                    break;
                case "simple" :
                    if(session()->has("adminOrder_id"))
                        $children = $product->children;
                    else $children = $product->children->where("enable" , 1);

                    $simpleProducts = [$product] ;
                    break;
                default: break;
            }
        }
        elseif($request->has("products"))
        {
            $products = $request->get("products");
            $simpleProducts = array();
            foreach ($products as $key => $productId)
            {
                $simpleProduct = Product::FindOrFail($productId);
                if(!$simpleProduct->enable) continue;
                if($simpleProduct->hasParents())
                {
                    if(in_array($simpleProduct->parents->first()->id , $products))
                    {
                        array_forget($products , $key);
                        $childrenArray = $simpleProduct->children;
                        foreach ($childrenArray as $child)
                        {
                            array_forget($products , array_flip($products)[$child->id]);
                        }
                    }
                }
                if(in_array($productId , $products))
                    array_push($simpleProducts , $simpleProduct);
            }
        }
        else
        {
            $message = "لطفا ابتدا در قسمت \"انتخاب محصول\" تیک محصولات مورد نظرتون رو بزنید(انتخاب کنید)";
            if($ajax)
            {
                return $this->response->setStatusCode(503)->setContent(["message"=>$message]);
            }
            else
            {
                session()->put("error" , $message);
                return redirect()->back();
            }
        }
        if(isset($simpleProducts))
        {
            if($parentProductType != "simple")
                foreach ($simpleProducts as $simpleProduct){
                    $validateProduct = $simpleProduct->validateProduct();
                    if(strlen($validateProduct) != 0){
                        session()->put("warning" , $validateProduct);
                        return redirect()->back();
                    }
                }
        }
        else{
            $message = "محصول مورد نظر شما غیر فعال شده است";
            if($ajax)
            {
                return $this->response->setStatusCode(503)->setContent(["message"=>$message]);
            }
            else
            {
                session()->put("warning" ,$message );
                return redirect()->back();
            }
        }
        if(Auth::check()){
            /**
             * Determines it is an order by admin or by a user
             */
            if($request->has("order_id"))
            {
                $order_id = $request->get("order_id");
            }
            elseif(session()->has("adminOrder_id"))
            {
                if(!$user->can(Config::get('constants.INSERT_ORDER_ACCESS')))
                {
                    if($ajax)
                    {
                        return $this->response->setStatusCode(403);
                    }
                    else
                    {
                        return redirect(action("HomeController@error403"));
                    }
                }

                $order_id = session()->get("adminOrder_id");
                $user_id = session()->get("customer_id");
                $user = User::FindOrFail($user_id);
            }else
            {
                $order_id = session()->get("order_id");

            }

            $order = Order::FindorFail($order_id);
            if($order->user->id != $user->id)
            {
                if($ajax)
                {
                    return $this->response->setStatusCode(403);
                }
                else
                {
                    return redirect(action("HomeController@error403"));
                }
            }
            /**
             * end
             */
                $hasPishtazExtraValue = false ;
                $attachedGifts = collect();
                foreach ($simpleProducts as $simpleProduct)
                {
                    $orderproduct = new Orderproduct();
                    $orderproduct->product_id = $simpleProduct->id;
                    $orderstatus = $order->orderstatus->id;

                    $donateFlag = false;
                    if(isset($orderstatus) && $orderstatus == config("constants.ORDER_STATUS_OPEN_DONATE"))
                        $donateFlag = true;

                    if($order->orderproducts->isNotEmpty())
                    {
                        $orderHasProduct = false ;
                        foreach ($order->orderproducts as $singleOrderproduct)
                        {
                            if($donateFlag)
                            {
                                $singleOrderproduct->delete();
                            }
                            elseif($simpleProduct->id == $singleOrderproduct->product->id)
                            {
                                $orderHasProduct = true ;
                                continue ;
                            }

                        }
                        if($orderHasProduct) continue ;
                    }
                    $orderproduct->order_id = $order->id;
                    if($orderproduct->save())
                    {
                        /**
                         * Adding selected extra attributes to the orderproduct
                         */
                        $extraAttributes = $request->get("extraAttribute");
                        if(isset($extraAttributes))
                            foreach($extraAttributes as $value)
                            {
                                $myParent = $this->makeParentArray($simpleProduct);
                                $myParent = end($myParent);
                                $attributevalue = $myParent->attributevalues->where("id" , $value);
                                if($attributevalue->isNotEmpty())
                                {
                                    if($attributevalue->first()->id != 48 || !$hasPishtazExtraValue) $orderproduct->attributevalues()->attach($attributevalue->first()->id,["extraCost"=>$attributevalue->first()->pivot->extraCost]);
                                    if($attributevalue->first()->id == 48 ) $hasPishtazExtraValue = true ;
                                }
                            }
                        /**
                         * end
                         */

                        /**
                         * Obtaining product amount
                         */
                        if(isset($simpleProduct->amount)) {
                            $simpleProduct->amount = $simpleProduct->amount - 1;
                            $simpleProduct->update();
                        }
                        /**
                         * end
                         */

                        $isFreeFlag = ($simpleProduct->isFree || ($simpleProduct->hasParents() && $simpleProduct->parents()->first()->isFree)) ;
                        if(!$isFreeFlag &&
                            $simpleProduct->basePrice != 0 &&
                            $simpleProduct->basePrice != 0)
                        {
                            /**
                             *  User bon discount for this orderproduct
                             */
                            $bonName = Config::get("constants.BON1");
                            $bons = $simpleProduct->bons->where("name" , $bonName)->where("pivot.discount",">","0")->where("isEnable" , 1);
                            if($bons->isEmpty()){
                                $parentsArray = $this->makeParentArray($simpleProduct);
                                if(!empty($parentsArray))
                                {
                                    foreach ($parentsArray as $parent)
                                    {
                                        $bons= $parent->bons->where("name" , $bonName)->where("pivot.discount",">","0")->where("isEnable" , 1);
                                        if(!$bons->isEmpty()) break ;
                                    }
                                }
                            }
                            if(!$bons->isEmpty())
                            {
                                $bon = $bons->first();
                                $userbons = $user->userValidBons($bon);
                                if(!$userbons->isEmpty())
                                {
                                    foreach ($userbons as $userbon)
                                    {
                                        $totalBonNumber = $userbon->totalNumber - $userbon->usedNumber;
                                        $orderproduct->userbons()->attach($userbon->id , ["usageNumber"=>$totalBonNumber,"discount"=>$bon->pivot->discount]);
                                        $userbon->usedNumber = $userbon->usedNumber + $totalBonNumber;
                                        $userbon->userbonstatus_id = Config::get("constants.USERBON_STATUS_USED");
                                        $userbon->update();
                                    }
                                }
                            }
                            /**
                             * end
                             */
                        }

                        /**
                         * Saving orderproduct cost
                         */
                            $costArray = array() ;

                            if($request->has("cost_bhrk"))
                            {
                                $costArray["cost"] = $request->get("cost_bhrk") ;
                            }
                            else
                            {
                                $costArray = $orderproduct->obtainOrderproductCost();
                            }
                            $orderproduct->fillCostValues($costArray);

                            $updateFlag =  $orderproduct->update();
                        /**
                         *  end
                         */

                        /**
                         * Attaching simple product gifts to the order
                         */
                        //ToDo: what if he has added the gift before
                        $gifts = $simpleProduct->getGifts();
                        foreach ($gifts as $gift)
                        {
                            if($attachedGifts->contains($gift->id)) continue;
                            else $attachedGifts->push($gift->id);
                            if($order->orderproducts(Config::get("constants.ORDER_PRODUCT_GIFT"))->whereHas("product" , function($q) use($gift){
                                $q->where("id" , $gift->id);
                            })->get()->isNotEmpty()) continue;
                            $orderproduct->attachGift($gift) ;
                        }
                        /**
                         *    end
                         */

                    }
                    //ToDo : replace with appropriate error page
//                    else exit("خطای پایگاه داده");
                }

        }
        else
        {
            if(!session()->has('orderproducts')){
                $products = array();
            }else{
                $products = session()->pull("orderproducts" );
            }
            $orderproductAttributes = array();
            foreach ($simpleProducts as $simpleProduct)
            {
                $gifts = $simpleProduct->getGifts();
                if (!array_has($products, $simpleProduct->id))
                    $products = array_add($products, $simpleProduct->id, ["amount"=>1 , "gifts"=>$gifts]);


                $extraAttributes = $request->get("extraAttribute");
                if(isset($extraAttributes)) {
                    $extraAttributeArray = array();
                    foreach ($extraAttributes as $value) {
                        $myParent = $this->makeParentArray($simpleProduct);
                        $myParent = end($myParent);
                        $attributevalue = $myParent->attributevalues->where("id", $value);

                        if ($attributevalue->isNotEmpty()) {
                            $extraAttributeArray = array_add($extraAttributeArray ,$attributevalue->first()->id , $attributevalue->first()->pivot->extraCost );
                        }
                    }
                    if(array_has($orderproductAttributes ,$simpleProduct->id))
                        array_set($orderproductAttributes, $simpleProduct->id ,$extraAttributeArray);
                    else
                        $orderproductAttributes = array_add($orderproductAttributes, $simpleProduct->id ,$extraAttributeArray);
                    session()->put("orderproductAttributes" , $orderproductAttributes);
                }
            }

            session()->put("orderproducts" , $products);

            session()->save();
        }

        if($ajax)
        {
            return $this->response->setStatusCode(200)->setContent(["redirectUrl"=>action("OrderController@checkoutAuth")]);
        }
        else
        {
            return redirect(action("OrderController@checkoutAuth"));
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
     * @param  \App\Orderproduct  $orderproduct
     * @return \Illuminate\Http\Response
     */
    public function edit($orderproduct)
    {
        $products = $this->makeProductCollection();
        $extraSelectCollection = collect();
        $extraCheckboxCollection = collect();
        $attributeSet = $orderproduct->product->attributeset ;
        $extraAttributes = Attribute::whereHas("attributegroups", function ($q) use ($attributeSet)
        {
            $q->where("attributetype_id" , 2);
            $q->where("attributeset_id" , $attributeSet->id);
        })->get();
        foreach ($extraAttributes as $attribute)
        {
            $orderproductAttributevalues = $orderproduct->attributevalues->where("attribute_id" , $attribute->id);
            $controlName = $attribute->attributecontrol->name;
            $attributevalues = $attribute->attributevalues->where("attribute_id" , $attribute->id)->sortBy("order");
            if(!$attributevalues->isEmpty())
            {
                switch ($controlName)
                {
                    case "select":
                        $select = array();
                        $extraCostArray = array() ;
                        foreach ($attributevalues as $attributevalue)
                        {
                            if($orderproductAttributevalues->contains($attributevalue->id))
                                $extraCost = $orderproductAttributevalues->where("id" ,$attributevalue->id )->first()->pivot->extraCost ;
                            else
                                $extraCost = null ;
                            $attributevalueIndex = $attributevalue->name ;
                            $select= array_add($select , $attributevalue->id , $attributevalueIndex) ;
                            $extraCostArray = array_add($extraCostArray , $attributevalue->id , $extraCost) ;
                        }
                        $select[0]="هیچکدام";
                        $select = array_sort_recursive($select);
                        if(!empty($select)) $extraSelectCollection->put( $attribute->id, ["attributeDescription"=>$attribute->displayName , "attributevalues"=>$select , "extraCost"=>$extraCostArray]);
                        break;
                    case "groupedCheckbox":
                        $groupedCheckbox = collect();
                        foreach ($attributevalues as $attributevalue)
                        {
                            $attributevalueIndex = $attributevalue->name ;
                            if($orderproductAttributevalues->contains($attributevalue->id))
                                $extraCost = $orderproductAttributevalues->where("id" ,$attributevalue->id )->first()->pivot->extraCost ;
                            else
                                $extraCost = null ;
                            $groupedCheckbox->put($attributevalue->id , ["index"=>$attributevalueIndex , "extraCost"=>$extraCost]) ;
                        }
                        if(!empty($groupedCheckbox)) $extraCheckboxCollection->put( $attribute->displayName , $groupedCheckbox);
                        break;
                    default: break;
                }
            }
        }
        $orderproductCost = $orderproduct->obtainOrderproductCost(false);
        $defaultExtraAttributes = $orderproduct->attributevalues->pluck("id")->toArray();
        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);
        return view("order.orderproduct.edit" , compact("orderproduct"  , "products" , "extraSelectCollection" , "extraCheckboxCollection" , "orderproductCost" , "defaultExtraAttributes" , "checkoutStatuses"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orderproduct  $orderproduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orderproduct , UserbonController $userbonController)
    {
        $cancelOldDiscount = false ;
        $orderproduct->fill($request->all());

        if(strlen($orderproduct->checkoutstatus_id) == 0 ) $orderproduct->checkoutstatus_id = null;

        //ToDo :
        $orderproduct->attributevalues()->detach($orderproduct->attributevalues->pluck("id")->toArray());
        if($request->has("extraAttribute"))
        {

            $extraAttributes = $request->get("extraAttribute");
            foreach($extraAttributes as $value)
            {
                if($value > 0)
                {
                    if (isset($request->get("extraCost")[$value])) $extraCost = $request->get("extraCost")[$value];
                    else $extraCost = 0;
                    if ($extraCost > 0) {
                        $orderproduct->attributevalues()->attach($value, ["extraCost" => $extraCost]);
                    }
                }
            }
        }

        if($request->has("changeProduct"))
        {
            $newProduct = Product::where("id",($request->get("newProductId")))->get()->first();
            if(isset($newProduct)) {
                $orderproduct->product_id = $newProduct->id;
                if(isset($newProduct->amount)) $newProduct->amount = $newProduct->amount - 1;
                $newProduct->update();
                $orderproduct->product_id = $newProduct->id;
                if($request->has("newProductBonPlus"))
                {
                    $bon = Bon::all()->where('name' , Config::get("constants.BON1"))->where('isEnable' , 1)->first();
                    if(isset($bon))
                    {
                        $bonPlus = $newProduct->calculateBonPlus($bon->id) ;
                        if($bonPlus > 0){
                            $request = new InsertUserBonRequest();
                            $request->offsetSet("bon_id" ,  $bon->id);
                            if(isset($orderproduct->order->user->id))
                                $request->offsetSet("user_id" ,  $orderproduct->order->user->id);
                            $request->offsetSet("totalNumber" ,  $bonPlus);
                            $request->offsetSet("orderproduct_id" ,  $orderproduct->id);
                            $request->offsetSet("userbonstatus_id" ,  Config::get("constants.USERBON_STATUS_ACTIVE"));
                            $response = $userbonController->store($request);
                            if($response->getStatusCode() == 200)
                            {
                                //ToDo
                            }else{

                            }
                        }
                    }
                }
            }
        }

        if($request->has("changeCost"))
        {
            if(strlen($request->get("cost")) > 0 )
            {
                $cancelOldDiscount = true;
            }
        }elseif(isset($newProduct))
        {
            $cancelOldDiscount = true;
            $orderproduct->cost = $request->get("newProductCost") ;
        }

        if($cancelOldDiscount)
        {
            $orderproduct->userbons()->detach($orderproduct->userbons->pluck("id")->toArray());
            $orderproduct->includedInCoupon = 0 ;
            $orderproduct->discountPercentage = 0;
            $orderproduct->discountAmount = 0;
        }

        if($orderproduct->update())
        {
            $order = Order::where("id" , $orderproduct->order_id)->get()->first();
            if(isset($order)) {
                $orderCost = $orderproduct->order->obtainOrderCost(true, false);
                $orderproduct->order->cost = $orderCost["rawCostWithDiscount"];
                $orderproduct->order->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
                $orderproduct->order->timestamps = false;
                $orderproduct->order->update();
                $orderproduct->order->timestamps = true;
            }
            session()->put("success", "محصول سفارش با موفقیت اصلاح شد");
        }else
        {
            session()->put("error", "خطای پایگاه داده در اصلاح کالای سفارش");
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \app\Orderproduct  $orderproduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orderproduct $orderproduct)
    {
        $orderproduct_userbons = $orderproduct->userbons;
        foreach ($orderproduct_userbons as $orderproduct_userbon){
            $orderproduct_userbon->usedNumber = $orderproduct_userbon->usedNumber - $orderproduct_userbon->pivot->usageNumber;
            $orderproduct_userbon->userbonstatus_id = Config::get("constants.USERBON_STATUS_ACTIVE");
            if($orderproduct_userbon->usedNumber>=0) $orderproduct_userbon->update();
        }
        if ($orderproduct->delete()) $deleteFlag = true;
        else $deleteFlag = false ;

        $previousRoute = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();
        if(strcmp($previousRoute , "order.edit") == 0)
        {
            $orderCost = $orderproduct->order->obtainOrderCost(true , false);
            $orderproduct->order->cost = $orderCost["rawCostWithDiscount"];
            $orderproduct->order->costwithoutcoupon = $orderCost["rawCostWithoutDiscount"];
            $orderproduct->order->timestamps = false;
            $orderproduct->order->update();
            $orderproduct->order->timestamps = true;
        }

        if($deleteFlag)
        {
            foreach($orderproduct->children as $child)
            {
                $child->delete();
            }
            return $this->response->setStatusCode(200)->setContent(["message"=>"محصول سفارش با موفقیت حذف شد!"]);
        }
        else
        {
            return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در حذف محصول سفارش"]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkOutOrderproducts( Request $request)
    {
        $orderproductIds = $request->get("orderproducts");
        $newCheckoutstatus_id = $request->get("checkoutStatus");
        foreach ($orderproductIds as $orderproductId)
        {
            $orderproduct = Orderproduct::where("id" , $orderproductId["id"])->get()->first() ;
            if(isset($orderproduct))
            {
                $orderproduct->checkoutstatus_id = $newCheckoutstatus_id ;
                $orderproduct->update();
            }
        }
        return $this->response->setStatusCode(200);
    }
}
