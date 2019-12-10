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
        if (!($this->resource instanceof \App\Orderproducttype)) {
            return [];
        }


        return [
            'name'           => $this->when(isset($this->name) , $this->name) ,
            'display_name'   => $this->when(isset($this->displayName) , $this->displayName) ,
        ];
    }
}
