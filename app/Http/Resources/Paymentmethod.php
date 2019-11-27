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
        return [
            'id'            => $this->id,
            'name'          => $this->name ,
            'displayName'   => $this->displayName,
        ];
    }
}
