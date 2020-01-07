<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class Gender
 *
 * @mixin \App\Gender
 * */
class Gender extends AlaaJsonResourceWithPagination
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'name' => $this->when(isset($this->name), $this->name),
        ];
    }
}
