<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Product
 *
 * @mixin \App\Product
 * */
class Gift extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Product)) {
            return [];
        }

        return [
            'redirect_url'          => $this->redirectUrl,
            'name'                  => $this->name,
            'url'           => [
                'web' => $this->url,
                'api' => $this->api_url,
            ],
            'photo'         => $this->photo,
        ];
    }
}
