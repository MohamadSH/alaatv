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
    public function getPrice() :string {
        $priceInfo =  [
            'price' => $this->calculatePrice(),
            'info' => [
                'productCost' => $this->rawCost,
                'discount' => [
                    'totalAmount' => $this->calculateTotalDiscountAmount(),
                    'info' => [
                        'bon' => [
                            'totalAmount' => $this->getBonDiscount(),
                            'info' => [
                                $this->bonName => [
                                    'number' => $this->totalBonNumber,
                                    'perUnitPercentage' => $this->bonDiscountPercentage,
                                    'totalPercentage' => $this->getBonTotalPercentage(),
                                ]
                            ]
                        ],
                        'product' => [
                            'totalAmount' => $this->getProductDiscount(),
                            'info' => [
                                'amount' => $this->discountCashAmount,
                                'percentage' => $this->discountPercentage
                            ]
                        ],
                    ]
                ]
            ],
        ];

        return json_encode($priceInfo);
    }

}
