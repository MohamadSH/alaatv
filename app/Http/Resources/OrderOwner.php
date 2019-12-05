<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class User
 *
 * @mixin \App\User
 * */
class OrderOwner extends JsonResource
{
    function __construct(\App\User $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\User)) {
            return [];
        }

        return [
            'id'            => $this->id,
            'first_name'    => $this->firstName,
            'last_name'     => $this->lastName,
            'mobile'        => $this->mobile,
            'national_code' => $this->nationalCode ,
            'province'      => $this->province,
            'city'          => $this->city,
            'address'       => $this->address,
            'postal_code'   => $this->postalCode,
            'school'        => $this->school,
            'info'          => $this->info,
            'profile_completion'  => (int) $this->completion(),
        ];
    }
}
