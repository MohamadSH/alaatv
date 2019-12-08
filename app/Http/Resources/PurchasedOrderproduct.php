<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Orderproduct
 *
 * @mixin \App\Orderproduct
 * */
class PurchasedOrderproduct extends JsonResource
{
    function __construct(\App\Orderproduct $model)
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
        if (!($this->resource instanceof \App\Orderproduct)) {
            return [];
        }

        $this->loadMissing('product' , 'product.grand' , 'product.grand' , 'orderproducttype' , 'attributevalues');

        return [
            'id'                => $this->id,
//            'quantity'          => $this->quantity,
            'orderproducttype'  => $this->when(isset($this->orderproducttype_id) , function (){ return new Orderproducttype($this->orderproducttype);}),
            'product'           => $this->when(isset($this->product_id) , function (){return new PurchasedProduct($this->product);}),
            'grandProduct'      => $this->when(isset($this->product_id) && isset($this->product->grand_id) , function () {return new PurchasedProduct($this->product->grand);}),
            'price'             => $this->price,
//            'bons'              => AttachedUserbon::collection($this->bons),
            'attributevalues'   => $this->when($this->attributevalues->isNotEmpty() , function (){return Attributevalue::collection($this->attributevalues);}), //Not a relationship
            'photo'             => $this->photo,
        ];
    }
}
