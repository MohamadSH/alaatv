<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class OrderProduct extends AlaaJsonResourceWithoutPagination
{
    function __construct(\App\Orderproduct $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Orderproduct)) {
            return [];
        }
        return [
            'id'              => $this->id,
            'order_id'        => $this->when(isset($this->order_id), $this->order_id),
            'quantity'        => $this->when(isset($this->quantity), $this->quantity),
            'type'            => $this->orderproducttype_id,
            'price'           => new Price($this->resource),
            'attributevalues' => null,
            'product'         => new ProductInOrderproduct($this->product),
        ];
    }
}
