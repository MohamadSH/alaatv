<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Transaction
 *
 * @mixin \App\Transaction
 * */
class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'cost'              => $this->cost ,
            'transactionID'     => $this->transactionID ,
            'traceNumber'       => $this->traceNumber ,
            'refrenceNumber'    => $this->referenceNumber,
            'paycheckNumber'    => $this->paycheckNumber,
            'managerComment'    => $this->managerComment,
            'description'       => $this->description,
            'completed_at'      => $this->completed_at,
            'paymentmethod'     => new Paymentmethod($this->paymentmethod) ,
            'transactiongateway'=> new Transactiongateway($this->transactiongateway),
        ];
    }
}
