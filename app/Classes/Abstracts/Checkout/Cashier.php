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
    protected $orderDiscount;
    protected $orderCouponDiscountType;
    protected $rawOrderproductsToCalculateFromBase; //orderproducts that should be recalculated based on new conditions
    protected $rawOrderproductsToCalculateFromRecord; //orderproducts that should be calculated based recorded data
    protected $calculatedOrderproducts;
    protected $totalRawPriceWhichHasDiscount;
    protected $totalPriceWithDiscount; //It is total raw price which has discount after calculating it's discount
    protected $totalRawPriceWhichDoesntHaveDiscount;
    protected $totalPrice; // Total price without before calculating Order's discount
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
     * @param mixed $orderDiscount
     * @return Cashier
     */
    public function setOrderDiscount($orderDiscount)
    {
        $this->orderDiscount = $orderDiscount;
        return $this;
    }


    /**
     * @param mixed $orderCouponDiscountType
     * @return Cashier
     */
    public function setOrderCouponDiscountType($orderCouponDiscountType)
    {
        $this->orderCouponDiscountType = $orderCouponDiscountType;
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
     * @param mixed $totalPriceWithDiscount
     * @return Cashier
     */
    public function setTotalPriceWithDiscount($totalPriceWithDiscount)
    {
        $this->totalPriceWithDiscount = $totalPriceWithDiscount;
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
        return $this;
    }

    /**
     * @param mixed $totalPrice
     * @return Cashier
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @param mixed $finalPrice
     * @return Cashier
     */
    public function setFinalPrice($finalPrice)
    {
        $this->finalPrice = $finalPrice;
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
    public function getOrderDiscount()
    {
        return $this->orderDiscount;
    }


    /**
     * @return mixed
     */
    public function getOrderCouponDiscountType()
    {
        return $this->orderCouponDiscountType;
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
    public function getTotalPriceWithDiscount()
    {
        return $this->totalPriceWithDiscount;
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
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return mixed
     */
    public function getFinalPrice()
    {
        return $this->finalPrice;
    }
}