<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/3/2018
 * Time: 10:37 AM
 */

namespace App\Classes\Checkout\Alaa;

use App\Classes\Abstracts\Cashier;
use App\Classes\Checkout\Alaa\AlaaCashier;
use App\Classes\Interfaces\CheckoutInvoker;
use App\Orderproduct;

class OrderproductCheckout extends CheckoutInvoker
{
    private $orderproduct ;
    private $recalculate;

    /**
     * OrderCheckout constructor.
     * @param Orderproduct $orderproduct
     * @param bool $recalculate
     */
    public function __construct(Orderproduct $orderproduct , bool $recalculate)
    {
        $this->orderproduct = $orderproduct ;
        $this->recalculate = $recalculate;
    }

    /**
     * @return array
     */
    protected function fillChainArray():array
    {
        return [
            "AlaaOrderproductGroupPriceCalculatorFromNewBase",
            "AlaaOrderproductGroupPriceCalculatorFromRecord",
        ];
    }

    protected function initiateCashier():Cashier
    {
        $orderproductsToCalculateFromBase = collect();
        $orderproductsToCalculateFromRecord = collect();
        if($this->recalculate)
            $orderproductsToCalculateFromBase = collect([$this->orderproduct]);
        else
            $orderproductsToCalculateFromRecord = collect([$this->orderproduct]);

        $alaaCashier = new AlaaCashier();
        $alaaCashier->setRawOrderproductsToCalculateFromBase($orderproductsToCalculateFromBase);
        $alaaCashier->setRawOrderproductsToCalculateFromRecord($orderproductsToCalculateFromRecord);

        return $alaaCashier;
    }

    public function getChainClassesNameSpace(): string
    {
        return __NAMESPACE__."\\Chains";
    }
}