<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ProductSamplePhoto extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = (array) $this->resource;
        return [
            'title'         => Arr::get($array, 'title') ,
            'description'   => Arr::get($array, 'description') ,
            'url'           => Arr::get($array, 'url') ,
        ];
    }
}
