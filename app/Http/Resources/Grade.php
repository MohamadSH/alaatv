<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Grade
 *
 * @mixin \App\Grade
 * */
class Grade extends JsonResource
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
            'name'           => $this->when(isset($this->name) , $this->name),
            'display_name'   => $this->when(isset($this->displayName) , $this->displayName),
        ];
    }
}
