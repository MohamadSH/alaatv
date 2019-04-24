<?php

namespace App\Classes\Payment;

use Illuminate\Support\Facades\Facade;

/**
 * Class OnlineGateWay
 *
 * @method static getGatewayUrl();
 * @method static getAuthorityKey();
 * @method static verifyPayment($amount, $authority);
 * @method static getAuthorityFromGate(string $callbackUrl, int $cost, string $description);
 *
 * @package App\Classes\Payment
 */
class OnlineGateWay extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return OnlineGatewayInterface::class;
    }
}