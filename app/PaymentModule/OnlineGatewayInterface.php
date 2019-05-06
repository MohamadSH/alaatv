<?php

namespace App\PaymentModule;

use App\Classes\Nullable;

interface OnlineGatewayInterface
{
    public function generateAuthorityCode(string $callbackUrl, Money $cost, string $description, $orderId = null): Nullable;

    public function getAuthorityValue(): string;
    
    public function generatePaymentPageUriObject($refId): OnlinePaymentRedirectionUriInterface;
    
    public function verifyPayment(Money $amount, $authority): OnlinePaymentVerificationResponseInterface;
}