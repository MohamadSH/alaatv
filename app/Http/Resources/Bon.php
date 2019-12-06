<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Bon
 *
 * @mixin \App\Bon
 * */
class Bon extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Bon)) {
            return [];
        }

        return [
            'name'          => $this->name,
            'display_name'   => $this->displayName,
        ];
    }
}
