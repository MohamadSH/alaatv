<?php

namespace App\Http\Controllers\Web;

use App\Bon;
use App\Repositories\OrderproductRepo;
use App\User;
use App\Order;
use App\Product;
use App\Attribute;
use App\Orderproduct;
use App\Attributevalue;
use App\Checkoutstatus;
use App\Websitesetting;
use App\Traits\OrderCommon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\ProductCommon;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\QueryBuilder;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Collection\OrderproductCollection;
use App\Http\Requests\InsertUserBonRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\OrderProduct\OrderProductStoreRequest;
use App\Http\Requests\OrderProduct\AttachExtraAttributesRequest;
use App\Classes\OrderProduct\RefinementProduct\RefinementFactory;

class OrderproductController extends Controller
{
    use OrderCommon;
    use ProductCommon;

    public function index(Request $request){
        $timeFilterEnable = $request->get('dateFilterEnable');
        $checkoutEnable = $request->get('checkoutEnable');
        $checkoutStatus = $request->get('checkoutStatus');
        $pageNumber = ($request->get('page' , 0) - 1);
        $productIds = $request->get('product_id',[]);

        $since = null;
        $till = null ;
        if($timeFilterEnable)
        {
            $since = Carbon::createFromFormat('Y-n-j H:i:s', explode(' ' , $request->since)[0].' 00:00:00');
            $till = Carbon::createFromFormat('Y-n-j H:i:s', explode(' ' , $request->till)[0].' 23:59:59');
        }

        if($checkoutStatus == 0){
            $chechoutFilter = OrderproductRepo::CHECKOUT_ALL;
        }elseif($checkoutStatus == 1){
            $chechoutFilter = OrderproductRepo::NOT_CHECKEDOUT_ORDERPRODUCT;
        }else{
            $chechoutFilter = OrderproductRepo::CHECKEDOUT_ORDERPRODUCT;
        }

        if(in_array(0,$productIds))
            $productIds = [];
        $orderproducts = OrderproductRepo::getPurchasedOrderproducts( $productIds , $since , $till , $chechoutFilter)
            ->with(['order', 'order.transactions' , 'order.normalOrderproducts'])->get();

        $totalNubmer = $orderproducts->count();

        if($pageNumber > 1)
        {
            $orderproducts->chunk(20)[$pageNumber];
            return response()->json([
                'orderproducts' => $orderproducts,
                'totalNumber'   => $totalNubmer,
            ]);
        }

        $totalSale = 0;
        foreach ($orderproducts as $orderproduct) {
            $toAdd = $orderproduct->getSharedCostOfTransaction() ;
            $totalSale += $toAdd;
        }

        $checkoutResult = false;
        if($checkoutEnable){
            $checkoutResult = Orderproduct::whereIn('id' , $orderproducts->pluck('id')->toArray())->update(['checkoutstatus_id' => config('constants.ORDERPRODUCT_CHECKOUT_STATUS_PAID')]);
        }

        $orderproducts = $orderproducts->chunk(20)[max($pageNumber , 0)];
        return response()->json([
            'orderproducts' => $orderproducts,
            'totalNumber'   => $totalNubmer,
            'totalSale'     => number_format((int)$totalSale),
            'checkoutResult'    =>  $checkoutResult,
        ]);
    }

    function __construct()
    {
        $this->middleware('auth', [
            'only' => [
                'destroy',
                'edit',
                'update',
            ],
        ]);
        $this->middleware([
            'CheckPermissionForSendOrderId',
            /*'checkPermissionForSendExtraAttributesCost'*/
        ], [
            'only' => ['store'],
        ]);
        $this->middleware('CheckPermissionForSendExtraAttributesCost', ['only' => ['attachExtraAttributes']]);
    }
    
    public function store(OrderProductStoreRequest $request)
    {
        if ($request->has('extraAttribute')) {
            if (!$request->user()
                ->can(config('constants.ATTACH_EXTRA_ATTRIBUTE_ACCESS'))) {
                $productId        = $request->get('product_id');
                $product          = Product::findOrFail($productId);
                $attributesValues = $this->getAttributesValuesFromProduct($request, $product);
                $this->syncExtraAttributesCost($request, $attributesValues);
                $request->offsetSet('parentProduct', $product);
            }
        }
        
        $result        = $this->new($request->all());
        $orderproducts = $result['data']['storedOrderproducts'];
        
        return response()->json([
            'orderproducts' => $orderproducts,
        ]);
    }
    
    /**
     * @param  Request  $request
     * @param  Product  $product
     *
     * @return Collection|null
     */
    public function getAttributesValuesFromProduct(Request $request, Product $product): ?Collection
    {
        $extraAttributes   = $request->get('extraAttribute');
        $extraAttributesId = array_column($extraAttributes, 'id');
        $attributesValues  = $product->getAttributesValueByIds($extraAttributesId);
        
        return $attributesValues;
    }
    
    /**
     * @param  Request     $request
     * @param  Collection  $attributesValues
     */
    public function syncExtraAttributesCost(Request $request, Collection $attributesValues)
    {
        $extraAttributes = $request->get('extraAttribute');
        foreach ($attributesValues as $key => $attributesValue) {
            foreach ($extraAttributes as $key1 => $extraAttribute) {
                if ($extraAttribute['id'] == $attributesValue['id']) {
                    $extraAttributes[$key1]['cost']   = $attributesValue->pivot->extraCost;
                    $extraAttributes[$key1]['object'] = $attributesValue;
                }
            }
        }
        $request->offsetSet('extraAttribute', $extraAttributes);
    }
    
    /**
     * Saves a new Orderproduct
     *
     * @param  array  $data
     *
     * @return array
     */
    public function new(array $data): array
    {
        $report = [
            'status'  => true,
            'message' => [],
            'data'    => [],
        ];
        
        //ToDo : discuss getting order from request /** @var Order $order */
        /*if(isset($data['order'])) {
            $order = $data['order'];
        } else {
            $order = Order::FindorFail($orderId)->first();
        }*/
        
        $data = array_merge([
            'product_id'     => null,
            'order_id'       => null,
            'products'       => null,
            'attribute'      => null,
            'extraAttribute' => null,
            'withoutBon'     => null,
        ], $data);
        
        $productId = $data['product_id'];
        $orderId   = $data['order_id'];
        
        try {
            $order   = Order::FindorFail($orderId);
            $product = Product::FindorFail($productId);
        } catch (ModelNotFoundException $e) {
            report($e);
            $report['status']    = false;
            $report['message'][] = 'Unknown order or product';
            
            return $report;
        }
        $user = $order->user;
        
        $simpleProducts = (new RefinementFactory($product, $data))->getRefinementClass()
            ->getProducts();
        
        $notDuplicateProduct = $order->checkProductsExistInOrderProducts($simpleProducts);
        
        if (count($simpleProducts) != 0 && count($notDuplicateProduct) == 0) {
            $report['status']           = false;
            $report['message'][]        = 'This product has been added to order before';
            $report['data']['products'] = $simpleProducts;
        } else {
            if (count($simpleProducts) == 0) {
                $report['status']           = false;
                $report['message'][]        = 'No products has been selected';
                $report['data']['products'] = $simpleProducts;
            }
        }
        
        $storedOrderproducts = new OrderproductCollection();
        /**
         * save orderproduct and attach extraAttribute
         */
        foreach ($notDuplicateProduct as $key => $productItem) {
            $orderProduct                      = new Orderproduct();
            $orderProduct->product_id          = $productItem->id;
            $orderProduct->order_id            = $order->id;
            $orderProduct->orderproducttype_id = config('constants.ORDER_PRODUCT_TYPE_DEFAULT');
            if (isset($data['cost'])) {
                $orderProduct->cost = $data['cost'];
            }
            if (!$orderProduct->save()) {
                continue;
            }
            $productItem->decreaseProductAmountWithValue(1);
            
            if (isset($data['extraAttribute'])) {
                $attachExtraAttributesRequest = new AttachExtraAttributesRequest();
                $attachExtraAttributesRequest->offsetSet('extraAttribute', $data['extraAttribute']);
                $this->attachExtraAttributes($attachExtraAttributesRequest, $orderProduct);
            }
            
            $this->applyOrderProductBon($data, $user, $orderProduct, $productItem);
            
            $this->applyOrderGifts($order, $orderProduct, $productItem);
            
            $storedOrderproducts->push($orderProduct);
        }
        
        $report['data']['storedOrderproducts'] = $storedOrderproducts;

        return $report;
    }
    
    /**
     * @param  AttachExtraAttributesRequest  $request
     * @param  Orderproduct                  $orderProduct
     */
    public function attachExtraAttributes(AttachExtraAttributesRequest $request, Orderproduct $orderProduct): void
    {
        $extraAttributes = $request->get('extraAttribute');
        foreach ($extraAttributes as $value) {
            $orderProduct->attributevalues()
                ->attach($value['id'], [
                    'extraCost' => $value['cost'],
                ]);
        }
    }
    
    /**
     * @param  array         $data
     * @param  User          $user
     * @param  Orderproduct  $orderProduct
     * @param  Product       $product
     */
    private function applyOrderProductBon(array $data, User $user, Orderproduct $orderProduct, Product $product): void
    {
        $bonName = config('constants.BON1');
        
        $bon = $product->getTotalBons($bonName);
        
        $canApplyBon = $this->canApplyBonForRequest($data, $product, $bon);
        if (!$canApplyBon) {
            return;
        }
        
        $userValidBons = $user->userValidBons($bon->first());
        
        if ($userValidBons->isNotEmpty()) {
            $orderProduct->applyBons($userValidBons, $bon->first());
        }
    }
    
    /**
     * @param  array       $data
     * @param  Product     $product
     * @param  Collection  $bon
     *
     * @return bool
     */
    private function canApplyBonForRequest(array $data, Product $product, Collection $bon): bool
    {
        if (!isset($data['withoutBon']) || !$data['withoutBon']) {
            return $product->canApplyBon($bon);
        } else {
            return false;
        }
    }
    
    public function edit($orderproduct)
    {
        $products                = $this->makeProductCollection();
        $extraSelectCollection   = collect();
        $extraCheckboxCollection = collect();
        $attributeSet            = $orderproduct->product->attributeset;
        $extraAttributes         = Attribute::whereHas('attributegroups', function ($q) use ($attributeSet) {
            /** @var QueryBuilder $q */
            $q->where('attributetype_id', 2);
            $q->where('attributeset_id', $attributeSet->id);
        })
            ->get();
        foreach ($extraAttributes as $attribute) {
            $orderproductAttributevalues = $orderproduct->attributevalues->where('attribute_id', $attribute->id);
            $controlName                 = $attribute->attributecontrol->name;
            /** @var Collection|Attributevalue $attributevalues */
            $attributevalues = $attribute->attributevalues->where('attribute_id', $attribute->id)
                ->sortBy('order');
            $this->processAttrValues($attributevalues, $controlName, $orderproductAttributevalues,
                $extraSelectCollection, $attribute,
                $extraCheckboxCollection);
        }
        $orderproductCost       = $orderproduct->obtainOrderproductCost(false);
        $defaultExtraAttributes = $orderproduct->attributevalues->pluck('id')
            ->toArray();
        $checkoutStatuses       = Checkoutstatus::pluck('displayName', 'id')
            ->toArray();
        $checkoutStatuses       = array_sort_recursive($checkoutStatuses);
        
        $product  = $orderproduct->product()
            ->first();
        
        return view('order.orderproduct.edit',
            compact('orderproduct', 'products', 'product', 'extraSelectCollection', 'extraCheckboxCollection',
                'orderproductCost', 'defaultExtraAttributes',
                'checkoutStatuses'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orderproduct         $orderproduct
     * @param  UserbonController         $userbonController
     *
     * @return Response
     */
    public function update(Request $request, $orderproduct, UserbonController $userbonController)
    {
        $cancelOldDiscount = false;
        $orderproduct->fill($request->all());
        
        if (strlen($orderproduct->checkoutstatus_id) == 0) {
            $orderproduct->checkoutstatus_id = null;
        }
        
        $orderproduct->attributevalues()
            ->detach($orderproduct->attributevalues->pluck('id')
                ->toArray());
        if ($request->has('extraAttribute')) {
            
            $extraAttributes = $request->get('extraAttribute');
            foreach ($extraAttributes as $value) {
                if ($value > 0) {
                    if (isset($request->get('extraCost')[$value])) {
                        $extraCost = $request->get('extraCost')[$value];
                    } else {
                        $extraCost = 0;
                    }
                    if ($extraCost > 0) {
                        $orderproduct->attributevalues()
                            ->attach($value, ['extraCost' => $extraCost]);
                    }
                }
            }
        }
        
        if ($request->has('changeProduct')) {
            $newProduct = Product::where('id', ($request->get('newProductId')))
                ->get()
                ->first();
            if (isset($newProduct)) {
                $orderproduct->product_id = $newProduct->id;
                if (isset($newProduct->amount)) {
                    $newProduct->amount = $newProduct->amount - 1;
                }
                $newProduct->update();
                $orderproduct->product_id = $newProduct->id;
                if ($request->has('newProductBonPlus')) {
                    $bon = Bon::all()
                        ->where('name', config('constants.BON1'))
                        ->where('isEnable', 1)
                        ->first();
                    if (isset($bon)) {
                        $bonPlus = $newProduct->calculateBonPlus($bon->id);
                        if ($bonPlus > 0) {
                            $request = new InsertUserBonRequest();
                            $request->offsetSet('bon_id', $bon->id);
                            if (isset($orderproduct->order->user->id)) {
                                $request->offsetSet('user_id', $orderproduct->order->user->id);
                            }
                            $request->offsetSet('totalNumber', $bonPlus);
                            $request->offsetSet('orderproduct_id', $orderproduct->id);
                            $request->offsetSet('userbonstatus_id', config('constants.USERBON_STATUS_ACTIVE'));
                            /*$response = */
                            $userbonController->store($request);
                            /*if ($response->getStatusCode() == Response::HTTP_OK) {
                                //ToDo : Appropriate response
                            } else {

                            }*/
                        }
                    }
                }
            }
        }
        
        if ($request->has('changeCost')) {
            if (strlen($request->get('cost')) > 0) {
                $cancelOldDiscount = true;
            }
        } else {
            if (isset($newProduct)) {
                $cancelOldDiscount  = true;
                $orderproduct->cost = $request->get('newProductCost');
            }
        }
        
        if ($cancelOldDiscount) {
            $orderproduct->userbons()
                ->detach($orderproduct->userbons->pluck('id')
                    ->toArray());
            $orderproduct->includedInCoupon   = 0;
            $orderproduct->discountPercentage = 0;
            $orderproduct->discountAmount     = 0;
        }
        
        if ($orderproduct->update()) {
            $order = Order::where('id', $orderproduct->order_id)
                ->get()
                ->first();
            if (isset($order)) {
                $orderCost                              = $orderproduct->order->obtainOrderCost(true, false);
                $orderproduct->order->cost              = $orderCost['rawCostWithDiscount'];
                $orderproduct->order->costwithoutcoupon = $orderCost['rawCostWithoutDiscount'];
                $orderproduct->order->updateWithoutTimestamp();
            }
            session()->put('success', 'محصول سفارش با موفقیت اصلاح شد');
        } else {
            session()->put('error', 'خطای پایگاه داده در اصلاح کالای سفارش');
        }
        
        return redirect()->back();
    }
    
    public function destroy(Orderproduct $orderproduct)
    {
        $orderproduct_userbons = $orderproduct->userbons;
        foreach ($orderproduct_userbons as $orderproduct_userbon) {
            $orderproduct_userbon->usedNumber       = $orderproduct_userbon->usedNumber - $orderproduct_userbon->pivot->usageNumber;
            $orderproduct_userbon->userbonstatus_id = config('constants.USERBON_STATUS_ACTIVE');
            if ($orderproduct_userbon->usedNumber >= 0) {
                $orderproduct_userbon->update();
            }
        }
        $deleteFlag = $orderproduct->delete() ? true : false;
        
        $previousRoute = app('router')
            ->getRoutes()
            ->match(app('request')->create(URL::previous()))
            ->getName();
        if (strcmp($previousRoute, 'order.edit') == 0) {
            $orderCost                              = $orderproduct->order->obtainOrderCost(true, false);
            $orderproduct->order->cost              = $orderCost['rawCostWithDiscount'];
            $orderproduct->order->costwithoutcoupon = $orderCost['rawCostWithoutDiscount'];
            $orderproduct->order->updateWithoutTimestamp();
        }
        
        if (!$deleteFlag) {
            return response()->json(['message' => 'خطا در حذف محصول سفارش'] , Response::HTTP_SERVICE_UNAVAILABLE );
        }
        
        foreach ($orderproduct->children as $child) {
            $child->delete();
        }
        Cache::tags('bon')
            ->flush();
        
        return response()->json(['message' => 'محصول سفارش با موفقیت حذف شد!']);
    }
    
    public function checkOutOrderproducts(Request $request)
    {
        $orderproductIds      = $request->get('orderproducts');
        $newCheckoutstatus_id = $request->get('checkoutStatus');
        $orderproducts        = Orderproduct::whereIn('id', $orderproductIds)
            ->get();
        
        foreach ($orderproducts as $orderproduct) {
            $orderproduct->checkoutstatus_id = $newCheckoutstatus_id;
            $orderproduct->update();
        }
        
        return response()->json();
    }
    
    /**
     * Stores an array of json objects , each containing of an orderproduct info
     *
     * @param         $orderproductJsonObject
     * @param  array  $data
     *
     * @return mixed
     */
    public function storeOrderproductJsonObject($orderproductJsonObject, array $data)
    {
        $grandParentProductId = optional($orderproductJsonObject)->product_id;
        $productIds           = optional($orderproductJsonObject)->products;
        $attributes           = optional($orderproductJsonObject)->attribute;
        $extraAttributes      = optional($orderproductJsonObject)->extraAttribute;
        
        $orderproductData['product_id']     = $grandParentProductId;
        $orderproductData['products']       = $productIds;
        $orderproductData['attribute']      = $attributes;
        $orderproductData['extraAttribute'] = $extraAttributes;
        $orderproductData['order_id']       = isset($data['order_id']) ? $data['order_id'] : null;

        return $this->new($orderproductData);
    }
    
    /**
     * @param                                  $attributevalues
     * @param                                  $controlName
     * @param                                  $orderproductAttributevalues
     * @param  \Illuminate\Support\Collection  $extraSelectCollection
     * @param  static                          $attribute
     * @param  \Illuminate\Support\Collection  $extraCheckboxCollection
     */
    private function processAttrValues(
        $attributevalues,
        $controlName,
        $orderproductAttributevalues,
        Collection $extraSelectCollection,
        $attribute,
        Collection $extraCheckboxCollection
    )
    {
        if ($attributevalues->isEmpty()) {
            return;
        }
        switch ($controlName) {
            case 'select':
                $this->processSelect($attributevalues, $orderproductAttributevalues, $extraSelectCollection,
                    $attribute);
                break;
            case 'groupedCheckbox':
                $this->processGroupedCheckbox($attributevalues, $orderproductAttributevalues, $attribute,
                    $extraCheckboxCollection);
                break;
            default:
                break;
        }
        
    }
    
    /**
     * @param                                  $attributevalues
     * @param                                  $orderproductAttributevalues
     * @param  \Illuminate\Support\Collection  $extraSelectCollection
     * @param                                  $attribute
     */
    private function processSelect($attributevalues, $orderproductAttributevalues, Collection $extraSelectCollection, $attribute): void
    {
        $select         = [];
        $extraCostArray = [];
        foreach ($attributevalues as $attributevalue) {
            if ($orderproductAttributevalues->contains($attributevalue->id)) {
                $extraCost = $orderproductAttributevalues->where('id', $attributevalue->id)
                    ->first()->pivot->extraCost;
            } else {
                $extraCost = null;
            }
            $attributevalueIndex = $attributevalue->name;
            $select              = array_add($select, $attributevalue->id, $attributevalueIndex);
            $extraCostArray      = array_add($extraCostArray, $attributevalue->id, $extraCost);
        }
        $select[0] = 'هیچکدام';
        $select    = array_sort_recursive($select);
        if (!empty($select)) {
            $extraSelectCollection->put($attribute->id, [
                'attributeDescription' => $attribute->displayName,
                'attributevalues'      => $select,
                'extraCost'            => $extraCostArray,
            ]);
        }
    }
    
    /**
     * @param                                  $attributevalues
     * @param                                  $orderproductAttributevalues
     * @param                                  $attribute
     * @param  \Illuminate\Support\Collection  $extraCheckboxCollection
     */
    private function processGroupedCheckbox($attributevalues, $orderproductAttributevalues, $attribute, Collection $extraCheckboxCollection): void
    {
        $groupedCheckbox = collect();
        foreach ($attributevalues as $attributevalue) {
            $attributevalueIndex = $attributevalue->name;
            if ($orderproductAttributevalues->contains($attributevalue->id)) {
                $extraCost = $orderproductAttributevalues->where('id', $attributevalue->id)
                    ->first()->pivot->extraCost;
            } else {
                $extraCost = null;
            }
            
            $groupedCheckbox->put($attributevalue->id, [
                'index'     => $attributevalueIndex,
                'extraCost' => $extraCost,
            ]);
        }
        if (!empty($groupedCheckbox)) {
            $extraCheckboxCollection->put($attribute->displayName, $groupedCheckbox);
        }
    }
}
