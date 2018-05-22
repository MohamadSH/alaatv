<?php

namespace App;


use App\Traits\ProductCommon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Orderproduct extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
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
        'checkoutstatus_id'
    ];
    protected $touches = [
        'attributevalues'
    ];

    public function cacheKey()
    {
        $key = $this->getKey();
        $time= isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf(
            "%s-%s",
            //$this->getTable(),
            $key,
            $time
        );
    }

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
        return $this->belongsToMany('\App\Attributevalue', 'attributevalue_orderproduct', 'orderproduct_id', 'value_id')->withPivot("extraCost");
    }

    public function userbons()
    {
        return $this->belongsToMany('\App\Userbon')->withPivot("usageNumber", "discount");
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
        $key="Orderproduct:getExtraCost:".$this->cacheKey()."\\".(isset($extraAttributevaluesId) ? implode(".",$extraAttributevaluesId) : "-");

        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($extraAttributevaluesId) {
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

    public function calculatePayableCost($withOrderCoupon = false)
    {
        $costArray = $this->obtainOrderproductCost(false);
        if ($withOrderCoupon) {
//            $couponType = $this->order->determineCoupontype();
//            if($couponType !== false  && $this->includedInCoupon)
//            {
//                if($couponType["type"] == Config::get("constants.DISCOUNT_TYPE_PERCENTAGE"))
//                    return (int)( ((1-($costArray["bonDiscount"]/100)) * ( ( (1-($costArray["productDiscount"]/100))*$costArray["cost"]) - $costArray["productDiscountAmount"]))*(1-($couponType["discount"]/100)));
//                elseif($couponType["type"] == Config::get("constants.DISCOUNT_TYPE_COST"))
//                    return (int)( ((1-($costArray["bonDiscount"]/100)) * ( ( (1-($costArray["productDiscount"]/100))*$costArray["cost"]) - $costArray["productDiscountAmount"])) - $couponType["discount"] );
//
//            }else
//            {
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
     * @return array
     */
    public function obtainOrderproductCost($calculateCost = true)
    {
        $costArray = array();
        $bonDiscount = 0;
        $productDiscount = 0;
        $productDiscountAmount = 0;
        $orderProductExtraCost = 0;
        if ($calculateCost) {
            $product = $this->product;
            if ($product->isFree) $costArray["cost"] = null;
            else {
                $costArray = $product->calculatePayablePrice();

                foreach ($this->attributevalues as $attributevalue) {
                    $orderProductExtraCost += $attributevalue->pivot->extraCost;
                }

                $userbons = $this->userbons;
                foreach ($userbons as $userbon) {
                    $bons = $product->bons->where("id", $userbon->bon_id)->where("isEnable", 1);
                    if ($bons->isEmpty()) {
                        $parentsArray = $this->makeParentArray($product);
                        if (!empty($parentsArray)) {
                            foreach ($parentsArray as $parent) {
                                $bons = $parent->bons->where("id", $userbon->bon_id)->where("isEnable", 1);
                                if (!$bons->isEmpty()) break;
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
            'CustomerCost' =>(int)(((int)$cost * (1 - ($productDiscount / 100))) * (1 - ($bonDiscount / 100)) - $productDiscountAmount)
        ];
    }

    public function getTotalBonNumber()
    {
        $totalBonNumver = 0;
        foreach ($this->userbons as $userbon) {
            $totalBonNumver += $userbon->pivot->discount * $userbon->pivot->usageNumber;
        }
        return $totalBonNumver;
    }

    public function isNormalType()
    {
        if ($this->orderproducttype_id == Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT") || !isset($this->orderproductstatus_id)) return true;
        else
            return false;
    }

    public function fillCostValues($costArray)
    {
        if (isset($costArray["cost"])) $this->cost = $costArray["cost"];
        else $this->cost = null;

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

    /** Attaches a gift to the order of this orderproduct which is related to this orderproduct
     * @param Product $gift
     * @return Orderproduct
     */
    public function attachGift(Product $gift)
    {
        $giftOrderproduct = new Orderproduct();
        $giftOrderproduct->orderproducttype_id = Config::get("constants.ORDER_PRODUCT_GIFT");
        $giftOrderproduct->order_id = $this->order->id;
        $giftOrderproduct->product_id = $gift->id;
        $giftOrderproduct->cost = $gift->calculatePayablePrice()["cost"];
        $giftOrderproduct->discountPercentage = 100;
        $giftOrderproduct->save();

        $giftOrderproduct->parents()->attach($this, ["relationtype_id" => Config::get("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD")]);
        return $giftOrderproduct;
    }

    public function parents()
    {
        return $this->belongsToMany('App\Orderproduct', 'orderproduct_orderproduct', 'op2_id', 'op1_id')
            ->withPivot('relationtype_id')
            ->join('orderproductinterrelations', 'relationtype_id', 'orderproductinterrelations.id')
            ->where("relationtype_id", Config::get("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD"));
    }

}
