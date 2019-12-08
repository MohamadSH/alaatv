<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class \App\Coupontype
 *
 * @mixin \App\Coupontype
 * */
class Coupontype extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Coupontype)) {
            return [];
        }


        return [
            'name'          => $this->when(isset($this->name) , $this->name),
            'display_name'  => $this->when(isset($this->displayName) , $this->displayName)
        ];
    }
}
