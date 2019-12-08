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
class UnpaidTransaction extends JsonResource
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
        $this->loadMissing('paymentmethod');


        return [
            'order_id'          => $this->when(isset($this->order_id) , function (){ return $this->order_id ;}),
            'cost'              => $this->cost ,
            'transactionstatus' => $this->when(isset($this->transactionstatus_id) , function (){ return new TransactionStatus($this->transactionstatus);}),
            'created_at'        => $this->created_at,
            'deadline_at'      => $this->deadline_at,
        ];
    }}
