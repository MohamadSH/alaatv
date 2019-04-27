<?php

namespace App\Classes\Payment;

use App\Classes\Nullable;
use App\PaymentModule\Gateways\Zarinpal\OnlinePaymentRedirectionUriInterface;
use App\PaymentModule\OnlinePaymentVerificationResponseInterface;

interface OnlineGatewayInterface
{
    public function getAuthorityFromGate(string $callbackUrl, int $cost, string $description) : Nullable;

    public function getAuthorityKey(): string;
    
    public function getGatewayUrl(): OnlinePaymentRedirectionUriInterface;
    
    public function verifyPayment($amount, $authority): OnlinePaymentVerificationResponseInterface;
}