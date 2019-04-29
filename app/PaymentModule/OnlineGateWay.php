<?php

namespace App\PaymentModule;

use Illuminate\Support\Facades\Facade;

/**
 * Class OnlineGateWay
 *
 * @method static generatePaymentPageUriObject();
 * @method static getAuthorityValue();
 * @method static verifyPayment($amount, $authority);
 * @method static generateAuthorityCode(string $callbackUrl, int $cost, string $description);
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