<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 5:56 PM
 */

namespace App\Classes\Abstracts;


use App\Classes\Abstracts\checkout\CheckoutProcessor;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Exception;

abstract class OrderproductSumCalculator extends CheckoutProcessor
{

    public function process(Cashier $cashier)
    {
        $calculatedOrderproducts = $cashier->getCalculatedOrderproducts();
        if(!isset($calculatedOrderproducts))
        {
            throw new Exception('There is no calculated orderproducts');
        }

        [
            $totalRawPriceWhichHasDiscount,
            $totalRawPriceWhichDoesntHaveDiscount
        ]
        = $this->calculateSum($calculatedOrderproducts);

        $cashier->setTotalRawPriceWhichDoesntHaveDiscount($totalRawPriceWhichDoesntHaveDiscount)
                ->setTotalRawPriceWhichHasDiscount($totalRawPriceWhichHasDiscount);

        return $this->next($cashier) ;
    }

    /**
     * Calculates the sum price for passed Orderproduct collection
     *
     * @param Collection $calculatedOrderproducts
     * @return array
     */
    abstract protected function calculateSum(Collection $calculatedOrderproducts) :array ;
}