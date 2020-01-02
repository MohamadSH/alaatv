<?php

namespace App\Observers;

use App\Coupon;
use Illuminate\Support\Facades\Cache;

class CouponObserver
{
    /**
     * Handle the coupon "created" event.
     *
     * @param  \App\Coupon  $coupon
     * @return void
     */
    public function created(Coupon $coupon)
    {
        //
    }

    /**
     * Handle the coupon "updated" event.
     *
     * @param  \App\Coupon  $coupon
     * @return void
     */
    public function updated(Coupon $coupon)
    {
        //
    }

    /**
     * Handle the coupon "deleted" event.
     *
     * @param  \App\Coupon  $coupon
     * @return void
     */
    public function deleted(Coupon $coupon)
    {
        //
    }

    /**
     * Handle the coupon "restored" event.
     *
     * @param  \App\Coupon  $coupon
     * @return void
     */
    public function restored(Coupon $coupon)
    {
        //
    }

    /**
     * Handle the coupon "force deleted" event.
     *
     * @param  \App\Coupon  $coupon
     * @return void
     */
    public function forceDeleted(Coupon $coupon)
    {
        //
    }

    public function saved(Coupon $coupon)
    {
        Cache::tags([
            'coupon_' . $coupon->id,
        ])->flush();
    }
}
