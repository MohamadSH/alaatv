<?php

namespace App\PaymentModule;

use App\Classes\Nullable;
use Illuminate\Support\Facades\Facade;
use App\PaymentModule\Gateways\OnlinePaymentRedirectionUriInterface;

/**
 * Class OnlineGateWay
 *
 * @method static getAuthorityValue();
 * @method static verifyPayment($amount, $authority);
 * @method static Nullable generateAuthorityCode(string $callbackUrl, int $cost, string $description, $orderId);
 * @method static OnlinePaymentRedirectionUriInterface generatePaymentPageUriObject($refId)
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