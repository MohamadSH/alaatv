<?php

namespace App\Http\Resources;

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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'firstName'    => $this->firstName,
            'lastName'     => $this->lastName,
            'nationalCode' => $this->nationalCode ,
            'province'     => $this->province,
            'city'         => $this->city,
            'address'      => $this->address,
            'postalCode'   => $this->postalCode,
            'school'       => $this->school,
            'info'         => $this->info,
        ];
    }
}
