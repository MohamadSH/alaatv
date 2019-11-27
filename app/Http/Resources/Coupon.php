<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Coupon
 *
 * @mixin \App\Coupon
 * */
class Coupon extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'enable'        => $this->enable,
            'description'   => $this->description,
            'code'          => $this->code,
            'discount'      => $this->discount,
            'usageLimit'    => $this->usageLimit,
            'usageNumber'   => $this->usageNumber,
            'validSince'    => $this->validSince,
            'validUntil'    => $this->validUntil,
            'coupontype'    => new Coupontype($this->coupontype),
            'discounttype'  => new Discounttype($this->discounttype),
        ];
    }
}
