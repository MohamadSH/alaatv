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
            'redirect_url'          => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'name'                  => $this->when(isset($this->name) , $this->name),
            'short_name'            => $this->when(isset($this->short_name) , $this->short_name),
            'photo'                 => $this->when(isset($this->photo) , $this->photo),
            'url'                   => new Url($this),
            'list_contents'         => [
                'web' => $this->content_url,
            ],
        ];
    }
}
