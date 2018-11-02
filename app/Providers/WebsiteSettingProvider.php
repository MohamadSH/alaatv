<?php

namespace App\Providers;

use App\Websitesetting;
use Illuminate\Support\Facades\{Cache, Config};
use Illuminate\Support\ServiceProvider;

class WebsiteSettingProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $key = "AppServiceProvider:websitesettings";
        $setting = Cache::remember($key, Config::get("constants.CACHE_600"), function () {
            return Websitesetting::where("version", 1)
                                 ->get()
                                 ->first();
        });

        view()->share('wSetting', $setting->setting);
        view()->share('setting', $setting);

        if (isset($wSetting->site->name))
            Config::set("constants.SITE_NAME", $setting->setting->site->name);

        $this->app->singleton('App\Websitesetting', function ($app) use ($setting) {
            return $setting;
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
