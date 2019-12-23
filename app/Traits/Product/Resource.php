<?php


namespace App\Traits\Product;


use App\Http\Resources\Child;
use App\Http\Resources\Gift;
use App\Http\Resources\ProductSamplePhoto;
use App\Http\Resources\ProductSet;
use App\Http\Resources\Tag;

trait Resource
{
    private function getChildren()
    {
        return $this->children->isNotEmpty() ? Child::collection($this->children) : null;
    }

    private function getTags()
    {
        return isset($this->tags) ? new Tag($this->tags) : null;
    }

    private function getGift()
    {
        return $this->gift->isNotEmpty() ? Gift::collection($this->gift) : null;
    }

    private function getSet()
    {
        return $this->sets->isNotEmpty() ? ProductSet::collection($this->whenLoaded('sets')) : null;
    }

    private function getSamplePhoto()
    {
        return $this->hasSamplePhoto() ? ProductSamplePhoto::collection($this->sample_photos) : null;
    }

    /**
     * @return bool
     */
    private function hasSamplePhoto(): bool
    {
        return isset($this->sample_photos) && $this->sample_photos->isNotEmpty();
    }

    private function getType()
    {
//        return new Producttype($this->producttype);
        return $this->producttype_id;
    }

    /**
     * @return array
     */
    private function getDescription(): ?array
    {
        if (!isset($this->shortDescription) && !isset($this->longDescription)) {
            return null;
        }
        return [
            'slogan' => $this->when(isset($this->slogan), $this->slogan),
            'short'  => $this->when(isset($this->shortDescription), $this->shortDescription),
            'long'   => $this->when(isset($this->longDescription), $this->longDescription),
        ];
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
            'info'  => $this->when(!empty($this->info_attributes), !empty($this->info_attributes) ? $this->info_attributes : null),
            'extra' => $this->when(!empty($this->extra_attributes), !empty($this->extra_attributes) ? $this->extra_attributes : null),
        ];
    }

}
