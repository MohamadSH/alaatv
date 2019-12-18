<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class \App\Slideshow
 *
 * @mixin \App\Slideshow
 * */
class Slideshow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'     => $this->when(isset($this->title) , $this->title),
            'body'      => $this->when(isset($this->shortDescription) , $this->shortDescription),
            'photo'     => $this->when(isset($this->photo) , $this->photo),
            'link'      => $this->when(isset($this->link) , $this->link),
            'order'     => $this->when(isset($this->order) , $this->order),
        ];
    }
}
