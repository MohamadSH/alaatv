<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TransactionStatus
 *
 * @mixin \App\Transactionstatus
 * */
class TransactionStatus extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'         => $this->when(isset($this->name) , $this->name) ,
            'display_name' => $this->when(isset($this->displayName) , $this->displayName),
        ];
    }
}
