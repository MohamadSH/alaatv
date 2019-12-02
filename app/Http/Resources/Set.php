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
            'id'                    => $this->id,
            'redirectUrl'           => $this->redirectUrl,
            'name'                  => $this->name,
            'shortaName'             => $this->shortName,
            'description'           => $this->description,
            'photo'                 => $this->photo,
            'tags'                  => $this->tags,
            'contents_count'        => $this->contents_count,
            'active_contents_count' => $this->activeContents->count() ,
            'url'            => [
                'set'          => [
                    'web' => null,
                    'api' => $this->api_url,
                       ],
                'list'         => [
                    'web' => $this->content_url,
                    'api' => null,
                       ],
            ],
            'author'         => new Author($this->author),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
