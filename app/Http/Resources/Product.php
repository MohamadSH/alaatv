<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class Product extends JsonResource
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
        if (!($this->resource instanceof \App\Product)) {
            return [];
        }

        if (isset($this->redirectUrl)) {
            return [
                'id'           => $this->id,
                'redirect_url' => $this->redirectUrl,
            ];
        }

        $this->loadMissing('sets' , 'children' , 'producttype');

        return [
            'id'            => $this->id,
            'category'      => $this->when(isset($this->category) , $this->category),
            'redirect_url'  => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'title'          => $this->when(isset($this->name) , $this->name),
            'type'          => $this->when(isset($this->producttype_id) , function (){ return new Producttype($this->producttype) ;}),
            'description'   => [
                'short' => $this->when(isset($this->shortDescription) , $this->shortDescription),
                'long'  => $this->when(isset($this->longDescription) , $this->longDescription),
            ],
            'slogan'                => $this->when(isset($this->slogan) , $this->slogan),
            'price'                 => new Price($this->price),
            'tags'                  => $this->when(isset($this->tags) , function (){ return new Tag($this->tags);}),
            'recommender_contents'  => $this->when(isset($this->recommender_contents) , $this->recommender_contents),
            'sample_contents'       => $this->when(isset($this->sample_contents), $this->sample_contents),
            'intro_video'           => $this->when(isset($this->introVideo) , $this->introVideo),
            'page_view'             => $this->when(isset($this->page_view) , $this->page_view),
            'url'                   => new Url($this),
            'photo'                 => $this->when(isset($this->photo) , $this->photo),
            'sample_photos'         => $this->when(isset($this->sample_photos) && $this->sample_photos->isNotEmpty() , function (){return ProductSamplePhoto::collection($this->sample_photos);})  , //It is not a relationship
            'gift'                  => $this->when($this->gift->isNotEmpty() , function (){ return Gift::collection($this->gift) ; }) , //It is not a relationship
            'sets'                  => $this->when($this->sets->isNotEmpty() , function (){return ProductSet::collection($this->whenLoaded('sets'));}),
            'attributes'            => [
                'info' =>  $this->when(!empty($this->info_attributes) , $this->info_attributes),
                'extra' => $this->when(!empty($this->extra_attributes) , $this->extra_attributes),
            ],
            'children'      => $this->when($this->children->isNotEmpty() , function () {return Child::collection($this->children);}),
        ];
    }
}
