<?php

namespace App\Http\Resources;

use App\Traits\Product\Resource;
use Illuminate\Http\Request;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class Child extends AlaaJsonResourceWithoutPagination
{
    use Resource;

    function __construct(\App\Product $model)
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
        if (!($this->resource instanceof \App\Product)) {
            return [];
        }

        if (isset($this->redirectUrl)) {
            return [
                'id'           => $this->id,
                'redirect_url' => $this->redirectUrl,
            ];
        }

        $this->loadMissing('children');

        return [
            'id'           => $this->id,
            'redirect_url' => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'title'        => $this->when(isset($this->name), $this->name),
            'price'        => $this->getPrice(),
            'intro_video'  => new IntroVideoOfProduct($this),
            'url'          => $this->getUrl(),
            'photo'        => $this->when(isset($this->photo), $this->photo),
            'gift'         => $this->when($this->gift->isNotEmpty(), $this->getGift()), //It is not a relationship
            'attributes'   => $this->getAttributes(),
            'children'     => $this->when($this->children->isNotEmpty(), $this->getChildren()),
        ];
    }
}
