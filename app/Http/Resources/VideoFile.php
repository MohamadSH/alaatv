<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class VideoFile extends AlaaJsonResourceWithPagination
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $array = (array)$this->resource;
        return [
            'link'    => $this->when(Arr::has($array, 'link'), Arr::get($array, 'link')),
            'ext'     => $this->when(Arr::has($array, 'ext'), Arr::get($array, 'ext')),
            'size'    => $this->when(Arr::has($array, 'size'), Arr::get($array, 'size')),
            'caption' => $this->when(Arr::has($array, 'caption'), Arr::get($array, 'caption')),
            'res'     => $this->when(Arr::has($array, 'res'), Arr::get($array, 'res')),
        ];
    }
}
