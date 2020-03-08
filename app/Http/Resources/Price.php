<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Price extends AlaaJsonResourceWithPagination
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
            'base'     => $this->when(Arr::has($array, 'base'), Arr::get($array, 'base')),
            'base2'     => $this->when(Arr::has($array, 'base'), Arr::get($array, 'base')),
            'discount' => $this->when(Arr::has($array, 'discount'), Arr::get($array, 'discount')),
            'final'    => $this->when(Arr::has($array, 'final'), Arr::get($array, 'final')),
        ];
}
}
