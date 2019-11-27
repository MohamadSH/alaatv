<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Orderproducttype
 *
 * @mixin \App\Orderproducttype
 * */
class Orderproducttype extends JsonResource
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
            'id'            => $this->id ,
            'name'          => $this->name ,
            'displayName'   => $this->displayName ,
        ];
    }
}
