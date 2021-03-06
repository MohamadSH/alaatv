<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class Paymentstatus
 *
 * @mixin \App\Paymentstatus
 * */
class Paymentstatus extends AlaaJsonResourceWithPagination
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
        if (!($this->resource instanceof \App\Paymentstatus)) {
            return [];
        }

        return [
            'id'   => $this->id,
            'name' => $this->when(isset($this->displayName), $this->displayName),
        ];
    }
}
