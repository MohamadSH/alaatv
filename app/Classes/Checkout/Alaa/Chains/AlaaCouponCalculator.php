<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 5:38 PM
 */

namespace App\Classes\Checkout\Alaa\Chains;


use App\Classes\Abstracts\CouponCalculator;

class AlaaCouponCalculator extends CouponCalculator
{
    protected function calculateDiscount($couponDiscountType , $totalRawPriceWhichHasDiscount):int
    {
        $totalPrice = 0 ;
        if ($couponDiscountType !== false) {
            if ($couponDiscountType["type"] == config("constants.DISCOUNT_TYPE_PERCENTAGE"))
                $totalPrice = ((1 - ($couponDiscountType["discount"] / 100)) * $totalRawPriceWhichHasDiscount);
            else if ($couponDiscountType["type"] == config("constants.DISCOUNT_TYPE_COST"))
                $totalPrice = $totalRawPriceWhichHasDiscount - $couponDiscountType["discount"];
        }
        return $totalPrice;
    }
}