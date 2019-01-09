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
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionRefinement extends RefinementClass
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->transaction = $this->getTransaction();
        $this->order = $this->getOrder();
        $this->order->cancelOpenOnlineTransactions();
        $this->user = $this->order->user;
        $this->cost = $this->transaction->cost;
        $this->statusCode = Response::HTTP_OK;
    }

    /**
     * @return Transaction
     */
    protected function getTransaction(): Transaction
    {
        $transaction = Transaction::FindOrFail($this->request->get("transaction_id"));
        return $transaction;
    }

    /**
     * @return Order
     */
    private function getOrder(): Order
    {
        $order = $this->transaction->order->load(['transactions', 'coupon']);
        return $order;
    }
}