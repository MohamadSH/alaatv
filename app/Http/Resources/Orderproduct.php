<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Orderproduct
 *
 * @mixin \App\Orderproduct
 * */
class Orderproduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'quantity'          => $this->quantity,
            'orderproducttype'  => new Orderproducttype($this->orderproducttype),
            'product'           => new PurchasedProduct($this->product),
            'grandId'           => $this->grand_id ,
            'price'             => $this->price,
            'bons'              => Userbon::collection($this->bons),
            'attributevalues'   => Attributevalue::collection($this->attributevalues),
            'photo'             => $this->photo,
            'grandProduct'      => new PurchasedProduct($this->product->grand),
        ];
    }
}
