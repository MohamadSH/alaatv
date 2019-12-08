<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Attributevalue
 *
 * @mixin \App\Attributevalue
 * */
class Attributevalue extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Attributevalue)) {
            return [];
        }

        return [
            'attribute_id' => $this->attribute_id ,
            'name'         => $this->when(isset($this->name) , $this->name),
        ];
    }
}
