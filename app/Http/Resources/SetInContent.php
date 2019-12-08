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
            'redirect_url'              => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'name'                      => $this->when(isset($this->name) , $this->name),
            'short_name'                => $this->when(isset($this->shortName) , $this->shortName),
            'photo'                     => $this->when(isset($this->photo) , $this->photo),
            'contents_count'            => $this->contents_count,
            'active_contents_count'     => $this->activeContents->count() ,
            'url'                       => new Url($this),
            'list_contents'             => [
                'web' => $this->content_url,
            ],
        ];
    }
}
