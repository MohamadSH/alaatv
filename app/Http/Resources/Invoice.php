<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Invoice extends AlaaJsonResourceWithPagination
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
        $items = Arr::get($array, 'items');
        return [
            'items' => $this->when(Arr::has($array, 'items'), count($items) > 0 ? InvoiceItem::collection($items) : null),
            'count' => $this->when(Arr::has($array, 'orderproductCount'), Arr::has($array, 'orderproductCount') ? Arr::get($array, 'orderproductCount') : 0),
            'price' => $this->when(Arr::has($array, 'price'), Arr::has($array, 'price') ? new Price(Arr::get($array, 'price')) : null),
        ];
    }
}
