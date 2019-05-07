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

    private static $gates = ['zarinpal' => 1 , 'mellat' => 4 ,];

    public static function select($driver)
    {
        app()->bind(OnlineGatewayInterface::class, self::$map[$driver]);
        config()->set('constants.PAYMENT_METHOD_ONLINE', self::$gates[$driver]);
    }
}