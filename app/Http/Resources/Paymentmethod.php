<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Paymentmethod
 *
 * @mixin \App\Paymentmethod
 * */
class Paymentmethod extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Paymentmethod)) {
            return [];
        }


        return [
            'name'          => $this->name ,
            'display_name'   => $this->displayName,
        ];
    }
}
