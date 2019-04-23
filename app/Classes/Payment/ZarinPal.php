<?php

namespace App\Classes\Payment;

use App\Classes\Nullable;
use App\Transactiongateway;
use Cache;

class ZarinPal
{
    public function getAuthorityFromGate(string $callbackUrl, int $cost, string $description) : Nullable
    {
        /**
         * @var \Zarinpal\Zarinpal
         */
        $zarinpalResponse = app('zarinpal.client')->request($callbackUrl, $cost, $description);

        return nullable($zarinpalResponse['Authority']);
    }

    /**
     * @param string $key
     * @return Transactiongateway
     */
    protected function getGateWayCredentials(): Nullable
    {
        $result = Cache::remember('transactiongateway:Zarinpal', config('constants.CACHE_600'), function () {
            return Transactiongateway::where('name', 'zarinpal')->first();
        });

        return nullable($result);
    }

    public function getGatewayUrl()
    {
        return app('zarinpal.client')->redirectUrl();
    }
}