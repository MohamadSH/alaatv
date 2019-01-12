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
use Illuminate\Http\Request;

class OrderIdRefinement extends Refinement
{
    private $orderId;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->orderId = $this->request->get('order_id');
        $this->order = $this->getOrder();
        if($this->order) {
            $this->user = $this->order->user;
            list($this->order, $this->cost) = $this->getOrderCost($this->order);
            $this->order->cancelOpenOnlineTransactions();
            $result = $this->getTransaction();
            $this->statusCode = $result['statusCode'];
            $this->message = $result['message'];
            $this->transaction = $result['transaction'];
        } else {
            $this->statusCode = Response::HTTP_NOT_FOUND;
            $this->message = 'سفارشی یافت نشد.';
        }
    }

    /**
     * @return Order
     */
    private function getOrder(): Order
    {
        $order = Order::with(['transactions', 'coupon'])->find($this->orderId);
        return $order;
    }
}