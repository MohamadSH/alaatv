<?php

namespace App\PaymentModule;

use App\PaymentModule\Gateways\Zarinpal\ZarinpalGateWay;
use App\PaymentModule\Gateways\Behpardakht\BehpardakhtGateWay;

class PaymentDriver
{
    private static $map = [
        'zarinpal' => ZarinpalGateWay::class,
        'mellat'   => BehpardakhtGateWay::class,
    ];
    
    public static function select($driver)
    {
        app()->bind(OnlineGatewayInterface::class, self::$map[$driver]);
    }
}