<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/2/2018
 * Time: 11:15 AM
 */

namespace App\Classes\Abstracts\Checkout;


use App\Classes\Abstracts\Cashier;
use PHPUnit\Framework\Exception;

abstract class OrderDiscountCalculator extends CheckoutProcessor
{
    public function process(Cashier $cashier)
    {
        $discount = $cashier->getOrderDiscount();
        $totalPrice = $cashier->getTotalPrice();
        if(!isset($discount) || !isset($totalPrice))
        {
            throw new Exception('Could not calculate final price');
        }

        $orderFinalPrice = $this->calculateOrderDiscount($totalPrice , $discount);

        $cashier->setFinalPrice($orderFinalPrice);
       return $this->next($cashier) ;
    }

    abstract protected function calculateOrderDiscount( $totalPrice , $discount);
}