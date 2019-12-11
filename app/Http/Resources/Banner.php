<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class Banner extends JsonResource
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
            'photo' =>  $this->when(Arr::has($array , 'photo') , Arr::get($array , 'photo'))
        ];
    }
}
