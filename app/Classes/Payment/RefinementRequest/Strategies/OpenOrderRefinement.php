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
use Illuminate\Http\Response;

class OpenOrderRefinement extends RefinementClass
{
    private $openOrder;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->user = $this->request->user();
        $this->openOrder = $this->getOpenOrder();
        if ($this->openOrder && $this->openOrder->orderproducts->isNotEmpty()) {
            $this->order = $this->openOrder;
            list($this->order, $this->cost) = $this->getOrderCost($this->order);
            $this->order->cancelOpenOnlineTransactions();
            $this->donateCost = $this->order->getDonateCost();
            $result = $this->getTransaction();
            $this->statusCode = $result['statusCode'];
            $this->message = $result['message'];
            $this->transaction = $result['transaction'];
        } else {
            $this->message = 'سبد خرید شما خالیست';
            $this->statusCode = Response::HTTP_BAD_REQUEST;
        }
    }

    /**
     * @return Order|null
     */
    private function getOpenOrder(): ?Order
    {
        $openOrder = $this->user->openOrders()->with(['transactions', 'coupon'])->first();
        return $openOrder;
    }
}