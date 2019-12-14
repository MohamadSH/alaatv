<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class Invoice extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = (array) $this->resource;
        return [
            'items'                 => $this->when(Arr::has($array, 'items') , Arr::get($array, 'items') ),
            'orderproductCount'     => $this->when(Arr::has($array, 'orderproductCount') , Arr::get($array, 'orderproductCount') ),
            'price'                 => $this->when(Arr::has($array, 'price') , new Price(Arr::get($array, 'price')) ),
        ];
    }
}
