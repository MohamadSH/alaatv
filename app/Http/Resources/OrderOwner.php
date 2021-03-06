<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class User
 *
 * @mixin \App\User
 * */
class OrderOwner extends AlaaJsonResourceWithPagination
{
    function __construct(\App\User $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof \App\User)) {
            return [];
        }

        return [
            'id'                 => $this->id,
            'first_name'         => $this->when(isset($this->firstName), $this->firstName),
            'last_name'          => $this->when(isset($this->lastName), $this->lastName),
            'mobile'             => $this->when(isset($this->mobile), $this->mobile),
            'national_code'      => $this->when(isset($this->nationalCode), $this->nationalCode),
            'profile_completion' => (int)$this->completion(),
        ];
    }
}
