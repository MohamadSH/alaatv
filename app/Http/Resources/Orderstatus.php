<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Orderstatus
 *
 * @mixin \App\Orderstatus
 * */
class Orderstatus extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Orderstatus)) {
            return [];
        }


        return [
            'name'        => $this->name ,
            'display_name' => $this->displayName ,
        ];
    }
}
