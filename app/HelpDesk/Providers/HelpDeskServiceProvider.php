<?php

namespace App\HelpDesk\Providers;

use Illuminate\Support\ServiceProvider;

class HelpDeskServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'helpDesk');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        
    }
    
    public function boot()
    {
        //
    }
}
