<?php

namespace App\PaymentModule\Gateways;

interface OnlinePaymentRedirectionUriInterface
{
    public function getRedirectUrl(): string;
    
    public function getMethod(): string;
    
    public function getInput(): array;
}