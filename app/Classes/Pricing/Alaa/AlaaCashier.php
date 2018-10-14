<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/11/2018
 * Time: 2:51 PM
 */

namespace App\Classes\Pricing\Alaa;


use App\Classes\Abstracts\Cashier;

class AlaaCashier Extends Cashier
{
    /**
     * @return mixed
     */
    public function calculatePrice()
    {
        $intRawCost = self::getRawCost();
        $discountPercentage = self::getDiscountPercentage() ;
        $bonDiscountPercentage = self::getBonDiscountPercentage() ;
        $totalBonNumber = self::getTotalBonNumber();
        $discountCashAmount = self::getDiscountCashAmount();

        $payablePercentage = 1 - $discountPercentage ;
        $payableBonPercentage = 1 - ($bonDiscountPercentage * $totalBonNumber) ;

        $result =  (($intRawCost*$payablePercentage) * $payableBonPercentage) - $discountCashAmount ;

        return $result ;
    }


    /**
     * @return mixed
     */
    public function calculateBonDiscount()
    {
        $discount = self::getBonDiscountPercentage();
        $totalBonNumber = self::getTotalBonNumber() ;
        return $discount * $totalBonNumber;
    }

    /**
     * @return float|int|mixed
     */
    public function calculateTotalDiscountAmount()
    {
        $intRawCost = self::getRawCost();
        $discountPercentage = self::getDiscountPercentage() ;
        $bonDiscountPercentage = self::getBonDiscountPercentage() ;
        $totalBonNumber = self::getTotalBonNumber();
        $discountCashAmount = self::getDiscountCashAmount();

        $totalBonDiscount = $totalBonNumber * $bonDiscountPercentage;
        
        return (($intRawCost*$discountPercentage) * $totalBonDiscount) + $discountCashAmount ;
    }

}