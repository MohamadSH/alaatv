<?php

namespace App\Providers;

use App\Websitesetting;
use Illuminate\Support\Facades\{Cache};
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class WebsiteSettingProvider extends ServiceProvider  implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Websitesetting::class, function ($app) {
            return $this->getSetting();
        });
    }

    /**
     * @return mixed
     */
    private function getSetting()
    {
        $key = 'AppServiceProvider:websitesettings';
        return Cache::remember($key, config('constants.CACHE_600'), function () {
            return Websitesetting::where('version', 1)
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
