<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:29 PM
 */

namespace App\Classes\Payment\RefinementRequest\Strategies;


use App\Order;
use App\Classes\Payment\RefinementRequest\Refinement;

class OrderIdRefinement extends Refinement
{
    private $orderId;

    /**
     * @return Refinement
     */
    function loadData(): Refinement
    {
        if($this->statusCode!=Response::HTTP_OK) {
            return $this;
        }
        $this->orderId = $this->inputData['order_id'];
        $this->getOrder();
        if(isset($this->order)) {
            $this->user = $this->order->user;
            $this->getOrderCost();
            $this->order->cancelOpenOnlineTransactions();
            $result = $this->getNewTransaction();
            $this->statusCode = $result['statusCode'];
            $this->message = $result['message'];
            $this->transaction = $result['transaction'];
            $this->statusCode = Response::HTTP_OK;
        } else {
            $this->statusCode = Response::HTTP_NOT_FOUND;
            $this->message = 'سفارشی یافت نشد.';
        }
        return $this;
    }

    private function getOrder(): void
    {
        $this->order = Order::with(['transactions', 'coupon'])->find($this->orderId);
    }
}