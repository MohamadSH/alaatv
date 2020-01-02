<?php

namespace App\HelpDesk\Providers;

use App\HelpDesk\Models\Ticket;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class HelpDeskServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__, 1) . '/config.php', 'helpDesk');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__, 1) . '/Database/Migrations');

        $this->loadTranslationsFrom(dirname(__DIR__, 1) . '/Translations', 'helpDesk');

        $this->publishes([
            dirname(__DIR__, 1) . '/Translations' => resource_path('lang/vendor/helpDesk'),
        ]);

        $this->publishes([
            dirname(__DIR__, 1) . '/config.php' => config_path('helpDesk.php'),
        ], 'config');

        $this->loadViewsFrom(dirname(__DIR__, 1) . '/views', 'helpDesk');

        $this->loadRoutesFrom(dirname(__DIR__, 1) . '/route/web.php');
        $this->loadRoutesFrom(dirname(__DIR__, 1) . '/route/api.php');

        $this->modelBinding();
    }

    protected function modelBinding()
    {
        Route::bind('t', function ($value) {
            $key = 'ticket:' . $value;

            return Cache::remember($key, config('constants.CACHE_60'), function () use ($value) {
                return Ticket::where('id', $value)->first() ?: abort(Response::HTTP_NOT_FOUND);
            });
        });
    }

}
