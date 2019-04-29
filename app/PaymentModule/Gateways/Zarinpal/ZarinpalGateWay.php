<?php

namespace App\PaymentModule\Gateways\Zarinpal;

use App\Classes\Nullable;
//use App\Classes\Payment\{OnlineGatewayInterface, RedirectData};
use App\PaymentModule\Gateways\OnlinePaymentVerificationResponseInterface;
use App\PaymentModule\Gateways\OnlinePaymentRedirectionUriInterface;
use App\PaymentModule\OnlineGatewayInterface;
use App\PaymentModule\RedirectData;

class ZarinpalGateWay implements OnlineGatewayInterface
{
    public function generateAuthorityCode(string $callbackUrl, int $cost, string $description, $orderId = null): Nullable
    {
        $zarinpalResponse = resolve('zarinpal.client')->request($callbackUrl, $cost, $description);
        
        return nullable($zarinpalResponse['Authority'] ?? null);
    }
    
    public function getAuthorityValue(): string
    {
        return request()->get('Authority');
    }
    
    public function generatePaymentPageUriObject($refId): OnlinePaymentRedirectionUriInterface
    {
        $url = app('zarinpal.client')->redirectUrl();

        return RedirectData::instance($url);
    }
    
    public function verifyPayment($amount, $authority): OnlinePaymentVerificationResponseInterface
    {
        $result = app('zarinpal.client')->verify($amount, $authority);
        
        return VerificationResponse::instance($result);
    }
}