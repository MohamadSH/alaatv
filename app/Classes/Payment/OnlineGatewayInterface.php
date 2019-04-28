<?php

namespace App\Classes\Payment;

use App\Classes\Nullable;
use App\PaymentModule\Gateways\OnlinePaymentRedirectionUriInterface;
use App\PaymentModule\OnlinePaymentVerificationResponseInterface;

interface OnlineGatewayInterface
{
    public function getAuthorityFromGate(string $callbackUrl, int $cost, string $description, $orderId = null) : Nullable;

    public function getAuthorityKey(): string;
    
    public function getGatewayUrl($refId): OnlinePaymentRedirectionUriInterface;
    
    public function verifyPayment($amount, $authority): OnlinePaymentVerificationResponseInterface;
}