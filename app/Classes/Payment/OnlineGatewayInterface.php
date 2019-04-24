<?php

namespace App\Classes\Payment;

interface OnlineGatewayInterface
{
    public function getAuthorityFromGate(string $callbackUrl, int $cost, string $description);

    public function getAuthorityKey();

    public function getGatewayUrl();

    public function verifyPayment($amount, $authority);
}