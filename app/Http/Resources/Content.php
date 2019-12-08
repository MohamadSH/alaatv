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
            'redirect_url'   => $this->redirectUrl,
            'contenttype'    => $this->when(isset($this->contenttype_id) , function () {return New Contenttype($this->contenttype);}) ,
            'section'        => $this->when(isset($this->section_id) , function (){ return New Section($this->section);}),
            'name'           => $this->name,
            'description'    => $this->description,
            'tags'           => $this->tags,
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
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'url'            => [
                'previous'=> [
                    'web' => $this->previous_url,
                    'api' => $this->previous_api_url,
                ],
                'current' => [
                    'web' => $this->url,
                    'api' => $this->api_url,
                ],
                'next'    => [
                    'web' => $this->next_url,
                    'api' => $this->next_api_url,
                ],
            ],
            'author'                => $this->when(isset($this->author_id) , function (){ return new Author($this->user);}),
            'set'                   => $this->when(isset($this->contentset_id) , function (){ return  new SetInContent($this->set);}),
            'related_product'       => $this->when($this->related_products->isNotEmpty() , $this->related_products) ,
            'recommended_products'  => $this->when($this->recommended_products->isNotEmpty() , $this->recommended_products)
        ];
    }
}
