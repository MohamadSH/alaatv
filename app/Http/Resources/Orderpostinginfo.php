<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class \App\Orderpostinginfo
 *
 * @mixin \App\Orderpostinginfo
 * */
class Orderpostinginfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\Orderpostinginfo)) {
            return [];
        }


        return [
            'post_code' => $this->when(isset($this->postCode) , $this->postCode)
        ];
    }
}
