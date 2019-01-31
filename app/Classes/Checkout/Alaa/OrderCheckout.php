<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/1/2018
 * Time: 1:12 PM
 */

namespace App\Classes\Checkout\Alaa;

use App\Classes\Abstracts\Checkout\Cashier;
use App\Classes\Abstracts\Checkout\CheckoutInvoker;
use App\Order;

class OrderCheckout extends CheckoutInvoker
{
    private $order ;
    private $orderproductsToCalculateFromBaseIds;
    private $recheckIncludedOrderproductsInCoupon;


    /**
     * OrderCheckout constructor.
     * @param Order $order
     * @param array $orderproductsToCalculateFromBaseIds
     * @param bool $recheckIncludedOrderproductsInCoupon
     */
    public function __construct(Order $order , array $orderproductsToCalculateFromBaseIds = [] , $recheckIncludedOrderproductsInCoupon = false)
    {
        $this->order = $order;
        $this->order->load('user' , 'user.wallets'  , 'normalOrderproducts' , 'normalOrderproducts.product' ,'normalOrderproducts.product.parents' , 'normalOrderproducts.userbons' , 'normalOrderproducts.attributevalues' , 'normalOrderproducts.product.attributevalues' );
        $this->orderproductsToCalculateFromBaseIds = $orderproductsToCalculateFromBaseIds;
        $this->recheckIncludedOrderproductsInCoupon = $recheckIncludedOrderproductsInCoupon;
    }

    /**
     * @return array
     */
    protected function fillChainArray():array
    {
        $chainCells = [];

        if ($this->recheckIncludedOrderproductsInCoupon && $this->order->coupon_id) {
            //For the sake of reducing queries
            $chainCells = ["AlaaOrderproductCouponChecker"];
        }

        $chainCells = array_merge( $chainCells ,  [
            "AlaaOrderproductGroupPriceCalculatorFromNewBase",
            "AlaaOrderproductGroupPriceCalculatorFromRecord",
            "AlaaOrderproductSumCalculator",
            "AlaaOrderCouponCalculatorBasedOnPercentage",
            "AlaaOrderCouponCalculatorBasedOnCostAmount",
            "AlaaOrderPriceCalculator",
            "AlaaOrderDiscountCostAmountCalculator",
            "AlaaOrderPayablePriceByWalletCalculator",
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

        $couponDiscountCostAmount = 0 ;
        $couponDiscountPercentage = 0;
        $couponType = $this->order->getCouponDiscountTypeAttribute();
        if($couponType !== false)
        {
            if($couponType["type"] == config("constants.DISCOUNT_TYPE_PERCENTAGE"))
                $couponDiscountPercentage = $couponType["discount"] / 100;
            elseif($couponType["type"] == config("constants.DISCOUNT_TYPE_COST"))
                $couponDiscountCostAmount = $couponType["discount"];
        }
        $alaaCashier = new AlaaCashier();
        $alaaCashier->setOrder($this->order)
                    ->setOrderDiscountCostAmount($this->order->discount)
                    ->setOrderCouponDiscountPercentage($couponDiscountPercentage)
                    ->setOrderCouponDiscountCostAmount($couponDiscountCostAmount)
                    ->setRawOrderproductsToCalculateFromBase($orderproductsToCalculateFromBase)
                    ->setRawOrderproductsToCalculateFromRecord($orderproductsToCalculateFromRecord);

        //For the sake of reducing queries
        if($this->order->coupon_id)
            $alaaCashier->setOrderCoupon($this->order->coupon);

        return $alaaCashier;
    }

    public function getChainClassesNameSpace(): string
    {
        return __NAMESPACE__."\\Chains";
    }
}