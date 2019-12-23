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
            'redirect_url'          => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'title'                  => $this->when(isset($this->name) , $this->name),
            'short_title'            => $this->when(isset($this->shortName) , $this->shortName),
            'photo'                 => $this->when(isset($this->photo) , $this->photo),
            'tags'                  => $this->when(isset($this->tags) , function (){return new Tag($this->tags);}),
            'contents_count'        => $this->contents_count,
            'active_contents_count' => $this->activeContents->count() ,
            'url' => new UrlForSet($this) ,
            'author'         => $this->when(isset($this->author) , $this->author),
            'created_at'     => $this->when(isset($this->created_at) , function (){return $this->created_at;}),
            'updated_at'     => $this->when(isset($this->updated_at) , function (){return $this->updated_at;}),
        ];
    }
}
