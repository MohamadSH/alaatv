<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoFile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
            'res'     => Arr::get($array, 'res'),
        ];
    }
}
