<?php

namespace App\Classes\Payment;

use App\PaymentModule\OnlinePaymentVerificationResponseInterface;
use App\PaymentModule\Gateways\Zarinpal\OnlinePaymentRedirectionUriInterface;

interface OnlineGatewayInterface
{
    public function getAuthorityFromGate(string $callbackUrl, int $cost, string $description);

    public function getAuthorityKey(): string;

    public function getGatewayUrl(): OnlinePaymentRedirectionUriInterface;

    public function verifyPayment($amount, $authority): OnlinePaymentVerificationResponseInterface;
}