<?php

namespace App\Providers;

use App\Websitesetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('websitesettings')) {
            $key = "AppServiceProvider:websitesettings";

            $setting = Cache::remember($key, Config::get("constants.CACHE_600"), function () {
                return Websitesetting::where("version", 1)->get()->first();
            });

            $wSetting = json_decode($setting->setting);
            view()->share('wSetting', $wSetting);
            view()->share('setting', $setting);
            if (isset($wSetting->site->name))
                Config::set("constants.SITE_NAME", $wSetting->site->name);
            $this->app->singleton('setting', function () use ($setting) {
                return $setting;
            });

//            $this->app->bind("\App\Setting", function ($app){
//                return $app['setting'];
//            });
        }
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
