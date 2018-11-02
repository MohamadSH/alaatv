<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InterfaceBindingProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            'App\Classes\Format\BlockCollectionFormatter',
            'App\Classes\Format\webBlockCollectionFormatter'
        );
        $this->app->bind(
            'App\Classes\Format\SetCollectionFormatter',
            'App\Classes\Format\webSetCollectionFormatter'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
