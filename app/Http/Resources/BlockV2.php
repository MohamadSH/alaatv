<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class Block
 *
 * @mixin \App\Block
 * */
class BlockV2 extends AlaaJsonResource
{
    function __construct(\App\Block $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Block)) {
            return [

            ];
        }

        $contents = $this->notRedirectedContents;
        $sets     = $this->notRedirectedSets;
        $products = $this->products;
        $banners  = $this->banners;
        return [
            'id'         => $this->id,
            'title'      => $this->when(isset($this->title), $this->title),
            'offer'      => $this->when(isset($this->offer), $this->offer),
            'url'        => $this->when(isset($this->url), isset($this->url) ? new UrlForBlock($this) : null),
            'order'      => $this->order,
            'contents'   => $this->when($this->collectionIsNotEmpty($contents), $this->getContents($contents)),
            'sets'       => $this->when($this->collectionIsNotEmpty($sets), $this->getSets($sets)),
            'products'   => $this->when($this->collectionIsNotEmpty($products), $this->getProducts($products)),
            'banners'    => $this->when($this->collectionIsNotEmpty($banners), $this->getBanners($banners)),
            'updated_at' => $this->when(isset($this->updated_at), $this->updated_at),
        ];
    }

    private function collectionIsNotEmpty($collection)
    {
        return isset($collection) && $collection->isNotEmpty();
    }

    private function getContents($contents)
    {
        return $this->collectionIsNotEmpty($contents) ? ContentInSet::collection($contents) : null;
    }

    private function getSets($sets)
    {
        return $this->collectionIsNotEmpty($sets) ? SetInIndex::collection($sets) : null;
    }

    private function getProducts($products)
    {
        return $this->collectionIsNotEmpty($products) ? ProductInBlock::collection($products) : null;
    }

    private function getBanners($banners)
    {
        return $this->collectionIsNotEmpty($banners) ? Slideshow::collection($banners) : null;
    }
}
