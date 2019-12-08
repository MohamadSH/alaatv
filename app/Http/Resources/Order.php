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
            'discount'                 => $this->discount ,
            'customer_description'     => $this->when(isset($this->customerDescription ) , $this->customerDescription ),
//            'customer_extra_info'      => $this->customerExtraInfo ,
            'price'                    => $this->price,
            'paid_price'               => $this->paid_price,
            'refund_price'             => $this->refund_price,
            'debt'                     => $this->debt,
            'orderstatus'              => $this->when(isset($this->orderstatus_id) , function (){ return new Orderstatus($this->orderstatus);}),
            'paymentstatus'            => $this->when(isset($this->paymentstatus_id) , function (){ return new Paymentstatus($this->paymentstatus);}),
//            'orderproducts'           => Orderproduct::collection($this->whenLoaded('orderproducts')),
            'orderproducts'            => $this->when(isset($this->orderproducts) , function () { return PurchasedOrderproduct::collection($this->whenLoaded('orderproducts'));}),
            'coupon_info'              => $this->when(!is_null($this->coupon_info) , $this->coupon_info),
            'successful_transactions'  => $this->when($this->successful_transactions->isNotEmpty() , function () { return SuccessfulTransaction::collection($this->successful_transactions) ; } ) , // It is not a relationship
            'pending_transactions'     => $this->when($this->pending_transactions->isNotEmpty() , function () { return PendingTransaction::collection($this->pending_transactions) ; } ) , // It is not a relationship
            'unpaid_transaction'       => $this->when($this->unpaid_transactions->isNotEmpty() , function () { return UnpaidTransaction::collection($this->unpaid_transactions) ; } ) , // It is not a relationship
            'posting_info'             => $this->when( $this->orderpostinginfos->isNotEmpty() , function (){ return Orderpostinginfo::collection($this->whenLoaded('orderpostinginfos')); }),
//            'usedBonSum'             => $this->used_bon_sum,
//            'addedBonSum'            => $this->added_bon_sum,
            'user'                     => $this->when(isset($this->user_id) , function (){ return new OrderOwner($this->user) ;}),
            'created_at'               => $this->when(isset($this->created_at) , function () { return $this->created_at;}),
            'completed_at'             => $this->when(isset($this->completed_at) , $this->completed_at),

        ];
    }
}
