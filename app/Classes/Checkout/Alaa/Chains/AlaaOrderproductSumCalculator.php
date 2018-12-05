<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 4:08 PM
 */

namespace App\Classes\Checkout\Alaa\Chains;


use App\Classes\Abstracts\OrderproductSumCalculator;
use Illuminate\Support\Collection;

class AlaaOrderproductSumCalculator extends OrderproductSumCalculator
{
    /**
     * @param Collection $calculatedOrderproducts
     * @return array
     */
    protected function calculateSum(Collection $calculatedOrderproducts) :array
    {
        $totalRawPriceWhichHasDiscount = 0 ;
        $totalRawPriceWhichDoesntHaveDiscount = 0 ;//totalRawPriceWhichDoesntHaveDiscount
        foreach ($calculatedOrderproducts as $orderproduct) {
            $orderproductPriceInfo = $orderproduct->priceInfo;

            $orderproductPrice = $orderproductPriceInfo->totalCost;
            $orderproductExtraPrice = $orderproductPriceInfo->extraCost;

            if ($orderproduct->includedInCoupon == 1) {
                $totalRawPriceWhichHasDiscount += $orderproductPrice;
            } else {
                $totalRawPriceWhichDoesntHaveDiscount += $orderproductPrice;
            }

            $totalRawPriceWhichDoesntHaveDiscount += $orderproductExtraPrice;
        }

        return [
            $totalRawPriceWhichHasDiscount ,
            $totalRawPriceWhichDoesntHaveDiscount
        ];
    }
}