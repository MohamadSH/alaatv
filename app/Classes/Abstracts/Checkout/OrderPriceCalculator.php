<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 4:09 PM
 */

namespace App\Classes\Abstracts;


use App\Classes\Abstracts\checkout\CheckoutProcessor;
use PHPUnit\Framework\Exception;

abstract class OrderPriceCalculator extends CheckoutProcessor
{
    public function process(Cashier $cashier)
    {
        $totalRawPriceWhichDoesntHaveDiscount = $cashier->getTotalRawPriceWhichDoesntHaveDiscount();
        $totalPriceWithDiscount = $cashier->getTotalPriceWithDiscount();
        if(!isset($totalRawPriceWhichDoesntHaveDiscount) || !isset($totalPriceWithDiscount))
        {
            throw new Exception('Could not calculate total price');
        }

        $totalPrice =  $this->calculateOrderPrice($totalRawPriceWhichDoesntHaveDiscount , $totalPriceWithDiscount );

        $cashier->setTotalPrice($totalPrice);

        return $this->next($cashier) ;
    }

    /**
     * Calculates final price for passed total price and discount
     *
     * @param $totalRawPriceWhichDoesntHaveDiscount
     * @param $totalPriceWithDiscount
     * @param $discount
     * @return int
     */
    abstract protected function calculateOrderPrice($totalRawPriceWhichDoesntHaveDiscount , $totalPriceWithDiscount ):int;
}