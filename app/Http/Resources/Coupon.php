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
        if (!($this->resource instanceof \App\Coupon)) {
            return [];
        }

        $this->loadMissing('coupontype' , 'discounttype') ;

        return [
            'name'          => $this->name,
            'code'          => $this->code,
            'discount'      => $this->discount,
            'usage_number'  => $this->usageNumber,
            'coupontype'    => $this->when(isset($this->coupontype_id) , function (){ return new Coupontype($this->coupontype);}),
            'discounttype'  => $this->when(isset($this->discounttype_id) , function (){ return new Discounttype($this->discounttype);}),
        ];
    }
}
