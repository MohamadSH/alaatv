<?php

namespace App;


use App\Classes\Checkout\Alaa\AlaaOrderproductGroupPriceCalculatorFromNewBase;
use App\Classes\Checkout\Alaa\OrderproductCheckout;
use App\Collection\OrderproductCollection;
use App\Traits\ProductCommon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * App\Orderproduct
 *
 * @property int $id
 * @property int|null $orderproducttype_id آیدی مشخص کننده
 *           نوع آیتم سبد
 * @property int $order_id
 * @property int $product_id
 * @property int|null $checkoutstatus_id   آی دی مشحص کننده
 *           وضعیت تسویه حساب این آیتم
 * @property int|null $cost                مبلغ این آیتم سبد
 * @property float $discountPercentage  تخفیف این آیتم
 *           سبد(به درصد)
 * @property int $discountAmount      تخفیف این آیتم
 *           سبد(مبلغ)
 * @property int $includedInCoupon    مشخص کننده اینکه
 *           آیا این آیتم مشمول کپن بوده یا نه(در صورت کپن داشتن سفارش)
 * @property int $quantity            تعداد سفارش داده
 *           شده
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attributevalue[] $attributevalues
 * @property-read \App\Checkoutstatus|null $checkoutstatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Userbon[] $insertedUserbons
 * @property-read \App\Order $order
 * @property-read \App\Orderproducttype|null $orderproducttype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[] $parents
 * @property-read \App\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Userbon[] $userbons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderproduct onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereCheckoutstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereIncludedInCoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereOrderproducttypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Orderproduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderproduct withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproduct query()
 * @property-read float|int $discount_percentage
 */
class Orderproduct extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
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
        'discountPercentage',
        'discountAmount',
        'includedInCoupon',
        'checkoutstatus_id',
    ];
    protected $touches = [
        'attributevalues',
    ];

    public function order()
    {
        return $this->belongsTo('\App\Order');
    }

    public function product()
    {
        return $this->belongsTo('\App\Product');
    }

    public function attributevalues()
    {
        return $this->belongsToMany('\App\Attributevalue', 'attributevalue_orderproduct', 'orderproduct_id', 'value_id')
            ->withPivot("extraCost");
    }

    public function userbons()
    {
        return $this->belongsToMany('\App\Userbon')
            ->withPivot("usageNumber", "discount");
    }

    public function insertedUserbons()
    {
        return $this->hasMany('\App\Userbon');
    }

    public function checkoutstatus()
    {
        return $this->belongsTo("\App\Checkoutstatus");
    }

    public function children()
    {
        return $this->belongsToMany('App\Orderproduct', 'orderproduct_orderproduct', 'op1_id', 'op2_id')
            ->withPivot('relationtype_id')
            ->join('orderproductinterrelations', 'relationtype_id', 'orderproductinterrelations.id')
            ->where("relationtype_id", Config::get("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD"));
    }

    public function orderproducttype()
    {
        return $this->belongsTo("\App\Orderproducttype");
    }

    public function getExtraCost($extraAttributevaluesId = null)
    {
        $key = "Orderproduct:getExtraCost:" . $this->cacheKey() . "\\" . (isset($extraAttributevaluesId) ? implode(".", $extraAttributevaluesId) : "-");

        return Cache::remember($key, Config::get("constants.CACHE_60"), function () use ($extraAttributevaluesId) {
            $extraCost = 0;
            if (isset($extraAttributevaluesId))
                $extraAttributevalues = $this->attributevalues->whereIn("id", $extraAttributevaluesId);
            else
                $extraAttributevalues = $this->attributevalues;
            foreach ($extraAttributevalues as $attributevalue) {
                $extraCost += $attributevalue->pivot->extraCost;
            }

            return $extraCost;
        });

    }

    public function cacheKey()
    {
        $key = $this->getKey();
        $time = isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf(
            "%s-%s",
            //$this->getTable(),
            $key,
            $time
        );
    }

    private function calculatePayableCost($calculateCost = true)
    {
        $alaaCashierFacade = new OrderproductCheckout($this, $calculateCost);
        $priceInfo = $alaaCashierFacade->checkout();
        $calculatedOrderproducts = $priceInfo["orderproductsInfo"]["calculatedOrderproducts"];
        $orderproductPriceInfo = $calculatedOrderproducts->getNewPriceForItem($calculatedOrderproducts->first());
        return $orderproductPriceInfo;

        //////////////////////////OLD CODE///////////////////////////////////

        $costArray = $this->obtainOrderproductCost(false);
        if ($withOrderCoupon) {
            return (int)((1 - ($costArray["bonDiscount"] / 100)) * (((1 - ($costArray["productDiscount"] / 100)) * $costArray["cost"]) - $costArray["productDiscountAmount"]));
            //            }
        } else {
            return (int)((1 - ($costArray["bonDiscount"] / 100)) * (((1 - ($costArray["productDiscount"] / 100)) * $costArray["cost"]) - $costArray["productDiscountAmount"]));
        }
    }

    /**
     * Obtain order total cost
     *
     * @param boolean $calculateCost
     *
     * @return array
     */
    public function obtainOrderproductCost($calculateCost = true)
    {
        $priceInfo = $this->calculatePayableCost($calculateCost);
        return [
            "cost" => $priceInfo["cost"],
            "extraCost" => $priceInfo["extraCost"],
            "productDiscount" => $priceInfo["productDiscount"],
            'bonDiscount' => $priceInfo["bonDiscount"],
            "productDiscountAmount" => $priceInfo["productDiscountAmount"],
            'customerPrice' => $priceInfo["customerCost"],
            'totalPrice' => $priceInfo["totalCost"],
        ];

        ////////////////////////////Old Code/////////////////////
        $costArray = [];
        $bonDiscount = 0;
        $productDiscount = 0;
        $productDiscountAmount = 0;
        $orderProductExtraCost = 0;
        if ($calculateCost) {
            $product = $this->product;
            if ($product->isFree)
                $costArray["cost"] = null;
            else {
                $costArray = $product->calculatePayablePrice();

                foreach ($this->attributevalues as $attributevalue) {
                    $orderProductExtraCost += $attributevalue->pivot->extraCost;
                }

                $userbons = $this->userbons;
                foreach ($userbons as $userbon) {
                    $bons = $product->bons->where("id", $userbon->bon_id)
                        ->where("isEnable", 1);
                    if ($bons->isEmpty()) {
                        $parentsArray = $this->makeParentArray($product);
                        if (!empty($parentsArray)) {
                            foreach ($parentsArray as $parent) {
                                $bons = $parent->bons->where("id", $userbon->bon_id)
                                    ->where("isEnable", 1);
                                if (!$bons->isEmpty())
                                    break;
                            }
                        }
                    }
                    if (!$bons->isEmpty()) {
                        $bonDiscount += $userbon->pivot->discount * $userbon->pivot->usageNumber;
                    }
                }
                $productDiscount = $costArray["productDiscount"];
                $productDiscountAmount = $costArray["productDiscountAmount"];
                $costArray["cost"] = (int)$costArray["cost"];
            }
        } else {
            $costArray["cost"] = $this->cost;
            foreach ($this->attributevalues as $attributevalue) {
                $orderProductExtraCost += $attributevalue->pivot->extraCost;
            }
            $userbons = $this->userbons;
            foreach ($userbons as $userbon) {
                $bonDiscount += $userbon->pivot->discount * $userbon->pivot->usageNumber;
            }

            $productDiscount = $this->discountPercentage;
            $productDiscountAmount = $this->discountAmount;
        }

        $cost = (int)$costArray["cost"];
        return [
            "cost" => $cost,
            "extraCost" => $orderProductExtraCost,
            "productDiscount" => $productDiscount,
            'bonDiscount' => $bonDiscount,
            "productDiscountAmount" => (int)$productDiscountAmount,
            'customerPrice' => (int)(((int)$cost * (1 - ($productDiscount / 100))) * (1 - ($bonDiscount / 100)) - $productDiscountAmount),
        ];
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

    /**
     * Get orderproduct's total bon discount
     *
     * @return mixed
     */
    public function getTotalBonDiscountPercentage()
    {
        $totalBonDiscountValue = $this->getTotalBonDiscountDecimalValue();

        return max($totalBonDiscountValue / 100, 1);
    }

    public function isNormalType()
    {
        if ($this->orderproducttype_id == Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT") || !isset($this->orderproductstatus_id))
            return true;
        else
            return false;
    }

    public function fillCostValues($costArray)
    {
        if (isset($costArray["cost"]))
            $this->cost = $costArray["cost"];
        else
            $this->cost = null;

        if ($this->isGiftType()) {
            $this->discountPercentage = 100;
            $this->discountAmount = 0;
        } else {
            if (isset($costArray["productDiscount"]))
                $this->discountPercentage = $costArray["productDiscount"];
            if (isset($costArray["productDiscountAmount"]))
                $this->discountAmount = $costArray["productDiscountAmount"];
        }
    }

    public function isGiftType()
    {
        if ($this->orderproducttype_id == Config::get("constants.ORDER_PRODUCT_GIFT"))
            return true;
        else
            return false;
    }

    /** change type of orderproduct to Gift type
     *
     * @param Product $gift
     *
     * @return Orderproduct
     */
//    public function changeOrderproductTypeToGift($orderproductId)
//    {
//        $orderproduct = Orderproduct::FindorFail($orderproductId);
//        $orderproduct->orderproducttype_id = Config::get("constants.ORDER_PRODUCT_GIFT");
//        $orderproduct->save();
//
//        return $orderproduct;
//    }


    public function parents()
    {
        return $this->belongsToMany('App\Orderproduct', 'orderproduct_orderproduct', 'op2_id', 'op1_id')
            ->withPivot('relationtype_id')
            ->join('orderproductinterrelations', 'relationtype_id', 'orderproductinterrelations.id')
            ->where("relationtype_id", Config::get("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD"));
    }

    public static function deleteOpenedTransactions(array $intendedProductsId, array $intendedOrderStatuses): void
    {
        Orderproduct::whereIn("product_id", $intendedProductsId)
            ->whereHas("order", function ($q) use ($intendedOrderStatuses) {
                $q->whereIn("orderstatus_id", $intendedOrderStatuses)
                    ->whereDoesntHave("transactions", function ($q2) {
                        $q2->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY"));
                    });
            })->delete();
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new OrderproductCollection($models);
    }


    /**
     * @param $value
     * @return float|int
     */
    public function getDiscountPercentageAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Checks whether orderproduct included in coupon or not and
     * fills the appropriate table column
     *
     * @param Coupon $coupon
     *
     * @return bool
     */
    public function IsOrderproductIncludedInCoupon(Coupon $coupon)
    {
        if ($coupon->coupon_type == config("constants.COUPON_TYPE_OVERALL")) {
            $flag = true;
        } else {
            $flag = $this->product->hasThisCoupon($coupon);
        }

        return $flag;
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
        $myParent = $this->product->getGrandParent();

        foreach ($extraAttributes as $extraAttribute) {
            $productAttributevalue = $myParent->attributevalues->where("id", $extraAttribute->id)->first();

            if (!isset($productAttributevalue)) {
                $this->attributevalues()
                    ->detach($productAttributevalue);
            } else {
                $newExtraCost = $productAttributevalue->pivot->extraCost;
                $this->attributevalues()
                    ->updateExistingPivot($extraAttribute->id, ["extraCost" => $newExtraCost]);
            }
        }
    }

    public function renewUserBons()
    {
        $userbons = $this->userbons;
        if ($userbons->isNotEmpty()) {
            $bonName = config("constants.BON1");

            $bons = $this->product->getTotalBons($bonName);

            if ($bons->isEmpty()) {
                foreach ($userbons as $userBon) {
                    $this->userbons()->detach($userBon);

                    $userBon->usedNumber = 0;
                    $userBon->userbonstatus_id = config("constants.USERBON_STATUS_ACTIVE");
                    $userBon->update();
                }

            } else {
                $bon = $bons->first();
                foreach ($userbons as $userbon) {
                    $newDiscount = $bon->pivot->discount;
                    $this->userbons()
                        ->updateExistingPivot($userbon->id, ["discount" => $newDiscount]);
                }
            }
        }
    }

    /**
     * @param $userBons
     * @param Bon $bon
     */
    public function applyBons($userBons, Bon $bon): void
    {
        foreach ($userBons as $userBon) {
            $remainBonNumber = $userBon->void();
            $this->userbons()
                ->attach($userBon->id, [
                    "usageNumber" => $remainBonNumber,
                    "discount" => $bon->pivot->discount,
                ]);
        }
        Cache::tags('bon')->flush();
    }
}
