<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/11/2018
 * Time: 2:33 PM
 */

namespace App\Classes\Abstracts;


use App\Product;
use App\User;

abstract class Cashier
{
    /*
    |--------------------------------------------------------------------------
    | Properties Methods
    |--------------------------------------------------------------------------
    */

    protected $bonName;
    protected $rawCost ;
    protected $discountPercentage;
    protected $bonDiscountPercentage;
    protected $totalBonNumber;
    protected $discountCashAmount ;

    /**
     * CostCentre constructor.
     * @param User $user
     * @param Product $product
     */
    public function __construct(Product $product , User $user = null)
    {
        $this->rawCost = $product->obtainPrice() ;
        $this->discountPercentage = $product->obtainDiscount() ;
        $this->discountCashAmount = $product->obtainDiscountAmount() ;

        $bonName = config("constants.BON1");
        $this->bonName = $bonName;
        $this->totalBonNumber = (int)optional($user)->userHasBon($bonName) ;
        $this->bonDiscountPercentage = $product->obtainBonDiscount($bonName) ;
    }

    /*
    |--------------------------------------------------------------------------
    | Abstract Methods
    |--------------------------------------------------------------------------
    */


    /**
     * Returns price info array
     *
     * @return array
     */
    abstract public function getPrice() :string ;

    /*
    |--------------------------------------------------------------------------
    | Protected Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Calculates the price
     *
     * @return mixed
     */
    protected function calculatePrice() :int {
        return $this->rawCost - $this->calculateTotalDiscountAmount();
    }

    /**
     * Calculates total discount cash amount
     *
     * @return mixed
     */
    protected function calculateTotalDiscountAmount() :int {
        return $this->getBonDiscount() + $this->getProductDiscount();
    }

    /**
     * Calculates bon discount
     *
     * @return mixed
     */
    protected function getBonDiscount() :int {
        return $this->getBonTotalPercentage() * $this->rawCost;
    }

    /**
     * Obtains total discount product percentage based on product discount
     *
     * @return int
     */
    protected function getProductDiscount() :int {
        return max($this->discountPercentage * $this->rawCost , $this->discountCashAmount);
    }

    /**
     * Obtains total bon percentage
     *
     * @return float|int
     */
    protected function getBonTotalPercentage()
    {
        return $this->bonDiscountPercentage * $this->totalBonNumber;
    }

    /*
    |--------------------------------------------------------------------------
    | Public Methods
    |--------------------------------------------------------------------------
    */
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