<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class ProductInBlock extends JsonResource
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

        if (isset($this->redirectUrl)) {
            return [
                'id'           => $this->id,
                'redirect_url' => $this->redirectUrl,
            ];
        }

        return [
            'id'               => $this->id,
            'redirect_url'     => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'title'             => $this->when(isset($this->name) , $this->name),
            'url'              => new Url($this),
            'photo'            => $this->when(isset($this->photo) , $this->photo),
        ];
    }
}
