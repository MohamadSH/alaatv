<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/1/2018
 * Time: 1:12 PM
 */

namespace App\Classes\Checkout\Alaa;

use App\Classes\Abstracts\Cashier;
use App\Classes\Checkout\Alaa\AlaaCashier;
use App\Classes\Interfaces\CheckoutInvoker;
use App\Order;

class OrderCheckout extends CheckoutInvoker
{
    private $order ;
    private $orderproductsToCalculateFromBaseIds;


    /**
     * OrderCheckout constructor.
     * @param Order $order
     * @param array $orderproductsToCalculateFromBaseIds
     */
    public function __construct(Order $order , array $orderproductsToCalculateFromBaseIds = [])
    {
        $this->order = $order ;
        $this->orderproductsToCalculateFromBaseIds = $orderproductsToCalculateFromBaseIds;
    }

    public function setChainClassesNameSpace($chainClassesNameSpace): void
    {

    }

    /**
     * @return array
     */
    protected function fillChainArray():array
    {
        $chainCells = [];
        if ($this->order->hasCoupon()) {
            $chainCells = ["AlaaOrderproductCouponChecker"];
        }

        $chainCells = array_merge( $chainCells ,  [
            "AlaaOrderproductGroupPriceCalculatorFromNewBase",
            "AlaaOrderproductGroupPriceCalculatorFromRecord",
            "AlaaOrderproductSumCalculator",
            "AlaaCouponCalculator",
            "AlaaOrderPriceCalculator",
            "AlaaOrderDiscountCalculator",
        ]);
        return $chainCells;
    }

    protected function initiateCashier():Cashier
    {
        $orderproducts = $this->order->normalOrderproducts->sortByDesc("created_at");
        //Note: It is not cashier's duty to get orderproducts collection because
        //It will make a coupling between cashier and order. It is facade's duty to make cashier work
        //in the way it wants
        $orderproductsToCalculateFromBase = $orderproducts->whereIn("id" , $this->orderproductsToCalculateFromBaseIds);
        $orderproductsToCalculateFromRecord = $orderproducts->whereNotIn("id" , $this->orderproductsToCalculateFromBaseIds);

        $alaaCashier = new AlaaCashier();
        $alaaCashier->setOrder($this->order)
                    ->setOrderCoupon($this->order->coupon)
                    ->setOrderDiscount($this->order->discount)
                    ->setOrderCouponDiscountType($this->order->coupon_discount_type)
                    ->setRawOrderproductsToCalculateFromBase($orderproductsToCalculateFromBase)
                    ->setRawOrderproductsToCalculateFromRecord($orderproductsToCalculateFromRecord);

        return $alaaCashier;
    }

    public function getChainClassesNameSpace(): string
    {
        return __NAMESPACE__."\\Chains";
    }
}