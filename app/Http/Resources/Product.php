<?php

namespace App\Http\Resources;

use App\Traits\Product\Resource;
use Illuminate\Http\Request;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class Product extends AlaaJsonResourceWithPagination
{
    use Resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
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

        $this->loadMissing('sets', 'children', 'producttype');

        return [
            'id'            => $this->id,
            'redirect_url'  => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'type'          => $this->when(isset($this->producttype_id), $this->getType()),
            'category'      => $this->when(isset($this->category), $this->category),
            'title'         => $this->when(isset($this->name), $this->name),
            'description'   => $this->getDescription(),
            'price'         => $this->getPrice(),
            'tags'          => $this->when(isset($this->tags), $this->getTags()),
            'intro_video'   => $this->when(isset($this->introVideo), $this->introVideo),
            'url'           => $this->getUrl(),
            'photo'         => $this->when(isset($this->photo), $this->photo),
            'sample_photos' => $this->when($this->hasSamplePhoto(), $this->getSamplePhoto()), //It is not a relationship
            'gift'          => $this->when($this->gift->isNotEmpty(), $this->getGift()), //It is not a relationship
            'sets'          => $this->when($this->sets->isNotEmpty(), $this->getSet()),
            'blocks'        => BlockV2::collection(optional($this)->blocks),
            'attributes'    => $this->getAttributes(),
            'children'      => $this->when($this->children->isNotEmpty(), $this->getChildren()),
            'page_view'     => $this->when(isset($this->page_view), $this->page_view),
        ];
    }
}
