<?php

namespace App\Http\Resources;

use App\Productvoucher;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class \App\Productvoucher
 *
 * @mixin \App\Productvoucher
 *
 */
class HekmatVoucher extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof Productvoucher)) {
            return [];
        }

        return [
            'enable'                => $this->isEnable(),
            'isExpired'             => $this->isExpired(),
            'used_at'               =>  $this->used_at,
            'user'                  => $this->where(isset($this->user_id) , function ($q){
                if(isset($this->user_id)){
                    return new HekmatVoucherUser($this->user) ;
                }

                return null;
            }),
            'products'              => $this->where(isset($this->user_id) , function ($q){
                if(isset($this->products)){
                    return HekmatVoucherProduct::collection($this->products) ;
                }

                return null;
            })
        ];
    }
}
