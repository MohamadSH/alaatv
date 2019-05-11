<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:29 PM
 */

namespace App\Classes\Payment\RefinementRequest\Strategies;

use App\Classes\Payment\RefinementRequest\Refinement;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Response;

class OrderIdRefinement extends Refinement
{
    /**
     * @return Refinement
     */
    function loadData(): Refinement
    {
        if ($this->statusCode != Response::HTTP_OK) {
            return $this;
        }
        $orderId = $this->inputData['order_id'];
        $order   = $this->getOrder($orderId);
        if ($order !== false) {
            $this->order = $order;
            $this->orderUniqueId = $order->id.Carbon::now()->timestamp;
            $this->user  = $this->order->user;
            $this->getOrderCost();
            // ToDo: if sent open order_id user can't use wallet
            $this->donateCost = $this->order->getDonateCost();
            if ($this->canDeductFromWallet()) {
                $this->payByWallet();
            }
            $result            = $this->getNewTransaction();
            $this->statusCode  = $result['statusCode'];
            $this->message     = $result['message'];
            $this->transaction = $result['transaction'];
            $this->statusCode  = Response::HTTP_OK;
        }
        else {
            $this->statusCode = Response::HTTP_NOT_FOUND;
            $this->message    = 'سفارشی یافت نشد.';
        }
        
        return $this;
    }
    
    /**
     * @param  int  $orderId
     *
     * @return bool|Order
     */
    private function getOrder(int $orderId)
    {
        $order = Order::with(['transactions', 'coupon'])
            ->find($orderId);
        if (isset($order)) {
            return $order;
        }
        else {
            return false;
        }
    }

    protected function getOrderCost(): void
    {
        $this->cost = $this->order->totalCost() - $this->order->totalPaidCost();
    }
}
