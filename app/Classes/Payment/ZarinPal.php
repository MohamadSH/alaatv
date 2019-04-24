<?php

namespace App\Classes\Payment;

use App\Classes\Nullable;
use App\PaymentModule\Gateways\Zarinpal\VerificationResponse;
use App\Transactiongateway;

class ZarinPal
{
    public function getAuthorityFromGate(string $callbackUrl, int $cost, string $description) : Nullable
    {
        $zarinpalResponse = resolve('zarinpal.client')->request($callbackUrl, $cost, $description);

        return nullable($zarinpalResponse['Authority']);
    }

    public function getAuthorityKey()
    {
        return 'Authority';
    }

    public function getGatewayUrl()
    {
        $url = app('zarinpal.client')->redirectUrl();
        return RedirectData::instance($url);
    }

    public function verifyPayment($amount, $authority)
    {
        $result = app('zarinpal.client')->verify($amount, $authority);

        return new VerificationResponse($result);
    }
    /**
     * @param string $key
     * @return Transactiongateway

     protected function getGateWayCredentials(): Nullable
     {
         $result = Cache::remember('transactiongateway:Zarinpal', config('constants.CACHE_600'), function () {
             return Transactiongateway::where('name', 'zarinpal')->first();
         });

         return nullable($result);
     }*/
}