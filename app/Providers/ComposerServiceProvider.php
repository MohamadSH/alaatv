<?php

namespace App\Providers;

use App\Block;
use App\Bon;
use App\Classes\Format\webBlockCollectionFormatter;
use App\Classes\Format\webSetCollectionFormatter;
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

        /**
         *  lessons
         */
        View::composer([
                           'pages.dashboard1',
                           'partials.sidebar',
                       ], function ($view) {
            $sections = (new webBlockCollectionFormatter(new webSetCollectionFormatter()))->format(Block::getBlocks());
            $view->with(compact('sections'));
        });
        view()->share('bonName', Bon::getAlaaBonDisplayName());
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
