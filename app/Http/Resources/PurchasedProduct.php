<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class PurchasedProduct extends JsonResource
{
    function __construct(\App\Product $model)
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
        if (!($this->resource instanceof \App\Product)) {
            return [];
        }

        $this->loadMissing('sets' , 'children' , 'producttype');

        return [
            'id'            => $this->id,
            'redirect_url'  => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'title'          => $this->when(isset($this->name) , $this->name),
            'type'          => $this->when(isset($this->producttype_id) , function (){ return new Producttype($this->producttype);}),
//            'type'          => $this->when(isset($this->producttype_id) , function (){ return New Producttype($this->producttype); }),
//            'isFree'        => $this->isFree,
            'url'           => new Url($this),
            'photo'         => $this->photo,
            'attributes'    => [
                'info' =>  $this->when(!empty($this->info_attributes) , $this->info_attributes),
                'extra' => $this->when(!empty($this->extra_attributes) , $this->extra_attributes),
            ],

        ];
    }
}
