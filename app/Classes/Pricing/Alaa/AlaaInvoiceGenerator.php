<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/22/2018
 * Time: 3:42 PM
 */

namespace App\Classes\Pricing\Alaa;

use App\Classes\Abstracts\Pricing\OrderInvoiceGenerator;
use App\Order;

class AlaaInvoiceGenerator extends OrderInvoiceGenerator
{
    /**
     * @return array
     */
    public function generateInvoice():array
    {
        $order = $this->order;
        $orderproductsInfo = $this->getOrderproductsInfo($order);
        $orderproducts = $orderproductsInfo["purchasedOrderproducts"];

        $orderproducts->reCheckOrderproducs();

        $order = $order->fresh();

        $orderPriceArray = $order->obtainOrderCost(true);

        $calculatedOrderproducts = $orderPriceArray["calculatedOrderproducts"];
        $calculatedOrderproducts->updateCostValues();

        $costCollection = $calculatedOrderproducts->getNewPrices();

        $orderproductsRawCost = $orderPriceArray["sumOfOrderproductsRawCost"];
        $totalCost = $orderPriceArray["totalCost"];
        $payablePrice = $orderPriceArray["priceToPay"];
        $paidByWallet = $orderPriceArray["amountPaidByWallet"];

        return [
          "orderItems"              => $orderproducts,
          "costCollection"          => $costCollection,
          "orderproductsRawCost"    => $orderproductsRawCost,
          "totalCost"               => $totalCost,
          "paidByWallet"            => $paidByWallet,
          "payableCost"             => $payablePrice,
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    private function getOrderproductsInfo(Order $order)
    {
        $allOrderproducts = $order->orderproducts->sortByDesc("created_at");

        $purchasedOrderproducts = $allOrderproducts->whereType([config("constants.ORDER_PRODUCT_TYPE_DEFAULT")]);
        $giftOrderproducts = $allOrderproducts->whereType([config("constants.ORDER_PRODUCT_GIFT")]);

        return [
            "purchasedOrderproducts" => $purchasedOrderproducts,
            "giftOrderproducts"      => $giftOrderproducts,
        ];
    }
}