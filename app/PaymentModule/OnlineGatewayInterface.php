<?php

namespace App\PaymentModule;

use App\Classes\Nullable;
use App\PaymentModule\Gateways\OnlinePaymentRedirectionUriInterface;
use App\PaymentModule\Gateways\OnlinePaymentVerificationResponseInterface;

interface OnlineGatewayInterface
{
    public function generateAuthorityCode(string $callbackUrl, int $cost, string $description, $orderId = null) : Nullable;

    public function getAuthorityValue(): string;
    
    public function generatePaymentPageUriObject($refId): OnlinePaymentRedirectionUriInterface;
    
    public function verifyPayment($amount, $authority): OnlinePaymentVerificationResponseInterface;
}