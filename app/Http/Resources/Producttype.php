<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Producttype
 *
 * @mixin \App\Producttype
 * */
class Producttype extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Producttype)) {
            return [];
        }

        return [
            'type'        => $this->id ,
        ];
    }
}
