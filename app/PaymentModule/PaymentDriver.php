<?php

namespace App\PaymentModule;

use App\Classes\Payment\OnlineGatewayInterface;
use App\PaymentModule\Gateways\Zarinpal\BehpardakhtGateWay;
use App\PaymentModule\Gateways\Zarinpal\ZarinpalGateWay;

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