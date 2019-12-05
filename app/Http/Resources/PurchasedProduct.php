<?php

namespace App\Http\Resources;

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
     * @param  \Illuminate\Http\Request  $request
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
            'redirect_url'  => null,
            'name'          => $this->name,
            'type'          => $this->when(isset($this->producttype_id) , function (){ return new Producttype($this->producttype);}),
//            'type'          => $this->when(isset($this->producttype_id) , function (){ return New Producttype($this->producttype); }),
//            'isFree'        => $this->isFree,
            'price'         => $this->price,
            'tags'          => $this->tags,
            'url'           => [
                'web' => $this->url,
                'api' => $this->api_url,
            ],
            'photo'         => $this->photo,
            'attributes'    => [
                'info' =>  $this->when(!empty($this->info_attributes) , $this->info_attributes),
            ],

        ];
    }
}
