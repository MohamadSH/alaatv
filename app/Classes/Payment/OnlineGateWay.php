<?php

namespace App\Classes\Payment;

use Illuminate\Support\Facades\Facade;

class OnlineGateWay extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ZarinPal::class;
    }
}