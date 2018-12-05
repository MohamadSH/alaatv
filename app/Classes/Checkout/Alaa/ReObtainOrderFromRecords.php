<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/4/2018
 * Time: 3:56 PM
 */

namespace App\Classes\Checkout\Alaa;


use App\Classes\Abstracts\Cashier;
use App\Classes\Checkout\Alaa\AlaaCashier;
use App\Classes\Interfaces\CheckoutInvoker;
use App\Order;

class ReObtainOrderFromRecords extends CheckoutInvoker
{
    private $order;
    private $totalRawPriceWhichHasDiscount;
    private $totalRawPriceWhichDoesntHaveDiscount;
    private $couponDiscountType;
    private $orderDiscount;

    /**
     * OrderCheckout constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order ;
        $this->totalRawPriceWhichHasDiscount = isset($order->cost)?$order->cost:0;
        $this->totalRawPriceWhichDoesntHaveDiscount = isset($order->costwithoutcoupon)?$order->costwithoutcoupon:0;
        $this->couponDiscountType = $order->coupon_discount_type;
        $this->orderDiscount = $order->discount;
    }

    protected function fillChainArray(): array
    {
        return [
           "AlaaCouponCalculator",
           "AlaaOrderPriceCalculator",
           "AlaaOrderDiscountCalculator"
        ];
    }

    protected function initiateCashier():Cashier
    {
        $alaaCashier = new AlaaCashier();

        $alaaCashier->setOrder($this->order);
        $alaaCashier->setTotalRawPriceWhichHasDiscount($this->totalRawPriceWhichHasDiscount);
        $alaaCashier->setOrderCouponDiscountType($this->couponDiscountType);
        $alaaCashier->setTotalRawPriceWhichDoesntHaveDiscount($this->totalRawPriceWhichDoesntHaveDiscount);
        $alaaCashier->setOrderDiscount($this->orderDiscount);

        return $alaaCashier;
    }

    public function getChainClassesNameSpace(): string
    {
        return __NAMESPACE__."\\Chains";
    }

}