<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Set
 *
 * @mixin \App\Contentset
 * */
class Set extends JsonResource
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
        if (!($this->resource instanceof \App\Contentset)) {
            return [];
        }

        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'shortName'      => $this->shortName,
            'description'    => $this->description,
            'photo'          => $this->photo,
            'tags'           => $this->tags,
            'contents_count' => $this->activeContents->count(),
            'url'            => [
                'last_content' => [
                    'web' => $this->url,
                    'api' => null,
                ],
                /*                    'set'          => [
                                        'web' => null,
                                        'api' => $this->apiUrl,
                                    ],*/
                'list'         => [
                    'web' => $this->contentUrl,
                    'api' => null,
                ],
            ],
            'author'         => new User($this->author),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
