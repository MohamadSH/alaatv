<?php

namespace App\Http\Resources;

use App\Contentset;
use Illuminate\Http\Request;

/**
 * Class Set
 *
 * @mixin Contentset
 * */
class ProductSet extends AlaaJsonResourceWithoutPagination
{
    function __construct(Contentset $model)
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
        if (!($this->resource instanceof Contentset)) {
            return [];
        }

        return [
            'id'           => $this->id,
            'redirect_url' => $this->when(isset($this->redirectUrl), $this->redirectUrl),
            'title'        => $this->when(isset($this->name), $this->name),
            'short_title'  => $this->when(isset($this->short_name), $this->short_name),
            'url'          => new Url($this),
        ];
    }
}
