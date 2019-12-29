<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Block
 *
 * @mixin \App\Block
 *
 * @property mixed notRedirectedContents
 * @property mixed notRedirectedSets
 */
class BlockV1 extends JsonResource
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

        $contests = $this->notRedirectedContents;
        $sets     = $this->notRedirectedSets;
        $products = $this->products;
        $banners  = $this->banners;
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'offer'      => $this->offer,
            'url'        => $this->url,
            'order'      => $this->order,
            'contents'   => optional($contests)->isNotEmpty() ? $contests : null,
            'sets'       => optional($sets)->isNotEmpty() ? $sets : null,
            'products'   => optional($products)->isNotEmpty() ? $products : null,
            'banners'    => optional($banners)->isNotEmpty() ? $banners : null,
            'updated_at' => $this->updated_at,
        ];
    }
}
