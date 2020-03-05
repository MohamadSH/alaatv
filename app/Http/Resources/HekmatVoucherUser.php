<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class \App\User
 *
 * @mixin \App\User
 *
 */
class HekmatVoucherUser extends JsonResource
{
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
            'first_name' => $this->firstName,
            'last_name' =>  $this->lastName,
        ];
    }
}
