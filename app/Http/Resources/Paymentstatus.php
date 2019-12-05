<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Paymentstatus
 *
 * @mixin \App\Paymentstatus
 * */
class Paymentstatus extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Paymentstatus)) {
            return [];
        }

        return [
            'name'        => $this->name ,
            'display_name' => $this->displayName ,
        ];
    }
}
