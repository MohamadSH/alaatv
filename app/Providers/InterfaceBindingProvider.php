<?php

namespace App\Providers;

use App\Classes\Format\BlockCollectionFormatter;
use App\Classes\Format\SetCollectionFormatter;
use App\Classes\Format\webBlockCollectionFormatter;
use App\Classes\Format\webSetCollectionFormatter;
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
        $this->app->bind('App\Classes\Format\BlockCollectionFormatter',
            'App\Classes\Format\webBlockCollectionFormatter');
        $this->app->bind('App\Classes\Format\SetCollectionFormatter', 'App\Classes\Format\webSetCollectionFormatter');
        $this->app->bind(ContentRepositoryInterface::class, ContentRepository::class);

        $this->app->bind(BlockCollectionFormatter::class, webBlockCollectionFormatter::class);
        $this->app->bind(SetCollectionFormatter::class, webSetCollectionFormatter::class);
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
