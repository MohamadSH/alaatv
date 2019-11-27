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
        return [
            'name'        => $this->name ,
            'displayName' => $this->displayName ,
            'description' => $this->description
        ];
    }
}
