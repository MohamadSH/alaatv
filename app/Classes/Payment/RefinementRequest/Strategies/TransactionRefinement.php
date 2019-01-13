<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:29 PM
 */

namespace App\Classes\Payment\RefinementRequest\Strategies;


use App\Order;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Classes\Payment\RefinementRequest\Refinement;

class TransactionRefinement extends Refinement
{
    public function __construct()
    {
        parent::__construct();
        $this->transaction = $this->getNewTransaction();
        if($this->transaction) {
            $this->order = $this->getOrder();
            $this->order->cancelOpenOnlineTransactions();
            $this->user = $this->order->user;
            $this->cost = $this->transaction->cost;
            $this->statusCode = Response::HTTP_OK;
            $this->setDescription($this->request);
        } else {
            $this->statusCode = Response::HTTP_NOT_FOUND;
            $this->message = 'تراکنشی یافت نشد.';
        }
    }

    /**
     * @return Transaction
     */
    protected function getTransaction(): Transaction
    {
        $transaction = Transaction::find($this->request->get("transaction_id"));
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

    /**
     * @param Request $request
     */
    private function setDescription(Request $request): void
    {
        if ($request->has("transaction_id")) {
            $this->description .= "پرداخت قسط -";
        }
    }
}