<?php

namespace App\Providers;

use App\Websitesetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Cache, Config, Schema};

class WebsiteSettingProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $setting = $this->getSetting();
        view()->share('wSetting', optional($setting)->setting);
        view()->share('wLogoUrl', optional($setting)->site_logo_url);
        view()->share('setting', $setting);
        
        if (isset(optional(optional($setting)->site)->name)) {
            Config::set("constants.SITE_NAME", $setting->setting->site->name);
        }
        
        $this->app->singleton('App\Websitesetting', function ($app) use ($setting) {
            return $setting;
        });
    }
    
    /**
     * @return mixed
     */
    public function getSetting()
    {
        $key = "AppServiceProvider:websitesettings";
        if (Schema::hasTable('websitesettings')) {
            return Cache::remember($key, config("constants.CACHE_600"), function () {
                return Websitesetting::where("version", 1)
                    ->get()
                    ->first();
            });
        }
        
        return new Websitesetting();
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
