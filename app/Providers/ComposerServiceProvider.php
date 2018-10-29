<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('pages.search', 'App\Http\ViewComposers\ContentSearchComposer');

        View::composer('content.show', function ($view) {
            $sideBarMode = "closed";
            $view->with(compact('sideBarMode'));
        });
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
