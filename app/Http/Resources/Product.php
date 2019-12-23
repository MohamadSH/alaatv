<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class Product extends AlaaJsonResource
{
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
            'id'                   => $this->id,
            'category'             => $this->when(isset($this->category), $this->category),
            'redirect_url'         => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'title'                => $this->when(isset($this->name), $this->name),
            'type'                 => $this->when(isset($this->producttype_id), $this->getType()),
            'description'          => $this->getDescription(),
            'slogan'               => $this->when(isset($this->slogan), $this->slogan),
            'price'                => new Price($this->price),
            'tags'                 => $this->when(isset($this->tags), $this->getTags()),
            'recommended_contents' => $this->when(isset($this->recommender_contents), $this->recommender_contents),
            'sample_contents'      => $this->when(isset($this->sample_contents), $this->sample_contents),
            'intro_video'          => $this->when(isset($this->introVideo), $this->introVideo),
            'page_view'            => $this->when(isset($this->page_view), $this->page_view),
            'url'                  => new Url($this),
            'photo'                => $this->when(isset($this->photo), $this->photo),
            'sample_photos'        => $this->when($this->hasSamplePhoto(), $this->getSamplePhoto()), //It is not a relationship
            'gift'                 => $this->when($this->gift->isNotEmpty(), $this->getGift()), //It is not a relationship
            'sets'                 => $this->when($this->sets->isNotEmpty(), $this->getSet()),
            'attributes'           => $this->getAttributes(),
            'children'             => $this->when($this->children->isNotEmpty(), $this->getChildren()),
        ];
    }

    private function getChildren()
    {
        return Child::collection($this->children);
    }

    private function getTags()
    {
        return new Tag($this->tags);
    }

    private function getGift()
    {
        return Gift::collection($this->gift);
    }

    private function getSet()
    {
        return ProductSet::collection($this->whenLoaded('sets'));
    }

    private function getSamplePhoto()
    {
        return ProductSamplePhoto::collection($this->sample_photos);
    }

    private function getType()
    {
//        return new Producttype($this->producttype);
        return $this->producttype_id;
    }

    /**
     * @return array
     */
    private function getDescription(): array
    {
        return [
            'short' => $this->when(isset($this->shortDescription), $this->shortDescription),
            'long'  => $this->when(isset($this->longDescription), $this->longDescription),
        ];
    }

    /**
     * @return bool
     */
    private function hasSamplePhoto(): bool
    {
        return isset($this->sample_photos) && $this->sample_photos->isNotEmpty();
    }

    /**
     * @return array | null
     */
    private function getAttributes(): ?array
    {
        if (empty($this->info_attributes) && empty($this->extra_attributes)) {
            return null;
        }
        return [
            'info'  => $this->when(!empty($this->info_attributes), $this->info_attributes),
            'extra' => $this->when(!empty($this->extra_attributes), $this->extra_attributes),
        ];
    }
}
