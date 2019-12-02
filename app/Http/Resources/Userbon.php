<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Userbon
 *
 * @mixin \App\Userbon
 * */
class Userbon extends JsonResource
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
            'bon_id'            => $this->bon_id,
            'user_id'           => $this->user_id,
            'totalNumber'       => $this->totalNumber,
            'usedNumber'        => $this->usedNumber,
            'validSince'        => $this->validSince,
            'validUntil'        => $this->validUntil,
            'orderproduct_id'   => $this->orderproduct_id,
            'userbonstatus_id'  => $this->userbonstatus_id,
        ];
    }
}
