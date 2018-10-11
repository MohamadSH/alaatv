<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/11/2018
 * Time: 2:33 PM
 */

namespace App\Classes\Abstracts;


abstract class CostCentre
{
    /*
    |--------------------------------------------------------------------------
    | Properties Methods
    |--------------------------------------------------------------------------
    */

    private $rawCost ;
    private $discountPercentage;
    private $bonDiscountPercentage;
    private $discountCashAmount ;

    /**
     * CostCentre constructor.
     * @param $rawCost
     * @param $discountPercentage
     * @param $bonDiscountPercentage
     * @param $discountCashAmount
     */
    public function __construct($rawCost , $discountPercentage , $bonDiscountPercentage , $discountCashAmount)
    {
        $this->rawCost = $rawCost;
        $this->discountPercentage = $discountPercentage;
        $this->bonDiscountPercentage = $bonDiscountPercentage;
        $this->discountCashAmount = $discountCashAmount;
    }

    /*
    |--------------------------------------------------------------------------
    | Abstract Methods
    |--------------------------------------------------------------------------
    */

    abstract public function calculatePrice() ;

    abstract public function priceFormula();

    /*
    |--------------------------------------------------------------------------
    | Public Methods
    |--------------------------------------------------------------------------
    */

    /**
     * @return mixed
     */
    public function getRawCost()
    {
        return $this->rawCost;
    }

    /**
     * @return mixed
     */
    public function getDiscountPercentage()
    {
        return $this->discountPercentage;
    }

    /**
     * @return mixed
     */
    public function getBonDiscountPercentage()
    {
        return $this->bonDiscountPercentage;
    }

    /**
     * @return mixed
     */
    public function getDiscountCashAmount()
    {
        return $this->discountCashAmount;
    }

}