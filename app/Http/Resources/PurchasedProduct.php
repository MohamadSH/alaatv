<?php

namespace App\Http\Resources;

use App\Traits\Product\Resource;
use Illuminate\Http\Request;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class PurchasedProduct extends AlaaJsonResourceWithPagination
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

        $this->loadMissing('sets', 'children', 'producttype');

        return [
            'id'           => $this->id,
            'redirect_url' => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'type'         => $this->when(isset($this->producttype_id), $this->getType()),
            'category'     => $this->when(isset($this->category), $this->category),
            'title'        => $this->when(isset($this->name), $this->name),
            'is_free'       => $this->isFree,
            'url'          => $this->getUrl(),
            'photo'        => $this->when(isset($this->photo), $this->photo),
            'attributes'   => $this->getAttributes(),

        ];
    }
}
