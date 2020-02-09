<?php

namespace App\Repositories;


use App\Coupon;

class CouponRepo
{
    /**
     * @param string $code
     *
     * @return
     */
    public static function findCouponByCode(string $code): ?Coupon
    {
        return Coupon::where('code', $code)->first();
    }
}
