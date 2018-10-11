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
     * @return int
     */
    public function calculatePrice():int
    {
        return (int)(((int)$this->getRawCost() * (1 - ($this->getDiscountPercentage() / 100))) * (1 - ($this->getBonDiscountPercentage() / 100)) - $this->getDiscountCashAmount());
    }

    public function priceFormula()
    {
        // TODO: Implement priceFormula() method.
    }


}