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
        return [
            'attribute_id' => $this->attribute_id ,
            'name'         => $this->name,
            'description'  => $this->description,
            'isDefault'    => $this->isDefault
        ];
    }
}
