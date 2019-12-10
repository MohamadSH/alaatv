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
            'title'         => $this->when(Arr::has($array, 'title')  , Arr::get($array, 'title') ),
            'description'   => $this->when(Arr::has($array, 'description') , Arr::get($array, 'description')) ,
            'url'           => $this->when(Arr::has($array, 'url') , Arr::get($array, 'url')) ,
        ];
    }
}
