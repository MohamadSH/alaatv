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
        return [
            'id'            => $this->id,
            'redirect_url'  => null,
            'name'          => $this->name,
            'type'          => $this->producttype,
            'description'   => [
                'short' => $this->shortDescription,
            ],
            'isFree'        => $this->isFree,
            'price'         => $this->price,
            'tags'          => $this->tags,
            'url'           => [
                'web' => $this->url,
                'api' => $this->api_url,
            ],
            'photo'         => $this->photo,
            'attributes'    => $this->attributes,
            'children'      => $this->children->isNotEmpty() ? Product::collection($this->children) : null,
        ];
    }
}
