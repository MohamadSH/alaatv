<?php

namespace App\Http\Resources;

use App\Traits\Product\Resource;
use Illuminate\Http\Request;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class ProductInBlock extends AlaaJsonResourceWithPagination
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

        return [
            'id'           => $this->id,
            'redirect_url' => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'title'        => $this->when(isset($this->name), $this->name),
            'price'        => $this->getPrice(),
            'url'          => $this->getUrl(),
            'photo'        => $this->when(isset($this->photo), $this->photo),
            'category'     => $this->when(isset($this->category), $this->category),
            'attributes'   => $this->getAttributes(),
        ];
    }
}
