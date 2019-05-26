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
     * @param $order
     *
     * @return array
     */
    protected function handleOrderSuccessPayment(Order $order): void
    {
        $order->closeWalletPendingTransactions();

        $order = $order->fresh();
        
        $updateOrderPaymentStatusResult = $this->updateOrderPaymentStatus($order);
        
        /** Attaching user bons for this order */
        if ($updateOrderPaymentStatusResult['paymentstatus_id'] == config('constants.PAYMENT_STATUS_PAID')) {
            $this->givesOrderBonsToUser($order);
        }
    }
    
    /**
     * @param  \App\Order  $order
     *
     * @return array
     */
    protected function updateOrderPaymentStatus(Order $order): array
    {
        $paymentstatus_id = (int) $order->totalPaidCost() < (int) $order->totalCost() ? config('constants.PAYMENT_STATUS_INDEBTED') : config('constants.PAYMENT_STATUS_PAID');
        
        $result['paymentstatus_id'] = $paymentstatus_id;

//        uncomment if you don't close order before redirecting to gateway
        if(in_array($order->orderstatus_id , Order::OPEN_ORDER_STATUSES))
            $order->close();

        $order->paymentstatus_id = $paymentstatus_id;
        $order->update();
        
        return $result;
    }
    
    /**
     * @param  \App\Order  $order
     *
     * @return array
     */
    private function givesOrderBonsToUser(Order $order): void
    {
        $bonName = config('constants.BON1');
        $bon     = Bon::ofName($bonName)
            ->first();
        
        if (!isset($bon)) {
            return;
        }
        
        list($givenBonNumber, $failedBonNumber) = $order->giveUserBons($bonName);
        
    }
}
