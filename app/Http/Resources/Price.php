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

        if (Arr::has($array, 'payableByWallet')) {
            //ToDo: after fixing when method in AlaaJsonResourceWithoutPagination class we can remove this condition
            return [
                'base'          => $this->when(Arr::has($array, 'base'), Arr::get($array, 'base')),
                'discount'      => $this->when(Arr::has($array, 'discount'), Arr::get($array, 'discount')),
                'final'         => $this->when(Arr::has($array, 'final'), Arr::get($array, 'final')),
                'pay_by_wallet' => $this->when(Arr::has($array, 'payableByWallet'), Arr::get($array, 'payableByWallet')),
            ];
        } else {
            return [
                'base'     => $this->when(Arr::has($array, 'base'), Arr::get($array, 'base')),
                'discount' => $this->when(Arr::has($array, 'discount'), Arr::get($array, 'discount')),
                'final'    => $this->when(Arr::has($array, 'final'), Arr::get($array, 'final')),
            ];
        }
    }
}
