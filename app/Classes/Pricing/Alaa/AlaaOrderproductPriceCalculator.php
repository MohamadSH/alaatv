<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/2/2018
 * Time: 12:37 PM
 */

namespace App\Classes\Pricing\Alaa;

use App\Classes\Abstracts\Pricing\OrderproductPriceCalculator;

class AlaaOrderproductPriceCalculator extends OrderproductPriceCalculator
{
    public function getPrice()
    {
//        $priceInfo =  [
//            ///////////////Details///////////////////////
//            "cost"                            => $price,
//            "extraCost"                       => $orderProductExtraPrice,
//            "productDiscount"                 => $productDiscountValue,
//            "productDiscountPercentage"       => $productDiscountPercentage,
//            'bonDiscount'                     => $totalBonDiscountPercentage,
//            "productDiscountAmount"           => (int)$productDiscountAmount,
//            ////////////////////Total///////////////////////
//            'customerCost'                    => $customerPrice,
//            'totalCost'                       => $totalPrice
//        ];
        
        $priceInfo = $this->getOrderproductPrice();
        
        return $priceInfo;
    }
}