<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/27/2018
 * Time: 11:37 AM
 */

namespace App\Traits\Cashier;

use App\Order;

trait CashierOrderUnit
{
    protected $order;

    protected $totalPrice; // Total price before calculating Order's discount

    protected $temporaryFinalPrice;

    protected $finalPrice;

    /**
     * @param mixed $order
     * @return mixed
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param mixed $totalPrice
     * @return mixed
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
        $this->temporaryFinalPrice = $totalPrice;

        return $this;
    }

    /**
     * @param mixed $temporaryFinalPrice
     * @return mixed
     */
    public function setTemporaryFinalPrice($temporaryFinalPrice)
    {
        $this->temporaryFinalPrice = $temporaryFinalPrice;

        return $this;
    }

    /**
     * @param mixed $finalPrice
     * @return mixed
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
    public function getOrder(): Order
    {
        return $this->order;
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