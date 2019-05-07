<?php

namespace App\PaymentModule;

use Illuminate\Support\ServiceProvider;
use App\PaymentModule\Gateways\Zarinpal\ZarinpalGateWay;

class OnlinePaymentGatewayServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }
}