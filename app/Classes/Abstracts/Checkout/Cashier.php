<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/11/2018
 * Time: 2:33 PM
 */

namespace App\Classes\Abstracts;

use App\Order;
use Illuminate\Support\Collection;

abstract class Cashier
{
    protected $order;
    protected $orderCoupon;
    protected $orderDiscountCostAmount;
    protected $orderCouponDiscountPercentage;
    protected $orderCouponDiscountCostAmount;
    protected $rawOrderproductsToCalculateFromBase; //orderproducts that should be recalculated based on new conditions
    protected $rawOrderproductsToCalculateFromRecord; //orderproducts that should be calculated based recorded data
    protected $calculatedOrderproducts;
    protected $totalRawPriceWhichHasDiscount;
    protected $temporaryTotalPriceWithDiscount;
    protected $totalPriceWithDiscount; //It is totalRawPriceWhichHasDiscount after calculating it's discount
    protected $totalRawPriceWhichDoesntHaveDiscount;
    protected $totalPrice; // Total price before calculating Order's discount
    protected $temporaryFinalPrice;
    protected $finalPrice;


    /**
     * Presents Cashier's price data
     *
     * @return mixed
     */
    abstract public function getPrice();

    /**
     * @param mixed $order
     * @return Cashier
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param mixed $orderCoupon
     * @return Cashier
     */
    public function setOrderCoupon($orderCoupon)
    {
        $this->orderCoupon = $orderCoupon;
        return $this;
    }

    /**
     * @param mixed $orderDiscountCostAmount
     * @return Cashier
     */
    public function setOrderDiscountCostAmount($orderDiscountCostAmount)
    {
        $this->orderDiscountCostAmount = $orderDiscountCostAmount;
        return $this;
    }

    /**
     * @param mixed $orderCouponDiscountPercentage
     * @return Cashier
     */
    public function setOrderCouponDiscountPercentage($orderCouponDiscountPercentage)
    {
        $this->orderCouponDiscountPercentage = $orderCouponDiscountPercentage;
        return $this;
    }

    /**
     * @param mixed $orderCouponDiscountCostAmount
     * @return Cashier
     */
    public function setOrderCouponDiscountCostAmount($orderCouponDiscountCostAmount)
    {
        $this->orderCouponDiscountCostAmount = $orderCouponDiscountCostAmount;
        return $this;
    }


    /**
     * @param mixed $rawOrderproductsToCalculateFromBase
     * @return Cashier
     */
    public function setRawOrderproductsToCalculateFromBase($rawOrderproductsToCalculateFromBase)
    {
        $this->rawOrderproductsToCalculateFromBase = $rawOrderproductsToCalculateFromBase;
        return $this;
    }

    /**
     * @param mixed $rawOrderproductsToCalculateFromRecord
     * @return Cashier
     */
    public function setRawOrderproductsToCalculateFromRecord($rawOrderproductsToCalculateFromRecord)
    {
        $this->rawOrderproductsToCalculateFromRecord = $rawOrderproductsToCalculateFromRecord;
        return $this;
    }

    /**
     * @param Collection $calculatedOrderproducts
     * @return Cashier
     */
    public function setCalculatedOrderproducts(Collection $calculatedOrderproducts)
    {
        $this->calculatedOrderproducts = $calculatedOrderproducts;
        return $this;
    }

    /**
     * @param mixed $totalRawPriceWhichDoesntHaveDiscount
     * @return Cashier
     */
    public function setTotalRawPriceWhichDoesntHaveDiscount($totalRawPriceWhichDoesntHaveDiscount)
    {
        $this->totalRawPriceWhichDoesntHaveDiscount = $totalRawPriceWhichDoesntHaveDiscount;
        return $this;
    }

    /**
     * @param mixed $totalRawPriceWhichHasDiscount
     * @return Cashier
     */
    public function setTotalRawPriceWhichHasDiscount($totalRawPriceWhichHasDiscount)
    {
        $this->totalRawPriceWhichHasDiscount = $totalRawPriceWhichHasDiscount;
        $this->temporaryTotalPriceWithDiscount = $totalRawPriceWhichHasDiscount;
        return $this;
    }

    /**
     * @param mixed $temporaryTotalPriceWithDiscount
     * @return Cashier
     */
    public function setTemporaryTotalPriceWithDiscount($temporaryTotalPriceWithDiscount)
    {
        $this->temporaryTotalPriceWithDiscount = $temporaryTotalPriceWithDiscount;
        return $this;
    }

    /**
     * @param mixed $totalPriceWithDiscount
     * @return Cashier
     */
    public function setTotalPriceWithDiscount($totalPriceWithDiscount)
    {
        $this->totalPriceWithDiscount = $totalPriceWithDiscount;
        $this->temporaryTotalPriceWithDiscount = $totalPriceWithDiscount;
        return $this;
    }

    /**
     * @param mixed $totalPrice
     * @return Cashier
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
        $this->temporaryFinalPrice = $totalPrice;
        return $this;
    }

    /**
     * @param mixed $temporaryFinalPrice
     * @return Cashier
     */
    public function setTemporaryFinalPrice($temporaryFinalPrice)
    {
        $this->temporaryFinalPrice = $temporaryFinalPrice;
        return $this;
    }

    /**
     * @param mixed $finalPrice
     * @return Cashier
     */
    public function setFinalPrice($finalPrice)
    {
        $this->finalPrice = $finalPrice;
        $this->temporaryFinalPrice = $finalPrice;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder() :Order
    {
        return $this->order;
    }

    /**
     * @return mixed
     */
    public function getOrderCoupon()
    {
        return $this->orderCoupon;
    }

    /**
     * @return mixed
     */
    public function getOrderDiscountCostAmount()
    {
        return $this->orderDiscountCostAmount;
    }

    /**
     * @return mixed
     */
    public function getOrderCouponDiscountPercentage()
    {
        return $this->orderCouponDiscountPercentage;
    }

    /**
     * @return mixed
     */
    public function getOrderCouponDiscountCostAmount()
    {
        return $this->orderCouponDiscountCostAmount;
    }

    /**
     * @return mixed
     */
    public function getRawOrderproductsToCalculateFromBase()
    {
        return $this->rawOrderproductsToCalculateFromBase;
    }

    /**
     * @return mixed
     */
    public function getRawOrderproductsToCalculateFromRecord()
    {
        return $this->rawOrderproductsToCalculateFromRecord;
    }

    /**
     * @return Collection
     */
    public function getCalculatedOrderproducts():?Collection
    {
        return $this->calculatedOrderproducts;
    }

    /**
     * @return mixed
     */
    public function getTotalRawPriceWhichDoesntHaveDiscount()
    {
        return $this->totalRawPriceWhichDoesntHaveDiscount;
    }

    /**
     * @return mixed
     */
    public function getTotalRawPriceWhichHasDiscount()
    {
        return $this->totalRawPriceWhichHasDiscount;
    }

    /**
     * @return mixed
     */
    public function getTemporaryTotalPriceWithDiscount()
    {
        return $this->temporaryTotalPriceWithDiscount;
    }

    /**
     * @return mixed
     */
    public function getTotalPriceWithDiscount()
    {
        return $this->totalPriceWithDiscount;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return mixed
     */
    public function getTemporaryFinalPrice()
    {
        return $this->temporaryFinalPrice;
    }

    /**
     * @return mixed
     */
    public function getFinalPrice()
    {
        return $this->finalPrice;
    }
}