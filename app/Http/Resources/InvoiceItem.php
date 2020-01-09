<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;

class InvoiceItem extends AlaaJsonResourceWithoutPagination
{
    public function toArray($request)
    {
        $array = (array)$this->resource;
//        return $array;
        $grand = Arr::get($array, 'grand');
        return [
            'grand'         => $grand != null ? [
                'id'    => $grand->id,
                'title' => $grand->name,
                'photo' => $grand->photo,
            ] : null,
            'order_product' => OrderProduct::collection(Arr::get($array, 'orderproducts')),
        ];
    }
}
