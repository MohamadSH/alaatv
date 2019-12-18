<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Set
 *
 * @mixin \App\Contentset
 * */
class SetInBlock extends JsonResource
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
            'id'                        => $this->id,
            'redirect_url'              => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'title'                      => $this->when(isset($this->name) , $this->name),
            'short_title'                => $this->when(isset($this->shortName) , $this->shortName),
            'photo'                     => $this->when(isset($this->photo) , $this->photo),
            'url'                       => new Url($this),
            'active_contents_count'     => $this->activeContents->count() ,
            'author'                    => $this->when(isset($this->author) , $this->author),
        ];
    }
}
