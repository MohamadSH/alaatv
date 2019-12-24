<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Invoice extends AlaaJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $array = (array)$this->resource;
        return [
            'items'                 => $this->when(Arr::has($array, 'items') , Arr::get($array, 'items') ),
            'orderproductCount'     => $this->when(Arr::has($array, 'orderproductCount') , Arr::get($array, 'orderproductCount') ),
            'price'                 => $this->when(Arr::has($array, 'price') , new Price(Arr::get($array, 'price')) ),
        ];
    }
}
