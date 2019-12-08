<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Content
 *
 * @mixin \App\Content
 * */
class Content extends JsonResource
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
            'name'           => $this->when(isset($this->name) ,$this->name),
            'description'    => $this->when(isset($this->description) , $this->description),
            'tags'           => $this->when(isset($this->tags) , function () { return new Tag($this->tags); } ),
            'context'        => $this->when( ($this->contenttype_id == config('constants.CONTENT_TYPE_ARTICLE')) , $this->context),
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
            'page_view'      => $this->when(isset($this->page_view) , $this->page_view),
            'created_at'     => $this->when(isset($this->created_at) ,  function (){ return $this->created_at;}),
            'updated_at'     => $this->when(isset($this->updated_at) , function () { return $this->updated_at;}),
            'url'            => new Url($this),
            'previous_url'   => $this->when(!is_null($this->previous_content) , function (){return new Url($this->previous_content);}),
            'next_url'       => $this->when(!is_null($this->next_content) , function (){ return new Url($this->next_content); }),
            'author'                => $this->when(isset($this->author_id) , function (){ return new Author($this->user);}),
            'set'                   => $this->when(isset($this->contentset_id) , function (){ return  new SetInContent($this->set);}),
            'related_product'       => $this->when($this->related_products->isNotEmpty() , $this->related_products) ,
            'recommended_products'  => $this->when($this->recommended_products->isNotEmpty() , $this->recommended_products)
        ];
    }
}
