<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Block
 *
 * @mixin \App\Block
 * */
class BlockV2 extends JsonResource
{
    function __construct(\App\Block $model)
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
        if (!($this->resource instanceof \App\Block)) {
            return [

            ];
        }

        $contents = $this->notRedirectedContents;
        $sets     = $this->notRedirectedSets;
        $products = $this->products;
        $banners  = $this->banners;
        return [
            'id'         => $this->id,
            'title'      => $this->when(isset($this->title) ,$this->title),
            'offer'      => $this->when(isset($this->offer) , $this->offer),
            'url'        => new UrlForBlock($this),
            'order'      => $this->order,
            'contents'   => $this->when(isset($contents) && $contents->isNotEmpty() , function () use ($contents) { return ContentInBlock::collection($contents) ;}),
            'sets'       => $this->when(isset($sets) && $sets->isNotEmpty() , function () use ($sets) { return SetInBlock::collection($sets) ;}),
            'products'   => $this->when(isset($products) && $products->isNotEmpty() , function () use ($products){ return ProductInBlock::collection($products);}),
            'banners'    => $this->when(isset($banners) && $banners->isNotEmpty() , function () use ($banners){ return Slideshow::collection($banners);}),
            'updated_at' => $this->when(isset($this->updated_at) , function (){ return $this->updated_at; }),
        ];
    }
}
