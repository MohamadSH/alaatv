<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/2/2018
 * Time: 11:16 AM
 */

namespace App\Classes\Checkout\Alaa\Chains;


use App\Classes\Abstracts\Checkout\OrderDiscountCalculator;

class AlaaOrderDiscountCalculator extends OrderDiscountCalculator
{
    //ToDo : High likely a strategy method could be applied

    protected function calculateOrderDiscount($totalPrice, $discount)
    {
        return $totalPrice - $discount;
    }

}