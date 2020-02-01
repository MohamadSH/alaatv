<?php

namespace App\Http\Controllers\Web;

use App\Attribute;
use App\Attributevalue;
use App\Bon;
use App\Checkoutstatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertUserBonRequest;
use App\Http\Requests\OrderProduct\OrderProductStoreRequest;
use App\Http\Requests\RestoreOrderproductRequest;
use App\Order;
use App\Orderproduct;
use App\Product;
use App\Repositories\OrderproductRepo;
use App\Traits\OrderCommon;
use App\Traits\OrderproductTrait;
use App\Traits\ProductCommon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Kalnoy\Nestedset\QueryBuilder;

class OrderproductController extends Controller
{
    use OrderCommon;
    use ProductCommon;
    use OrderproductTrait;

    function __construct()
    {
        $this->middleware('permission:' . config('constants.LIST_ORDERPRODUCT_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.UPDATE_ORDERPRODUCT_ACCESS'), ['only' => 'update']);
        $this->middleware('permission:' . config('constants.SHOW_ORDERPRODUCT_ACCESS'), ['only' => 'edit']);
        $this->middleware('permission:' . config('constants.RESTORE_ORDERPRODUCT_ACCESS'), ['only' => 'restore']);
        $this->middleware(['CheckPermissionForSendOrderId',], ['only' => ['store'],]);
    }

    public function index(Request $request)
    {
        $timeFilterEnable = $request->get('dateFilterEnable');
        $checkoutEnable   = $request->get('checkoutEnable');
        $checkoutStatus   = $request->get('checkoutStatus');
        $pageNumber       = ($request->get('page', 0) - 1);
        $productIds       = $request->get('product_id', []);

        $since = null;
        $till  = null;
        if ($timeFilterEnable) {
            $since = Carbon::parse($request->get('since'))->toDateTimeString();
            $till  = Carbon::parse($request->get('till'))->toDateTimeString();
        }

        if ($checkoutStatus == 0) {
            $chechoutFilter = OrderproductRepo::CHECKOUT_ALL;
        } else if ($checkoutStatus == 1) {
            $chechoutFilter = OrderproductRepo::NOT_CHECKEDOUT_ORDERPRODUCT;
        } else {
            $chechoutFilter = OrderproductRepo::CHECKEDOUT_ORDERPRODUCT;
        }

        if (in_array(0, $productIds))
            $productIds = [];
        $orderproducts = OrderproductRepo::getPurchasedOrderproducts($productIds, $since, $till, $chechoutFilter)
            ->with(['order', 'order.transactions', 'order.normalOrderproducts'])->get();

        $totalNubmer = $orderproducts->count();

        if ($pageNumber > 1) {
            $orderproducts->chunk(20)[$pageNumber];
            return response()->json([
                'orderproducts' => $orderproducts,
                'totalNumber'   => $totalNubmer,
            ]);
        }

        $totalSale = 0;
        foreach ($orderproducts as $orderproduct) {
            $toAdd     = $orderproduct->getSharedCostOfTransaction();
            $totalSale += $toAdd;
        }

        $checkoutResult = false;
        if ($checkoutEnable && $request->user()->can(config('constants.CHECKOUT_ORDERPRODUCT_ACCESS'))) {
            $checkoutResult = Orderproduct::whereIn('id', $orderproducts->pluck('id')->toArray())->update(['checkoutstatus_id' => config('constants.ORDERPRODUCT_CHECKOUT_STATUS_PAID')]);
        }

        $orderproducts = $orderproducts->chunk(20);
        if($orderproducts->isNotEmpty()){
            $orderproducts = $orderproducts[max($pageNumber, 0)];
        }
        return response()->json([
            'orderproducts'  => $orderproducts,
            'totalNumber'    => $totalNubmer,
            'totalSale'      => number_format((int)$totalSale),
            'checkoutResult' => $checkoutResult,
        ]);
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

    public function edit(Orderproduct $orderproduct)
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
        $checkoutStatuses       = Arr::sortRecursive($checkoutStatuses);

        $product = $orderproduct->product()
            ->first();

        return view('order.orderproduct.edit',
            compact('orderproduct', 'products', 'product', 'extraSelectCollection', 'extraCheckboxCollection',
                'orderproductCost', 'defaultExtraAttributes',
                'checkoutStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request           $request
     * @param Orderproduct      $orderproduct
     * @param UserbonController $userbonController
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
            $orderproduct_userbon->usedNumber       =
                $orderproduct_userbon->usedNumber - $orderproduct_userbon->pivot->usageNumber;
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
            return response()->json(['message' => 'خطا در حذف محصول سفارش'], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        foreach ($orderproduct->children as $child) {
            $child->delete();
        }
        Cache::tags([
            'order_' . $orderproduct->order_id . '_products',
            'order_' . $orderproduct->order_id . '_orderproducts',
            'order_' . $orderproduct->order_id . '_cost',
            'order_' . $orderproduct->order_id . '_bon',
        ])->flush();

        return response()->json(['message' => 'محصول سفارش با موفقیت حذف شد!']);
    }

    public function restore(RestoreOrderproductRequest $request)
    {
        $orderproduct = Orderproduct::onlyTrashed()->find($request->get('orderproductId'));
        if (!isset($orderproduct)) {
            return response()->json([
                'error' => [
                    'code'    => Response::HTTP_NOT_FOUND,
                    'message' => 'Orderproduct not found',
                ],
            ]);
        }


        $restoreResult = $orderproduct->restore();
        if ($restoreResult) {
            return response()->json([
                'message' => 'Orderproduct restored successfully',
            ]);
        }

        return response()->json([
            'error' => [
                'code'    => Response::HTTP_SERVICE_UNAVAILABLE,
                'message' => 'Unexpected error',
            ],
        ]);
    }

    /**
     * @param                                  $attributevalues
     * @param                                  $orderproductAttributevalues
     * @param Collection                       $extraSelectCollection
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
            $select              = Arr::add($select, $attributevalue->id, $attributevalueIndex);
            $extraCostArray      = Arr::add($extraCostArray, $attributevalue->id, $extraCost);
        }
        $select[0] = 'هیچکدام';
        $select    = Arr::sortRecursive($select);
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
     * @param Collection                       $extraCheckboxCollection
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

    /**
     * @param                                  $attributevalues
     * @param                                  $controlName
     * @param                                  $orderproductAttributevalues
     * @param Collection                       $extraSelectCollection
     * @param static                           $attribute
     * @param Collection                       $extraCheckboxCollection
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
}
