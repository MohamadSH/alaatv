<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/22/2018
 * Time: 3:42 PM
 */

namespace App\Classes\Pricing\Alaa;

use App\Classes\Abstracts\Pricing\OrderInvoiceGenerator;
use App\Collection\OrderproductCollection;
use App\Order;

class AlaaInvoiceGenerator extends OrderInvoiceGenerator
{
    /**
     * @return array
     * @throws \Exception
     */
    public function generateInvoice():array
    {
        $order = $this->order;
        $orderproductsInfo = $this->getOrderproductsInfo($order);
        /** @var OrderproductCollection $orderproducts */
        $orderproducts = $orderproductsInfo['purchasedOrderproducts'];

        $orderproducts->reCheckOrderproducs();

        $order = $order->fresh();

        $orderPriceArray = $order->obtainOrderCost(true);

        /** @var OrderproductCollection $calculatedOrderproducts */
        $calculatedOrderproducts = $orderPriceArray['calculatedOrderproducts'];
        $calculatedOrderproducts->updateCostValues();

//        $costCollection = $calculatedOrderproducts->getNewPrices();

        $orderproductsRawCost = $orderPriceArray['sumOfOrderproductsRawCost'];
        $totalCost = $orderPriceArray['totalCost'];
        $payableByWallet = $orderPriceArray['payableAmountByWallet'];
        $orderproducts = $orderproducts->groupBy('grandId');
        return [
          'orderproducts'           => $orderproducts,
//          'costCollection'          => $costCollection,
          'orderproductsRawCost'    => $orderproductsRawCost,
          'totalCost'               => $totalCost,
          'payableByWallet'         => $payableByWallet,
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    private function getOrderproductsInfo(Order $order)
    {
        /** @var OrderproductCollection $allOrderproducts */
        $allOrderproducts = $order->orderproducts->sortByDesc('created_at');

        $purchasedOrderproducts = $allOrderproducts->whereType([config('constants.ORDER_PRODUCT_TYPE_DEFAULT')]);
        $giftOrderproducts = $allOrderproducts->whereType([config('constants.ORDER_PRODUCT_GIFT')]);

        return [
            'purchasedOrderproducts' => $purchasedOrderproducts,
            'giftOrderproducts'      => $giftOrderproducts,
        ];
    }
}