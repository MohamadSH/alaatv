<?php

namespace App\Providers\Gateways;

use Illuminate\Support\ServiceProvider;
use Zarinpal\Zarinpal;

class ZarinpalServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('zarinpal.client', function () {
            return $this->initialize();
        });

        $this->app['zarinpal.isSandBox'] = $this->isZarinpalSandboxOn();
    }
    
    /**
     * @return \Zarinpal\Zarinpal
     */
    private function initialize()
    {
        $gatewayComposer = new Zarinpal($this->getMerchantNumber());
        
        if ($this->isZarinpalSandboxOn()) {
            $gatewayComposer->enableSandbox();
        }
        
        if ($this->isZarinGateOn()) {
            $gatewayComposer->isZarinGate();
        }
        
        return $gatewayComposer;
    }
    
    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getMerchantNumber()
    {
        return config('Zarinpal.merchantID');
    }
    
    /**
     * @return bool
     */
    private function isZarinpalSandboxOn()
    {
        return config('app.env', 'deployment') != 'deployment' && config('Zarinpal.Sandbox', false);
    }
    
    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function isZarinGateOn()
    {
        return config('Zarinpal.ZarinGate', false);
    }
}