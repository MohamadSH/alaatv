<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class Content
 *
 * @mixin \App\Content
 * */
class ContentInBlock extends AlaaJsonResource
{
    function __construct(\App\Content $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Content)) {
            return [];
        }

        $this->loadMissing('contenttype' , 'section' , 'user' , 'set');

        return [
            'id'             => $this->id,
            'redirect_url'   => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'contenttype'    => $this->when(isset($this->contenttype_id) , function () {return New Contenttype($this->contenttype);}) ,
            'title'           => $this->when(isset($this->name) , $this->name),
            'duration'       => $this->when(isset($this->duration) , $this->duration),
            'photo'          => $this->when(isset($this->thumbnail) , $this->thumbnail),
            'isFree'         => $this->isFree,
            'url'            => new Url($this),
        ];
    }
}
