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
class SetInContentSearch extends JsonResource
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
            'id'          => $this->id,
            'title'       => $this->when(isset($this->name), $this->name),
            'short_title' => $this->when(isset($this->shortName), $this->shortName),
        ];
    }
}
