<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 4:10 PM
 */

namespace App\Classes\Checkout\Alaa\Chains;

use App\Classes\Abstracts\OrderproductGroupPriceCalculatorFromNewBase;
use App\Classes\Abstracts\Pricing\OrderproductPriceCalculator;
use App\Classes\Pricing\Alaa\AlaaOrderproductPriceCalculator;
use App\Orderproduct;
use Illuminate\Support\Collection;

class AlaaOrderproductGroupPriceCalculatorFromNewBase extends OrderproductGroupPriceCalculatorFromNewBase
{
    const MODE = OrderproductPriceCalculator::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_BASE;

    protected function getOrderproductGroupPrice(Collection $orderproductsToCalculateFromBase):Collection
    {
        foreach ($orderproductsToCalculateFromBase as $orderproduct)
        {
            $priceInfo =  $this->getOrderproductPrice($orderproduct);
            $orderproductsToCalculateFromBase->setNewPriceForItem($orderproduct , $priceInfo);
        }

        return $orderproductsToCalculateFromBase ;
    }


    /**
     * Gets Orderproduct price
     *
     * @param Orderproduct $orderproduct
     * @return mixed
     */
    private function getOrderproductPrice(Orderproduct $orderproduct)
    {
        $orderproductCalculator = new AlaaOrderproductPriceCalculator($orderproduct);
        $orderproductCalculator->setMode(self::MODE);
        return $orderproductCalculator->getPrice();
    }
}