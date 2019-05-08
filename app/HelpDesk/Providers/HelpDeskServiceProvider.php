<?php

namespace App\HelpDesk\Providers;

use Illuminate\Support\ServiceProvider;

class HelpDeskServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__, 1).'/config.php', 'helpDesk');
    }
    
    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__, 1).'/Database/Migrations');
    
        $this->loadTranslationsFrom(dirname(__DIR__, 1).'/Translations', 'helpDesk');
    
        $this->publishes([
            dirname(__DIR__, 1).'/Translations' => resource_path('lang/vendor/helpDesk'),
        ]);
    
        $this->publishes([
            dirname(__DIR__, 1).'/config.php' => config_path('helpDesk.php'),
        ], 'config');
    
        $this->loadViewsFrom(dirname(__DIR__, 1).'/Views', 'helpDesk');
    
        $this->loadRoutesFrom(dirname(__DIR__, 1).'/Route/web.php');
        $this->loadRoutesFrom(dirname(__DIR__, 1).'/Route/api.php');
    }
}
