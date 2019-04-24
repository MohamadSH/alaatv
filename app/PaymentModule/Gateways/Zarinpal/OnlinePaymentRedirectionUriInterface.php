<?php

namespace App\PaymentModule\Gateways\Zarinpal;

interface OnlinePaymentRedirectionUriInterface
{
    public function getRedirectUrl(): string;

    public function getMethod(): string;

    public function getInput(): array;
}