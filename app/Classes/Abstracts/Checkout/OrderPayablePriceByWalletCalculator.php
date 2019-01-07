<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 5:56 PM
 */

namespace App\Classes\Abstracts\Checkout;

use App\Order;
use PHPUnit\Framework\Exception;

abstract class OrderPayablePriceByWalletCalculator extends CheckoutProcessor
{

    public function process(Cashier $cashier)
    {
        $order = $cashier->getOrder();
        $priceToPay = $cashier->getPriceToPay();
        if(!isset($order))
            throw new Exception('Order has not been set');

        if(!isset($priceToPay))
            throw new Exception('Payable price has not been set');

        $priceSumInfo = $this->calculateAmountPaidByWallet($order , $priceToPay);

        $cashier->setAmountPaidByWallet($priceSumInfo["payableAmountByWallet"]);
        $cashier->setPriceToPay($priceSumInfo["priceToPay"]);

        return $this->next($cashier) ;
    }

    /**
     * Calculates the sum price for passed Orderproduct collection
     *
     * @param Order $order
     * @param $priceToPay
     * @return array
     */
    abstract protected function calculateAmountPaidByWallet(Order $order , $priceToPay);
}