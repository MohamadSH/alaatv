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
class PendingTransaction extends JsonResource
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

        $this->loadMissing('paymentmethod' , 'transactiongateway');

        return [
            'order id'          => $this->when(isset($this->order_id) , function (){ return $this->order_id ;}),
            'cost'              => $this->cost ,
            'trace_number'       => $this->traceNumber ,
            'refrence_number'    => $this->referenceNumber,
            'paycheck_number'    => $this->paycheckNumber,
            'paymentmethod'     => $this->when(isset($this->paymentmethod_id) , function (){ return new Paymentmethod($this->paymentmethod) ;}) ,
            'transactionstatus' => $this->when(isset($this->transactionstatus_id) , function (){ return new TransactionStatus($this->transactionstatus) ;}),
            'created at'        => $this->created_at,
            'completed at'      => $this->completed_at,
        ];
    }}
