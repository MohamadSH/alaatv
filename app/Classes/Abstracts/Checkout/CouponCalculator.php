<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 5:37 PM
 */

namespace App\Classes\Abstracts;


use App\Classes\Abstracts\checkout\CheckoutProcessor;
use PHPUnit\Framework\Exception;

abstract class CouponCalculator extends CheckoutProcessor
{
    public function process(Cashier $cashier)
    {
        $couponDiscountType = $cashier->getOrderCouponDiscountType();
        $totalRawPriceWhichHasDiscount = $cashier->getTotalRawPriceWhichHasDiscount();
        if(!isset($totalRawPriceWhichHasDiscount) || !isset($couponDiscountType))
        {
            throw new Exception('There is no total price with discount');
        }

        $totalPriceWithDiscount = $this->calculateDiscount($couponDiscountType , $totalRawPriceWhichHasDiscount);

        $cashier->setTotalPriceWithDiscount($totalPriceWithDiscount);

        return $this->next($cashier) ;
    }

    /**
     * Calculates discount for passed price and coupon discount type
     *
     * @param $couponDiscountType
     * @param $totalRawPriceWhichHasDiscount
     * @return int
     */
    abstract protected function calculateDiscount($couponDiscountType , $totalRawPriceWhichHasDiscount):int;
}