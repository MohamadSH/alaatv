<?php

namespace App\PaymentModule\Gateways\Zarinpal;

use App\Classes\Nullable;
use App\Classes\Payment\OnlineGatewayInterface;
use App\Classes\Payment\RedirectData;
use App\PaymentModule\OnlinePaymentVerificationResponseInterface;

class ZarinpalGateWay implements OnlineGatewayInterface
{
    public function getAuthorityFromGate(string $callbackUrl, int $cost, string $description): Nullable
    {
        $zarinpalResponse = resolve('zarinpal.client')->request($callbackUrl, $cost, $description);
        
        return nullable($zarinpalResponse['Authority'] ?? null);
    }
    
    public function getAuthorityKey(): string
    {
        return 'Authority';
    }
    
    public function getGatewayUrl(): OnlinePaymentRedirectionUriInterface
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