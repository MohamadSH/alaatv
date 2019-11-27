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

        return [
            'id'            => $this->id,
            'category'      => $this->category ,
            'order'         => $this->order,
            'redirect_url'  => null,
            'name'          => $this->name,
            'type'          => $this->producttype,
            'description'   => [
                'short' => $this->shortDescription,
                'long'  => $this->longDescription,
            ],
            'slogan'        => $this->slogan,
            'enable'        => $this->enable,
            'amount'        => $this->amount,
            'isFree'        => $this->isFree,
            'price'         => $this->price,
            'tags'          => $this->tags,
            'recommender_contents' => $this->recommender_contents,
            'sample_contents'      => $this->sample_contents,
            'introVideo'    => $this->introVideo,
            'page_view'     => $this->page_view,
            'url'           => [
                'web' => $this->url,
                'api' => $this->api_url,
            ],
            'photo'         => $this->photo,
            'sample_photos' => $this->sample_photos,
            'gift'          => $this->gift->isNotEmpty() ? Product::collection($this->gift) : null,
            'sets'          => Set::collection($this->whenLoaded('sets')),
            'attributes'    => $this->attributes,
            'children'      => $this->children->isNotEmpty() ? Product::collection($this->children) : null,
            'updated_at'    => $this->updated_at,
            'validSince'    => $this->validSince,
            'validUntil'    => $this->validUntil,
            'bonPlus'       => $this->bon_plus,
            'bonDiscount'   => $this->bon_discount,
            'bons'          => $this->bons,
        ];
    }
}
