<?php

namespace App\Http\Resources;

use App\Contentset;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Set
 *
 * @mixin Contentset
 * */
class ProductSet extends JsonResource
{
    function __construct(Contentset $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof Contentset)) {
            return [];
        }

        return [
            'id'                    => $this->id,
            'redirect_url'          => $this->redirectUrl,
            'name'                  => $this->name,
            'short_name'            => $this->shortName,
            'photo'                 => $this->photo,
            'url'            => [
                'set'          => [
                    'web' => null,
                    'api' => $this->api_url,
                ],
                'list'         => [
                    'web' => $this->content_url,
                    'api' => null,
                ],
            ],
        ];
    }
}
