<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Search extends AlaaJsonResourceWithPagination
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
        $array  = (array)$this->resource;
        $result = Arr::get($array, 'result');
        return [
            'result' => [
                'video'    => Content::collection($result->get('video')),
                'pamphlet' => $result->get('pamphlet'),
                'article'  => $result->get('article'),
                'set'      => $result->get('set'),
                'product'  => $result->get('product'),
            ],
            'tags'   => Arr::get($array, 'tags'),
        ];
    }
}
