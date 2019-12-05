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
            'category'      => $this->category ,
            'redirect_url'  => $this->redirectUrl,
            'name'          => $this->name,
            'type'          => $this->when(isset($this->producttype_id) , function (){ return new Producttype($this->producttype) ;}),
//            'isFree'        => $this->isFree,
            'description'   => [
                'short' => $this->shortDescription,
                'long'  => $this->longDescription,
            ],
            'slogan'                => $this->slogan,
//            'amount'                => $this->amount,
            'price'                 => $this->price,
            'tags'                  => $this->tags,
            'recommender_contents'  => $this->when(isset($this->recommender_contents) , $this->recommender_contents),
            'sample_contents'       => $this->when(isset($this->sample_contents), $this->sample_contents),
            'intro_video'    => $this->introVideo,
            'page_view'     => $this->page_view,
            'url'           => [
                'web' => $this->url,
                'api' => $this->api_url,
            ],
            'photo'         => $this->photo,
            'sample_photos' => ProductSamplePhoto::collection($this->sample_photos), //It is not a relationship
            'gift'          => $this->when($this->gift->isNotEmpty() , function (){ return Gift::collection($this->gift) ; }) , //It is not a relationship
            'sets'          => ProductSet::collection($this->whenLoaded('sets')),
            'attributes'    => [
                'info' =>  $this->when(!empty($this->info_attributes) , $this->info_attributes),
                'extra' => $this->when(!empty($this->extra_attributes) , $this->extra_attributes),
            ],
            'children'      => Child::collection($this->whenLoaded('children')),
        ];
    }
}
