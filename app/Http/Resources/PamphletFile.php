<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\JsonResource;

class PamphletFile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $array = (array) $this->resource;
        return [
            'link'    => Arr::get($array, 'link'),
            'ext'     => Arr::get($array, 'ext'),
            'size'    => Arr::get($array, 'size'),
            'caption' => Arr::get($array, 'caption'),
        ];
    }
}
