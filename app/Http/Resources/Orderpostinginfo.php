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
        return [
            'postCode' => $this->postCode
        ];
    }
}
