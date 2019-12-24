<?php

namespace App\Http\Resources;

use App\Contentset;
use Illuminate\Http\Request;

/**
 * Class Set
 *
 * @mixin Contentset
 * */
class SetInContent extends AlaaJsonResource
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
            'id'                        => $this->id,
            'redirect_url'              => $this->when(isset($this->redirectUrl) , $this->redirectUrl),
            'title'                      => $this->when(isset($this->name) , $this->name),
            'short_title'                => $this->when(isset($this->shortName) , $this->shortName),
            'photo'                     => $this->when(isset($this->photo) , $this->photo),
            'url'                       => new Url($this),
        ];
    }
}
