<?php

namespace App\Providers;

use App\Classes\Repository\ContentRepository;
use App\Classes\Repository\ContentRepositoryInterface;
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
        $this->app->bind('App\Classes\Format\BlockCollectionFormatter', 'App\Classes\Format\webBlockCollectionFormatter');
        $this->app->bind('App\Classes\Format\SetCollectionFormatter', 'App\Classes\Format\webSetCollectionFormatter');
        $this->app->bind(ContentRepositoryInterface::class, ContentRepository::class);
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
