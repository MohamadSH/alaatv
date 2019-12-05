<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Set
 *
 * @mixin \App\Contentset
 * */
class SetInContent extends JsonResource
{
    function __construct(\App\Contentset $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Contentset)) {
            return [];
        }

        return [
            'redirect_url'           => $this->redirectUrl,
            'name'                  => $this->name,
            'short_name'             => $this->shortName,
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
        ];
    }
}
