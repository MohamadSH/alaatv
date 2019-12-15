<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class \App\Contenttype
 *
 * @mixin \App\Contenttype
 * */
class Contenttype extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Contenttype)) {
            return [];
        }

        return [
            'type'          => $this->id,
        ];
    }
}
