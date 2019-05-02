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
            
            return [
            
            ];
        }
        if (isset($this->redirectUrl)) {
            return [
                'id'           => $this->id,
                'redirect_url' => $this->redirectUrl,
            ];
        }
        return [
            'id'            => $this->id,
            'order'         => $this->order,
            'redirect_url'  => null,
            'name'          => $this->name,
            'type'          => $this->type,
            'description'   => [
                'short' => $this->shortDescription,
                'long'  => $this->longDescription,
            ],
            'amount'        => $this->amount,
            'isFree'        => $this->isFree,
            'price'         => $this->price,
            'tags'          => $this->tags,
            'introVideo'    => $this->introVideo,
            'page_view'     => $this->page_view,
            'url'           => [
                'web' => $this->url,
                'api' => $this->apiUrl,
            ],
            'photo'         => $this->photo,
            'sample_photos' => $this->samplePhotos,
            'gift'          => $this->gift->isNotEmpty() ? Product::collection($this->gift) : null,
            'sets'          => Set::collection($this->whenLoaded('sets')),
            'attributes'    => $this->attributes,
            'children'      => $this->children->isNotEmpty() ? Product::collection($this->children) : null,
            'updated_at'    => $this->updated_at,
        ];
    }
}
