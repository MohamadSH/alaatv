<?php

namespace App\PaymentModule;

use App\PaymentModule\Gateways\Zarinpal\ZarinpalGateWay;
use App\PaymentModule\Gateways\Behpardakht\BehpardakhtGateWay;

class PaymentDriver
{
    public static function select($driver)
    {
        $map = [
            'zarinpal' => ZarinpalGateWay::class,
            'mellat' => BehpardakhtGateWay::class,
            // To do : beh-pardakht
        ];

        $class = $map[$driver];

        app()->bind(OnlineGatewayInterface::class, $class);
    }
}