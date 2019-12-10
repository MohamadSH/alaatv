<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Userstatus
 *
 * @mixin \App\Userstatus
 * */
class Userstatus extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Userstatus)) {
            return [];
        }

        return [
            'name'          => $this->when(isset($this->name) , $this->name),
        ];
    }
}
