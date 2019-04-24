<?php

namespace App\PaymentModule;

use App\Classes\Payment\OnlineGatewayInterface;
use App\PaymentModule\Gateways\Zarinpal\ZarinpalGateWay;

class PaymentDriver
{
    public static function select($driver)
    {
        $map = [
            'zarinpal' => ZarinpalGateWay::class,
            // To do : beh-pardakht
        ];

        app()->bind(OnlineGatewayInterface::class, $map[$driver]);
    }
}