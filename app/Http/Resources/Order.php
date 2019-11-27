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

        return [
            'discount'               => $this->discount ,
            'customerDescription'    => $this->customerDescription ,
            'customerExtraInfo'      => $this->customerExtraInfo ,
            'created_at'             => $this->created_at,
            'completed_at'           => $this->completed_at,
            'price'                  => $this->price,
            'orderstatus'            => new Orderstatus($this->orderstatus),
            'paymentstatus'          => new Paymentstatus($this->paymentstatus),
//            'orderproducts'          => Orderproduct::collection($this->whenLoaded('orderproducts')),
            'orderproducts'          => Orderproduct::collection($this->orderproducts),
            'couponInfo'             => $this->coupon_info,
            'paidPrice'              => $this->paid_price,
            'refundPrice'            => $this->refund_price,
            'successfulTransactions' => Transaction::collection($this->successful_transactions),
            'pendingTransactions'    => Transaction::collection($this->pending_transactions),
            'unpaidTransaction'      => Transaction::collection($this->unpaid_transactions),
            'postingInfo'            => Orderpostinginfo::collection($this->orderpostinginfos),
            'debt'                   => $this->debt,
            'usedBonSum'             => $this->used_bon_sum,
            'addedBonSum'            => $this->added_bon_sum,
            'user'                   => new OrderOwner($this->user),
            'managerComment'         => $this->manager_comment,
        ];
    }
}
