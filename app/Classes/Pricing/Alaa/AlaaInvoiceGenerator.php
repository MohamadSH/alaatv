<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/22/2018
 * Time: 3:42 PM
 */

namespace App\Classes\Pricing\Alaa;

use App\Collection\OrderproductCollection;
use App\Order;
use Exception;
use Illuminate\Support\Collection;

class AlaaInvoiceGenerator
{
    /**
     * @param Order $order
     *
     * @return array
     * @throws Exception
     */
    public function generateOrderInvoice(Order $order): array
    {
        $orderproductsInfo = $this->getOrderproductsInfo($order);
        /** @var OrderproductCollection $orderproducts */
        $orderproducts = $orderproductsInfo['purchasedOrderproducts'];

        $orderproducts->reCheckOrderproducs();

        $order = $order->fresh();

        $orderPriceArray = $order->obtainOrderCost(true);

        /** @var OrderproductCollection $calculatedOrderproducts */
        $calculatedOrderproducts = $orderPriceArray['calculatedOrderproducts'];
        $calculatedOrderproducts->updateCostValues();

        $orderproductsRawCost = $orderPriceArray['sumOfOrderproductsRawCost'];
        $totalCost            = $orderPriceArray['totalCost'];
        $payableByWallet      = $orderPriceArray['payableAmountByWallet'];

        $orderProductCount = $this->orderproductFormatter($calculatedOrderproducts);

        return $this->invoiceFormatter($calculatedOrderproducts, $orderProductCount, $orderproductsRawCost, $totalCost,
            $payableByWallet);
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    private function getOrderproductsInfo(Order $order)
    {
        /** @var OrderproductCollection $allOrderproducts */
        $allOrderproducts = $order->orderproducts->sortByDesc('created_at');

        $purchasedOrderproducts = $allOrderproducts->whereType([config('constants.ORDER_PRODUCT_TYPE_DEFAULT')]);
        $giftOrderproducts      = $allOrderproducts->whereType([config('constants.ORDER_PRODUCT_GIFT')]);

        return [
            'purchasedOrderproducts' => $purchasedOrderproducts,
            'giftOrderproducts'      => $giftOrderproducts,
        ];
    }

    /**
     * Formats orderproduct collection and return total number of orderproducts
     *
     * @param OrderproductCollection $orderproducts
     *
     * @return int
     */
    private function orderproductFormatter(OrderproductCollection &$orderproducts): int
    {
        $newPrices = $orderproducts->getNewPrices();

        $orderProductCount = 0;
        $orderproducts     = new OrderproductCollection($orderproducts->groupBy('grandId')
            ->map(function ($orderproducts) use (&$orderProductCount) {
                $orderProductCount += $orderproducts->count();

                $grand = $orderproducts->first()->grandProduct;
                return [
                    'grand'         => $orderproducts->first()->grandProduct ?? null,
                    'orderproducts' => $orderproducts,
                    //For new api
//                    'grand'  => isset($grand)? New PurchasedProduct($grand) : null,
//                    'orderproducts' => OrderproductResource::Collection($orderproducts),
                ];
            })
            ->values()
            ->all());

        $orderproducts = $orderproducts->setNewPrices($newPrices);

        return $orderProductCount;
    }

    private function invoiceFormatter($orderproducts, $orderproductCount, $orderproductsRawCost, $totalCost, $payableByWallet)
    {
        $discount = $orderproductsRawCost - $totalCost;

        return [
            'items'             => $orderproducts,
            'orderproductCount' => $orderproductCount,
            'price'             => [
                'base'            => $orderproductsRawCost,
                'discount'        => $discount,
                'final'           => $totalCost,
                'payableByWallet' => $payableByWallet,
            ],
        ];
    }

    /**
     * @param Collection $fakeOrderproducts
     *
     * @return array
     */
    public function generateFakeOrderproductsInvoice(Collection $fakeOrderproducts)
    {
        /** @var OrderproductCollection $fakeOrderproducts */
        $groupPriceInfo = $fakeOrderproducts->calculateGroupPrice();

        $orderProductCount = $this->orderproductFormatter($fakeOrderproducts);

        return $this->invoiceFormatter($fakeOrderproducts, $orderProductCount, $groupPriceInfo['rawCost'],
            $groupPriceInfo['customerCost'], 0);
    }
}
