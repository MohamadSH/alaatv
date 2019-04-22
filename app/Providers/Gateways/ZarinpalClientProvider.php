<?php

namespace App\Providers\Gateways;

use Illuminate\Support\ServiceProvider;
use Zarinpal\Zarinpal as ZarinpalClient;

class ZarinpalClientProvider extends ServiceProvider
{
    function register()
    {
        $this->app->singleton('zarinpal.client', $this->initialize());
    }

    /**
     * @param bool $withSandBox
     * @param \App\Transactiongateway $transactionGateWay
     * @return \Zarinpal\Zarinpal
     */
    private function initialize(): ZarinpalClient
    {
        $gatewayComposer = new ZarinpalClient($this->getMerchantNumber());

        if ($this->isZarinpalSandboxOn()) {
            $gatewayComposer->enableSandbox();
        }

        if ($this->isZarinGateOn()) {
            $gatewayComposer->isZarinGate();
        }

        return $gatewayComposer;
    }

    /**
     * @return bool
     */
    private function isZarinpalSandboxOn(): bool
    {
        return config('app.env', 'deployment') != 'deployment' && config('Zarinpal.Sandbox', false);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function isZarinGateOn(): bool
    {
        return config('Zarinpal.ZarinGate', false);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getMerchantNumber()
    {
        return config('Zarinpal.merchantNumber');
    }
}