<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-03-14
 * Time: 13:27
 */

namespace App\Traits;

use App\Bon;
use App\Order;

trait HandleOrderPayment
{

    /**
     * @param
     *
     * @return array
     */
    protected function handleOrderSuccessPayment(Order $order): array
    {
        $order->closeWalletPendingTransactions();

        $updateOrderPaymentStatusResult = $this->updateOrderPaymentStatus($order);

        /** Attaching user bons for this order */
        if ($updateOrderPaymentStatusResult['paymentstatus_id'] == config('constants.PAYMENT_STATUS_PAID')) {
            $givesOrderBonsToUserResult = $this->givesOrderBonsToUser($order);
            $updateOrderPaymentStatusResult = array_merge($updateOrderPaymentStatusResult, $givesOrderBonsToUserResult);
        }

        unset($updateOrderPaymentStatusResult['paymentstatus_id']); //ToDo

        return $updateOrderPaymentStatusResult;
    }

    /**
     * @param \App\Order $order
     *
     * @return array
     */
    protected function updateOrderPaymentStatus(Order $order): array
    {
        $result = [];
        $paymentstatus_id = null;
        if ((int)$order->totalPaidCost() < (int)$order->totalCost())
            $paymentstatus_id = config('constants.PAYMENT_STATUS_INDEBTED');
        else
            $paymentstatus_id = config('constants.PAYMENT_STATUS_PAID');

        $result['paymentstatus_id'] = $paymentstatus_id;

        $order->close($paymentstatus_id);
        $orderUpdateStatus = $order->updateWithoutTimestamp();

        if ($orderUpdateStatus) {
            $result['saveOrder'] = 1;
        } else {
            $result['saveOrder'] = 0;
        }
        return $result;
    }

    /**
     * @param \App\Order $order
     *
     * @return array
     */
    protected function givesOrderBonsToUser(Order $order): array
    {
        $result = [];
        $bonName = config('constants.BON1');
        $bon = Bon::ofName($bonName)->first();

        if (isset($bon)) {
            list($givenBonNumber, $failedBonNumber) = $order->giveUserBons($bonName);
            if ($givenBonNumber == 0) {
                if ($failedBonNumber > 0) {
                    $result['saveBon'] = -1;
                } else {
                    $result['saveBon'] = 0;
                }
            } else {
                $result['saveBon'] = $givenBonNumber;
            }

            $bonDisplayName = $bon->displayName;
            $result['bonName'] = $bonDisplayName;
        }
        return $result;
    }

    /**
     * @param \App\Order $order
     *
     * @return array
     */
    protected function handleOrderCanceledPayment(Order $order): array
    {
        $result = [];
        $order->close(config('constants.PAYMENT_STATUS_UNPAID'), config('constants.ORDER_STATUS_CANCELED'));
        $order->updateWithoutTimestamp();

        $totalWalletRefund = $order->refundWalletTransaction();

        if ($totalWalletRefund > 0) {
            $result['walletAmount'] = $totalWalletRefund;
            $result['walletRefund'] = true;
        } else {
            $result['walletAmount'] = 0;
            $result['walletRefund'] = false;
        }

        return $result;
    }
}