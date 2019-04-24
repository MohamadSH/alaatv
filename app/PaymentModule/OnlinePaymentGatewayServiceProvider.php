<?php

namespace App\PaymentModule;

use App\Classes\Payment\OnlineGatewayInterface;
use App\PaymentModule\Gateways\Zarinpal\ZarinpalGateWay;
use Illuminate\Support\ServiceProvider;

class OnlinePaymentGatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(OnlineGatewayInterface::class, ZarinpalGateWay::class);
    }
}