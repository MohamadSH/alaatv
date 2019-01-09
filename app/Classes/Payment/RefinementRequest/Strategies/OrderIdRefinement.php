<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:29 PM
 */

namespace App\Classes\Payment\RefinementRequest\Strategies;


use App\Classes\Payment\RefinementRequest\RefinementClass;
use App\Order;
use Illuminate\Http\Request;

class OrderIdRefinement extends RefinementClass
{
    private $orderId;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->orderId = $this->request->get('order_id');
        $this->order = $this->getOrder();
        $this->user = $this->order->user;
        list($this->order, $this->cost) = $this->getOrderCost($this->order);
        $this->order->cancelOpenOnlineTransactions();
        $result = $this->getTransaction();
        $this->statusCode = $result['statusCode'];
        $this->message = $result['message'];
        $this->transaction = $result['transaction'];
    }

    /**
     * @return Order
     */
    private function getOrder(): Order
    {
        $order = Order::with(['transactions', 'coupon'])->findOrFail($this->orderId);
        return $order;
    }
}