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
    }
    
    public function boot()
    {
        if (!Schema::hasTable('migrations')) {
            // Database isn't installed yet.
            return;
        }
    }
}
