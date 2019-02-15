<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:43
 */

namespace App\Traits\User;


trait VouchersTrait
{
    /**
     * Retrieve all product vouchers of this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productvouchers()
    {
        return $this->hasMany("\App\Productvoucher");
    }
}