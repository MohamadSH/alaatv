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
        $transaction = $this->getTransaction();
        if($transaction !== false) {
            $this->transaction = $transaction;
            $order = $this->getOrder();
            if($order !== false)
            {
                $this->order = $order;
                $this->user = $this->order->user;
                $this->cost = $this->transaction->cost;
                if($this->canDeductFromWallet()) {
                    $this->payByWallet();
                }
                $this->statusCode = Response::HTTP_OK;
                $this->description .= $this->getDescription();
            }else{
                $this->statusCode = Response::HTTP_NOT_FOUND;
                $this->message = 'سفارش یافت نشد.';
            }
        } else {
            $this->statusCode = Response::HTTP_NOT_FOUND;
            $this->message = 'تراکنشی یافت نشد.';
        }
        return $this;
    }

    private function getTransaction(): Transaction
    {
        return Transaction::find($this->inputData["transaction_id"]);
    }

    /**
     * @return Order|bool
     */
    private function getOrder()
    {
        $transaction = $this->transaction;
        if(isset($transaction))
        {
            $order =  $transaction->order->load(['transactions', 'coupon']);
            if(isset($order))
                return $order;
            else
                return false;
        }
        else
        {
            return  false;
        }
    }

    /**
     * @return string
     */
    private function getDescription(): string
    {
        $description = "";
        if (isset($this->inputData["transaction_id"]))
            $description = "پرداخت قسط -";

        return $description;
    }
}