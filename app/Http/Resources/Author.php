<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class User
 *
 * @mixin \App\User
 * */
class Author extends JsonResource
{
    function __construct(\App\User $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\User)) {
            return [];
        }

        return [
                'id'         => $this->id,
                'first_name' => $this->firstName ,
                'last_name'  => $this->lastName ,
                'photo'      => $this->photo ,
                'full_name'  => $this->full_name,
                'name_slug'  => $this->nameSlug,
            ];
    }
}
