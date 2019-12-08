<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class Gift extends JsonResource
{
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

        return [
            'redirect_url'     => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'name'             => $this->when(isset($this->name) , $this->name),
            'url'              => new Url($this),
            'photo'            => $this->when(isset($this->photo) , $this->photo),
        ];
    }
}
