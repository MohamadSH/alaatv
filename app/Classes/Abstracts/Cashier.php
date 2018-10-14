<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/11/2018
 * Time: 2:33 PM
 */

namespace App\Classes\Abstracts;


abstract class Cashier
{
    /*
    |--------------------------------------------------------------------------
    | Properties Methods
    |--------------------------------------------------------------------------
    */

    private $rawCost ;
    private $discountPercentage;
    private $bonDiscountPercentage;
    private $totalBonNumber;
    private $discountCashAmount ;

    /**
     * CostCentre constructor.
     */
    public function __construct()
    {
        $this->rawCost = 0 ;
        $this->discountPercentage = 0 ;
        $this->bonDiscountPercentage = 0 ;
        $this->discountCashAmount = 0 ;
        $this->totalBonNumber = 0 ;
    }

    /*
    |--------------------------------------------------------------------------
    | Abstract Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Calculates the price
     *
     * @return mixed
     */
    abstract public function calculatePrice();

    /**
     * Calculates bon discount
     *
     * @return mixed
     */
    abstract public function calculateBonDiscount();

    /**
     * Calculates total discount cash amount
     *
     * @return mixed
     */
    abstract public function calculateTotalDiscountAmount();

    /*
    |--------------------------------------------------------------------------
    | Public Methods
    |--------------------------------------------------------------------------
    */

    /**
     *
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

    /**
     * @return int
     */
    public function getTotalBonNumber(): int
    {
        return $this->totalBonNumber;
    }

    /**
     * @param int $rawCost
     * @return Cashier
     */
    public function setRawCost( $rawCost): Cashier
    {
        $this->rawCost = $rawCost;
        return $this;
    }

    /**
     * @param int $discountPercentage
     * @return Cashier
     */
    public function setDiscountPercentage( $discountPercentage): Cashier
    {
        $this->discountPercentage = $discountPercentage;
        return $this;
    }

    /**
     * @param int $bonDiscountPercentage
     * @return Cashier
     */
    public function setBonDiscountPercentage( $bonDiscountPercentage): Cashier
    {
        $this->bonDiscountPercentage = $bonDiscountPercentage;
        return $this;
    }

    /**
     * @param int $totalBonNumber
     * @return Cashier
     */
    public function setTotalBonNumber(int $totalBonNumber): Cashier
    {
        $this->totalBonNumber = $totalBonNumber;
        return $this;
    }

    /**
     * @param int $discountCashAmount
     * @return Cashier
     */
    public function setDiscountCashAmount( $discountCashAmount): Cashier
    {
        $this->discountCashAmount = $discountCashAmount;
        return $this;
    }

}