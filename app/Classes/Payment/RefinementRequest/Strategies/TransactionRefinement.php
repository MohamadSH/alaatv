<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:29 PM
 */

namespace App\Classes\Payment\RefinementRequest\Strategies;


use App\Transaction;
use Illuminate\Http\Response;
use App\Classes\Payment\RefinementRequest\Refinement;

class TransactionRefinement extends Refinement
{
    /**
     * @return Refinement
     */
    function loadData(): Refinement
    {
        if($this->statusCode!=Response::HTTP_OK) {
            return $this;
        }
        $this->getTransaction();
        if($this->transaction) {
            $this->getOrder();
            $this->order->cancelOpenOnlineTransactions();
            $this->user = $this->order->user;
            $this->cost = $this->transaction->cost;
            $this->statusCode = Response::HTTP_OK;
            $this->setDescription();
        } else {
            $this->statusCode = Response::HTTP_NOT_FOUND;
            $this->message = 'تراکنشی یافت نشد.';
        }
        return $this;
    }

    private function getTransaction(): void
    {
        $this->transaction = Transaction::find($this->inputData["transaction_id"]);
    }

    private function getOrder(): void
    {
        $this->order = $this->transaction->order->load(['transactions', 'coupon']);
    }

    private function setDescription(): void
    {
        if (isset($this->inputData["transaction_id"])) {
            $this->description .= "پرداخت قسط -";
        }
    }
}