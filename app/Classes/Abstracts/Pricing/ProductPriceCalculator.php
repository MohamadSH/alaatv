<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/30/2018
 * Time: 4:59 PM
 */

namespace App\Classes\Abstracts\checkout;

use App\Product;
use App\User;

abstract class ProductPriceCalculator

{
    /*
    |--------------------------------------------------------------------------
    | Properties Methods
    |--------------------------------------------------------------------------
    */

    protected $bonName;

    protected $rawCost;

    protected $discountValue;

    protected $discountPercentage;

    protected $bonDiscountPercentage;

    protected $totalBonNumber;

    protected $discountCashAmount;

    /**
     * CostCentre constructor.
     *
     * @param User    $user
     * @param Product $product
     */
    public function __construct(Product $product, User $user = null)
    {
        $this->rawCost            = $product->obtainPrice($user);
        $this->discountValue      = $product->getFinalDiscountValue();
        $this->discountPercentage = $product->obtainDiscount();
        $this->discountCashAmount = $product->obtainDiscountAmount();

        $bonName              = config("constants.BON1");
        $this->bonName        = $bonName;
        $this->totalBonNumber = (int)optional($user)->userHasBon($bonName);
        if (isset($user)) //Note: With out this if we query the database every time even when there is nothing to do with bon discount like calculating order's cost
        {
            $this->bonDiscountPercentage = $product->obtainBonDiscount($bonName);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Abstract Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Returns price info array
     *
     * @return
     */
    abstract public function getPrice();

    /*
    |--------------------------------------------------------------------------
    | Protected Methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param int $rawCost
     *
     * @return ProductPriceCalculator
     */
    public function setRawCost($rawCost): ProductPriceCalculator
    {
        $this->rawCost = $rawCost;

        return $this;
    }

    /**
     * @param int $discountPercentage
     *
     * @return ProductPriceCalculator
     */
    public function setDiscountPercentage($discountPercentage): ProductPriceCalculator
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    /**
     * @param int $bonDiscountPercentage
     *
     * @return ProductPriceCalculator
     */
    public function setBonDiscountPercentage($bonDiscountPercentage): ProductPriceCalculator
    {
        $this->bonDiscountPercentage = $bonDiscountPercentage;

        return $this;
    }

    /**
     * @param int $totalBonNumber
     *
     * @return ProductPriceCalculator
     */
    public function setTotalBonNumber(int $totalBonNumber): ProductPriceCalculator
    {
        $this->totalBonNumber = $totalBonNumber;

        return $this;
    }

    /**
     * @param int $discountCashAmount
     *
     * @return ProductPriceCalculator
     */
    public function setDiscountCashAmount($discountCashAmount): ProductPriceCalculator
    {
        $this->discountCashAmount = $discountCashAmount;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Public Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Calculates the price
     *
     * @return mixed
     */
    protected function calculatePrice(): int
    {
        return $this->rawCost - $this->calculateTotalDiscountAmount();
    }

    /**
     * Calculates total discount cash amount
     *
     * @return mixed
     */
    protected function calculateTotalDiscountAmount(): int
    {
        return $this->getBonDiscount() + $this->getProductDiscount();
    }

    /**
     * Calculates bon discount
     *
     * @return mixed
     */
    protected function getBonDiscount(): int
    {
        return $this->getBonTotalPercentage() * ($this->rawCost - $this->getProductDiscount());
    }

    /**
     * Obtains total bon percentage
     *
     * @return float|int
     */
    protected function getBonTotalPercentage()
    {
        return min($this->bonDiscountPercentage * $this->totalBonNumber, 1);
    }

    /**
     * Obtains total discount product percentage based on product discount
     *
     * @return int
     */
    protected function getProductDiscount(): int
    {
        return max($this->discountPercentage * $this->rawCost, $this->discountCashAmount);
    }
}
