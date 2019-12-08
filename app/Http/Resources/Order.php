<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Order
 *
 * @mixin \App\Order
 * */
class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Order)) {
            return [];
        }

        $this->loadMissing('orderstatus' , 'paymentstatus' , 'orderproducts'  , 'transactions' , 'orderpostinginfos' , 'user');

        return [
            'discount'                => $this->discount ,
            'customer_description'    => $this->customerDescription ,
            'customer_extra_info'     => $this->customerExtraInfo ,
            'price'                   => $this->price,
            'orderstatus'             => $this->when(isset($this->orderstatus_id) , function (){ return new Orderstatus($this->orderstatus);}),
            'paymentstatus'           => $this->when(isset($this->paymentstatus_id) , function (){ return new Paymentstatus($this->paymentstatus);}),
//            'orderproducts'           => Orderproduct::collection($this->whenLoaded('orderproducts')),
            'orderproducts'            => PurchasedOrderproduct::collection($this->whenLoaded('orderproducts')),
            'coupon_info'              => $this->coupon_info,
            'paid_price'               => $this->paid_price,
            'refund_price'             => $this->refund_price,
            'successful_transactions'  => $this->when($this->successful_transactions->isNotEmpty() , function () { return SuccessfulTransaction::collection($this->successful_transactions) ; } ) , // It is not a relationship
            'pending_transactions'     => $this->when($this->pending_transactions->isNotEmpty() , function () { return PendingTransaction::collection($this->pending_transactions) ; } ) , // It is not a relationship
            'unpaid_transaction'       => $this->when($this->unpaid_transactions->isNotEmpty() , function () { return UnpaidTransaction::collection($this->unpaid_transactions) ; } ) , // It is not a relationship
            'posting_info'             => Orderpostinginfo::collection($this->whenLoaded('orderpostinginfos')),
            'debt'                     => $this->debt,
//            'usedBonSum'             => $this->used_bon_sum,
//            'addedBonSum'            => $this->added_bon_sum,
            'user'                     => $this->when(isset($this->user_id) , function (){ return new OrderOwner($this->user) ;}),
            'manager_comment'          => $this->manager_comment,
            'created_at'              => $this->created_at,
            'completed_at'            => $this->completed_at,

        ];
    }
}
