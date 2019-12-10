<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Content
 *
 * @mixin \App\Content
 * */
class ContentInSet extends JsonResource
{
    function __construct(\App\Content $model)
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
        if (!($this->resource instanceof \App\Content)) {
            return [];
        }

        $file                   = $this->file;
        $videoFileCollection    = $file->get('video');
        $pamphletFileCollection = $file->get('pamphlet');

        $this->loadMissing('contenttype' , 'section' , 'user' , 'set');

        return [
            'id'             => $this->id,
            'redirect_url'   => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'contenttype'    => $this->when(isset($this->contenttype_id) , function () {return New Contenttype($this->contenttype);}) ,
            'section'        => $this->when(isset($this->section_id) , function (){ return New Section($this->section);}),
            'name'           => $this->when(isset($this->name) , $this->name),
            'file'           => [
                'video'    => $this->when(isset($videoFileCollection) , function () use ($videoFileCollection) { return VideoFile::collection($videoFileCollection); } ),
                'pamphlet' => $this->when(isset($pamphletFileCollection) , function () use ($pamphletFileCollection) { return PamphletFile::collection($pamphletFileCollection); } ),
            ],
            'duration'       => $this->when(isset($this->duration) , $this->duration),
            //ToDo : It was before
//            'photo'      => $this->when(isset($this->thumbnail) , $this->thumbnail),
            'thumbnail'      => $this->when(isset($this->thumbnail) , $this->thumbnail),
            'isFree'         => $this->isFree,
            'order'          => $this->order,
            'url'            => new Url($this),
        ];
    }
}
