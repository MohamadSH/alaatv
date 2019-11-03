<?php

namespace App;

use App\Repositories\OrderproductRepo;
use App\Traits\ProductCommon;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use App\Collection\OrderproductCollection;
use App\Classes\Checkout\Alaa\OrderproductCheckout;

/**
 * App\Orderproduct
 *
 * @property int                                                                 $id
 * @property int|null                                                            $orderproducttype_id آیدی مشخص کننده
 *           نوع آیتم سبد
 * @property int                                                                 $order_id
 * @property int                                                                 $product_id
 * @property int|null                                                            $checkoutstatus_id   آی دی مشحص کننده
 *           وضعیت تسویه حساب این آیتم
 * @property int|null                                                            $cost                مبلغ این آیتم سبد
 * @property float                                                               $discountPercentage  تخفیف این آیتم
 *           سبد(به درصد)
 * @property int                                                                 $discountAmount      تخفیف این آیتم
 *           سبد(مبلغ)
 * @property int                              $includedInCoupon    مشخص کننده اینکه
 *           آیا این آیتم مشمول کپن بوده یا نه(در صورت کپن داشتن سفارش)
 * @property int                              $quantity            تعداد سفارش داده
 *           شده
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @property Carbon|null              $deleted_at
 * @property-read Collection|Attributevalue[] $attributevalues
 * @property-read Checkoutstatus|null         $checkoutstatus
 * @property-read Collection|Orderproduct[]   $children
 * @property-read Collection|Userbon[]        $insertedUserbons
 * @property-read Order                       $order
 * @property-read Orderproducttype|null       $orderproducttype
 * @property-read Collection|Orderproduct[]   $parents
 * @property-read Product                     $product
 * @property-read Collection|Userbon[]        $userbons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Orderproduct onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Orderproduct whereCheckoutstatusId($value)
 * @method static Builder|Orderproduct whereCost($value)
 * @method static Builder|Orderproduct whereCreatedAt($value)
 * @method static Builder|Orderproduct whereDeletedAt($value)
 * @method static Builder|Orderproduct whereDiscountAmount($value)
 * @method static Builder|Orderproduct whereDiscountPercentage($value)
 * @method static Builder|Orderproduct whereId($value)
 * @method static Builder|Orderproduct whereIncludedInCoupon($value)
 * @method static Builder|Orderproduct whereOrderId($value)
 * @method static Builder|Orderproduct whereOrderproducttypeId($value)
 * @method static Builder|Orderproduct whereProductId($value)
 * @method static Builder|Orderproduct whereQuantity($value)
 * @method static Builder|Orderproduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Orderproduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Orderproduct withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Orderproduct newModelQuery()
 * @method static Builder|Orderproduct newQuery()
 * @method static Builder|Orderproduct query()
 * @property-read float|int                        $discount_percentage
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                            $orderproducttype_info
 * @property-read mixed                            $bons
 * @property-read mixed                            $grand_id
 * @property-read mixed                                                          $grand_product
 * @property-read mixed                                                          $photo
 * @property-read mixed                                                          $price
 * @property-read mixed                                                          $cache_cooldown_seconds
 * @property int|null $tmp_final_cost کش قیمت نهایی
 * @property int|null $tmp_extra_cost کش قیمت افزوده نهایی
 * @property float|null $tmp_share_order مبلغی که سهم این آبتم از قیمت کل است
 * @property-read int|null $attributevalues_count
 * @property-read int|null $children_count
 * @property-read mixed $attached_bons_number
 * @property-read int|null $inserted_userbons_count
 * @property-read int|null $parents_count
 * @property-read int|null $userbons_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereTmpExtraCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereTmpFinalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereTmpShareOrder($value)
 */
class Orderproduct extends BaseModel
{
    use ProductCommon;

    /**
     * @var array
     */
    protected $fillable = [
        'orderproducttype_id',
        'order_id',
        'product_id',
        'quantity',
        'cost',
        'tmp_final_cost',
        'tmp_extra_cost',
        'tmp_share_order',
        'discountPercentage',
        'discountAmount',
        'includedInCoupon',
        'checkoutstatus_id',
    ];

    protected $touches = [
        // ToDo: Query reduction
        /**
         * Ali Esmaeeli: in OrderProductController@store create 8 query
         * To comment this line, you need to find all the places where
         * the orderProduct has been changed and clear the cache
         */
        'attributevalues',
    ];

    protected $appends = [
        'orderproducttype',
        'product',
        'grandId',
        'price',
        'bons',
        'attributevalues',
        'photo',
        'grandProduct',
    ];

    protected $hidden = [
        'product_id',
        'cost',
        'discountPercentage',
        'discountAmount',
        'orderproducttype_id',
        'checkoutstatus_id',
        'includedInCoupon',
        'userbons',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function deleteOpenedTransactions(array $intendedProductsId, array $intendedOrderStatuses): void
    {
        Orderproduct::whereIn('product_id', $intendedProductsId)
            ->whereHas('order', function ($q) use ($intendedOrderStatuses) {
                $q->whereIn('orderstatus_id', $intendedOrderStatuses)
                    ->whereDoesntHave('transactions', function ($q2) {
                        $q2->where('transactionstatus_id', config('constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY'));
                    });
            })
            ->delete();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getOrderproducttypeAttribute()
    {
        $orderproduct = $this;
        $key          = 'orderproduct:type:'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'orderproductType' , 'order_'.$orderproduct->id , 'order_'.$orderproduct->id.'_orderproductType'])
            ->remember($key, config('constants.CACHE_600'), function () use ($orderproduct) {
                return optional($this->orderproducttype()
                    ->first())->setVisible([
                    'name',
                    'displayName',
                ]);
            });
    }

    public function cacheKey()
    {
        $key  = $this->getKey();
        $time = isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;

        return sprintf('%s-%s', //$this->getTable(),
            $key, $time);
    }

    public function orderproducttype()
    {
        return $this->belongsTo(Orderproducttype::class);
    }

    public function insertedUserbons()
    {
        return $this->hasMany(Userbon::class);
    }

    public function checkoutstatus()
    {
        return $this->belongsTo(Checkoutstatus::class);
    }

    public function children()
    {
        return $this->belongsToMany(Orderproduct::class, 'orderproduct_orderproduct', 'op1_id',
            'op2_id')
            ->withPivot('relationtype_id')
            ->join('orderproductinterrelations', 'relationtype_id',
                'orderproductinterrelations.id')
            ->where('relationtype_id', config('constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD'));
    }

    public function getExtraCost($extraAttributevaluesId = null):int
    {
        $orderproduct = $this;
        $key = 'orderproduct:getExtraCost:'.$this->cacheKey()."\\".(isset($extraAttributevaluesId) ? implode('.',
                $extraAttributevaluesId) : '-');

        return (int) Cache::tags(['orderproduct' , 'attribute' , 'orderproductExtraCost' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_orderproductExtraCost'])
            ->remember($key, config('constants.CACHE_60'), function () use ($extraAttributevaluesId) {
            $extraCost = 0;
            if (isset($extraAttributevaluesId)) {
                $extraAttributevalues = $this->attributevalues->whereIn('id', $extraAttributevaluesId);
            }
            else {
                $extraAttributevalues = $this->attributevalues;
            }
            foreach ($extraAttributevalues as $attributevalue) {
                $extraCost += $attributevalue->pivot->extraCost;
            }

            return (int)$extraCost;
        });
    }

    /**
     * Get orderproduct's total bon discount
     *
     * @return mixed
     */
    public function getTotalBonDiscountPercentage()
    {
        $totalBonDiscountValue = $this->getTotalBonDiscountDecimalValue();

        return min($totalBonDiscountValue / 100, 1);
    }

    /**
     * Obtains orderproduct's total bon discount decimal value
     *
     * @return int
     */
    public function getTotalBonDiscountDecimalValue(): int
    {
        $totalBonNumber = 0;
        foreach ($this->userbons as $userbon) {
            $totalBonNumber += $userbon->pivot->discount * $userbon->pivot->usageNumber;
        }

        return $totalBonNumber;
    }

    public function isNormalType()
    {
        if ($this->orderproducttype_id == config('constants.ORDER_PRODUCT_TYPE_DEFAULT') || !isset($this->orderproductstatus_id)) {
            return true;
        }

        return false;
    }

    public function fillCostValues($costArray)
    {
        if (isset($costArray['cost'])) {
            $this->cost = $costArray['cost'];
        }
        else {
            $this->cost = null;
        }

        if ($this->isGiftType()) {
            $this->discountPercentage = 100;
            $this->discountAmount     = 0;
        }
        else {
            if (isset($costArray['productDiscount'])) {
                $this->discountPercentage = $costArray['productDiscount'];
            }
            if (isset($costArray['productDiscountAmount'])) {
                $this->discountAmount = $costArray['productDiscountAmount'];
            }
        }
    }

    public function isGiftType()
    {
        if ($this->orderproducttype_id == config('constants.ORDER_PRODUCT_GIFT')) {
            return true;
        }

        return false;
    }

    /**
     * @return BelongsToMany|Orderproduct|Collection
     */
    public function parents()
    {
        return $this->belongsToMany(Orderproduct::class, 'orderproduct_orderproduct', 'op2_id',
            'op1_id')
            ->withPivot('relationtype_id')
            ->join('orderproductinterrelations', 'relationtype_id',
                'orderproductinterrelations.id')
            ->where('relationtype_id', config('constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD'));
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return Collection
     */
    public function newCollection(array $models = [])
    {
        return new OrderproductCollection($models);
    }

    /**
     * @param $value
     *
     * @return float|int
     */
    public function getDiscountPercentageAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Sets orderproduct including in coupon
     *
     */
    public function includeInCoupon(): void
    {
        $this->includedInCoupon = 1;
        $this->update();
    }

    /** change type of orderproduct to Gift type
     *
     * @param  Product  $gift
     *
     * @return Orderproduct
     */
//    public function changeOrderproductTypeToGift($orderproductId)
//    {
//        $orderproduct = Orderproduct::FindorFail($orderproductId);
//        $orderproduct->orderproducttype_id = config("constants.ORDER_PRODUCT_GIFT");
//        $orderproduct->save();
//
//        return $orderproduct;
//    }

    /**
     * Sets orderproduct excluding from coupon
     *
     */
    public function excludeFromCoupon(): void
    {
        $this->includedInCoupon = 0;
        $this->update();
    }

    /**
     * Determines whether orderproduct is available to purchase or not
     *
     * @return bool
     */
    public function isPurchasable(): bool
    {
        return $this->product->isEnableToPurchase();
    }

    /**
     * Updates orderproduct's attribute values
     *
     */
    public function renewAttributeValue(): void
    {
        $extraAttributes = $this->attributevalues;
        $myParent        = $this->product->grandParent;

        if (isset($myParent)) {
            foreach ($extraAttributes as $extraAttribute) {
                $productAttributevalue = $myParent->attributevalues->where('id', $extraAttribute->id)
                    ->first();

                if (!isset($productAttributevalue)) {
                    $this->attributevalues()
                        ->detach($productAttributevalue);
                }
                else {
                    $newExtraCost = $productAttributevalue->pivot->extraCost;
                    $this->attributevalues()
                        ->updateExistingPivot($extraAttribute->id, ['extraCost' => $newExtraCost]);
                }
            }
        }
    }

    /**
     * @return BelongsToMany|Attributevalue|Collection
     */
    public function attributevalues()
    {
        return $this->belongsToMany(Attributevalue::class, 'attributevalue_orderproduct', 'orderproduct_id', 'value_id')
            ->withPivot('extraCost');
    }

    public function renewUserBons()
    {
        $userbons = $this->userbons;
        if ($userbons->isNotEmpty()) {
            $bonName = config('constants.BON1');

            $bons = $this->product->getTotalBons($bonName);

            if ($bons->isEmpty()) {
                foreach ($userbons as $userBon) {
                    $this->userbons()
                        ->detach($userBon);

                    $userBon->usedNumber       = 0;
                    $userBon->userbonstatus_id = config('constants.USERBON_STATUS_ACTIVE');
                    $userBon->update();
                }
            }
            else {
                $bon = $bons->first();
                foreach ($userbons as $userbon) {
                    $newDiscount = $bon->pivot->discount;
                    $this->userbons()
                        ->updateExistingPivot($userbon->id, ['discount' => $newDiscount]);
                }
            }
        }
    }

    /**
     * @return BelongsToMany
     */
    public function userbons()
    {
        return $this->belongsToMany(Userbon::class)
            ->withPivot('usageNumber', 'discount');
    }

    public function getAttachedBonsNumberAttribute(){
        $orderproduct = $this;
        $key          = 'orderproduct:attachedBonsNumber:'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'bon' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_bon'])
            ->remember($key, config('constants.CACHE_60'), function () use ($orderproduct) {
                return $orderproduct->userbons->sum('usedNumber');
            });
    }

    /**
     * @param       $userBons
     * @param  Bon  $bon
     */
    public function applyBons($userBons, Bon $bon): void
    {
        foreach ($userBons as $userBon) {
            $remainBonNumber = $userBon->void();
            $this->userbons()
                ->attach($userBon->id, [
                    'usageNumber' => $remainBonNumber,
                    'discount'    => $bon->pivot->discount,
                ]);
        }
        Cache::tags([
            'user_'.$userBons->first()->user_id.'_totalBonNumber' ,
            'user_'.$userBons->first()->user_id.'_validBons' ,
            'user_'.$userBons->first()->user_id.'_hasBon' ,
            'orderproduct_'.$this->id.'_bon' ,
            'orderproduct_'.$this->id.'_cost' ,
            'order_'.$this->id.'_cost'])->flush();
    }

    public function getProductAttribute()
    {
        $orderproduct = $this;
        $key          = 'orderproduct:product'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'product' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_product'])
            ->remember($key, config('constants.CACHE_60'), function () use ($orderproduct) {
                return optional($this->product()
                    ->first())->setVisible([
                    'id',
                    'name',
                    'url',
                    'apiUrl',
                    'photo',
                    'attributes',
                ]);
            });
    }

    public function product()
    {
        return $this->belongsTo(Product::class)//                    ->with('parents')
            ;
    }

    public function getGrandProductAttribute()
    {
        $orderproduct = $this;
        $key          = 'orderproduct:grandProduct:'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'product' , 'grandProduct' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_grandProduct'])
            ->remember($key, config('constants.CACHE_60'), function () use ($orderproduct) {
                return optional(optional($this->product)->grand)->setVisible([
                    'id',
                    'name',
                    'photo',
                    'url',
                    'apiUrl',
                    'attributes',
                ]);
            });
    }

    public function getGrandIdAttribute()
    {
        $orderproduct = $this;
        $key          = 'orderproduct:grandProductId:'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'product' , 'grandProduct' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_grandProduct'])
            ->remember($key, config('constants.CACHE_60'), function () use ($orderproduct) {
                return optional($orderproduct->product)->grand_id;
            });
    }

    public function getPriceAttribute()
    {
        $orderproduct = $this;
        $key          = 'orderproduct:cost:'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'orderproductCost' , 'cost' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_cost'])
            ->remember($key, config('constants.CACHE_60'), function () use ($orderproduct) {
                return $this->obtainOrderproductCost(false);
            });
    }

    /**
     * Obtain order total cost
     *
     * @param  boolean  $calculateCost
     *
     * @return array
     */
    public function obtainOrderproductCost($calculateCost = true)
    {
        $priceInfo = $this->calculatePayableCost($calculateCost);

        return [
            'discountDetail' => [
                'productDiscount'       => $priceInfo['productDiscount'],
                'bonDiscount'           => $priceInfo['bonDiscount'],
                'productDiscountAmount' => $priceInfo['productDiscountAmount'],
            ],
            //////////////////////////
            'extraCost'      => $priceInfo['extraCost'],
            'base'           => $priceInfo['cost'],
            'discount'       => $priceInfo['discount'],
            'final'          => $priceInfo['customerCost'],
            //            'totalPrice'            => $priceInfo['totalCost'],
        ];
    }

    private function calculatePayableCost($calculateCost = true)
    {
        $alaaCashierFacade       = new OrderproductCheckout($this, $calculateCost);
        $priceInfo               = $alaaCashierFacade->checkout();
        $calculatedOrderproducts = $priceInfo['orderproductsInfo']['calculatedOrderproducts'];
        /** @var OrderproductCollection $calculatedOrderproducts */
        $orderproductPriceInfo = $calculatedOrderproducts->getNewPriceForItem($calculatedOrderproducts->first());

        return $orderproductPriceInfo;
    }

    public function getBonsAttribute()
    {
        $orderproduct = $this;
        $key          = 'orderproduct:bons:'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'bon' , 'cost' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_bon'])
            ->remember($key, config('constants.CACHE_60'), function () use ($orderproduct) {
                $userbons = $this->userbons()
                    ->get();

                return $userbons;
            });
    }

    public function getAttributevaluesAttribute()
    {
        $orderproduct = $this;
        $key          = 'orderproduct:attributevalues:'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'attribute' , 'attributevalues' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_attributevalues'])
            ->remember($key, config('constants.CACHE_60'), function () use ($orderproduct) {
                //ToDo : set visible
                $attributevalues = $orderproduct->attributevalues()
                    ->get();

                return $attributevalues;
            });
    }

    public function getPhotoAttribute()
    {
        $orderproduct = $this;
        $key          = 'orderproduct:photo:'.$orderproduct->cacheKey();

        return Cache::tags(['orderproduct' , 'photo' , 'orderproduct_'.$orderproduct->id , 'orderproduct_'.$orderproduct->id.'_photo'])
            ->remember($key, config('constants.CACHE_60'), function () use ($orderproduct) {
                return optional(optional($this->product)->grand)->photo;
            });
    }

    public function affectCouponOnPrice($finalPrice){
        if($this->includedInCoupon)
        {
            $myOrder = $this->order;
            $orderCouponDiscount = $myOrder->coupon_discount_type;
            if($orderCouponDiscount  !== false)
            {
                $couponDiscount = $orderCouponDiscount['discount'];
                if($orderCouponDiscount['typeHint'] == 'percentage'){
                    $finalPrice = ($finalPrice * (1 - ($couponDiscount/100)));
                }
            }
        }

        return $finalPrice;
    }

    /**
     * @return array
     */
    public function setTmpFinalCost():array
    {
        $price = $this->obtainOrderproductCost(false);
        $finalPrice = $price['final'];
        $extraCost = $price['extraCost'];

        OrderproductRepo::refreshOrderproductTmpPrice($this, $finalPrice, $extraCost);

        return  [$finalPrice , $extraCost]  ;
    }

    /**
     * @param $finalPrice
     * @param $donateOrderproductSum
     * @return float|int
     */
    public function setShareCost()
    {
        if(isset($this->tmp_final_cost))
        {
            $finalPrice = $this->tmp_final_cost;
        }else{
            [$finalPrice , $extraCost] = $this->setTmpFinalCost();
        }

        $myOrder = $this->order;

        if(!isset($myOrder))
        {
            OrderproductRepo::refreshOrderproductTmpShare($this, 0);
            return 0;
        }

        if (isset($myOrder->coupon_id)) {
            $finalPrice = $this->affectCouponOnPrice($finalPrice);
        }
        $orderPrice = $myOrder->obtainOrderCost();

        $donateOrderproductSum = $myOrder->getDonateSum();

        $shareOfOrder =   ($orderPrice['totalCost'] == 0 || $orderPrice['totalCost'] == $donateOrderproductSum) ? 0 : (double)$finalPrice / ($orderPrice['totalCost'] - $donateOrderproductSum);
        OrderproductRepo::refreshOrderproductTmpShare($this, $shareOfOrder);

        return $shareOfOrder;
    }

    public function getSharedCostOfTransaction(){
        $myOrder = $this->order;
        $donateOrderproductSum = $myOrder->getDonateSum();

        if(isset($this->tmp_share_order))
        {
            $shareOfOrder = $this->tmp_share_order;
        }else{
            $shareOfOrder = $this->setShareCost();
        }

        return $shareOfOrder * ($myOrder->none_wallet_successful_transactions->sum('cost') - $donateOrderproductSum);
    }
}
