<?php

namespace App\Providers;

use App\Websitesetting;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Cache, Config, Schema};

class WebsiteSettingProvider extends ServiceProvider  implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Websitesetting', function ($app) {
            return $this->getSetting();
        });
    }

    /**
     * @return mixed
     */
    private function getSetting()
    {
        $key = "AppServiceProvider:websitesettings";
        return Cache::remember($key, config("constants.CACHE_600"), function () {
            return Websitesetting::where("version", 1)
                ->first();
        });

    }

    public function provides()
    {
        return [
            Websitesetting::class
        ];
    }
}
