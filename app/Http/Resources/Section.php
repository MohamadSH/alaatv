<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class \App\Section
 *
 * @mixin \App\Section
 * */
class Section extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Section)) {
            return [];
        }

        return [
            'name' => $this->name,
        ];
    }
}
