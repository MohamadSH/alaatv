<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/11/2018
 * Time: 2:51 PM
 */

namespace App\Classes\Pricing\Alaa;


use App\Classes\Abstracts\CostCentre;

class AlaaCostCentre Extends CostCentre
{
    /**
     * @return mixed
     */
    public function calculatePrice()
    {
        return self::priceFormula($this->getRawCost() , $this->getBonDiscountPercentage() , $this->getBonDiscountPercentage() , $this->getDiscountCashAmount());
    }

    /**
     * @param $rawCost
     * @param $discountPercentage
     * @param $bonDiscountPercentage
     * @param $discountCashAmount
     * @return int
     */
    public function priceFormula($rawCost , $discountPercentage , $bonDiscountPercentage , $discountCashAmount) :int
    {
        $intRawCost = (int)$rawCost;
        $payablePercentage = 1 - ($discountPercentage / 100);
        $payableBonPercentage = 1 - ($bonDiscountPercentage / 100) ;

        $result =  (($intRawCost*$payablePercentage) - $payableBonPercentage) - $discountCashAmount ;
        $result = (int)$result;

        return $result ;
    }


}