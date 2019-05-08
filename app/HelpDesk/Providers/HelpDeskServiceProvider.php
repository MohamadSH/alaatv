<?php

namespace App\HelpDesk\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class HelpDeskServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__, 1).'/config.php', 'helpDesk');
        $this->loadMigrationsFrom(dirname(__DIR__, 1).'/Database/Migrations');
    
    
        $this->loadTranslationsFrom(dirname(__DIR__, 1).'/Translations', 'helpDesk');
        $this->publishes([
            dirname(__DIR__, 1).'/Translations' => resource_path('lang/vendor/helpDesk'),
        ]);
    }
    
    public function boot()
    {
        if (!Schema::hasTable('migrations') || !Schema::hasTable('users')) {
            // Database isn't installed yet.
            return;
        }
    }
}
