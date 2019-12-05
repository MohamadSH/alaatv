<?php

namespace App\Http\Resources;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Transaction
 *
 * @mixin Transaction
 * */
class SuccessfulTransaction extends JsonResource
{
    function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Orderstatus)) {
            return [];
        }
        $this->loadMissing('paymentmethod' , 'transactionstatus' , 'transactiongateway');


        return [
            'wallet_id'         => $this->when(isset($this->wallet_id) , function (){ return $this->wallet_id ;}),
            'order_id'         => $this->when(isset($this->order_id) , function (){ return $this->order_id ;}),
            'cost'              => $this->cost ,
            'transactionID'     => $this->transactionID ,
            'trace_number'       => $this->traceNumber ,
            'refrence_number'    => $this->referenceNumber,
            'paycheck_number'    => $this->paycheckNumber,
            'paymentmethod'     => $this->when(isset($this->paymentmethod_id) , function (){ return new Paymentmethod($this->paymentmethod);}) ,
            'transactiongateway'=> $this->when(isset($this->transactiongateway_id) , function (){ return new Transactiongateway($this->transactiongateway);}),
            'transactionstatus' => $this->when(isset($this->transactionstatus_id) , function (){ return new TransactionStatus($this->transactionstatus);}),
            'created_at'        => $this->created_at,
            'completed_at'      => $this->completed_at,
            'deadline_at'      => $this->deadline_at,
        ];
    }
}
