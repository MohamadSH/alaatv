<?php

namespace App\Providers;

use App\Block;
use App\Bon;
use App\Classes\Format\webBlockCollectionFormatter;
use App\Classes\Format\webSetCollectionFormatter;
use Illuminate\Support\Facades\Request;
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

        View::composer([
            'content.show',
            'pages.product-search',
            'product.show',
            'pages.content-search',
            'pages.shop',
            'order.checkout.review',
            'order.checkout.payment',
            'user.dashboard',
        ], function ($view) {
            $closedSideBar = true;
            $view->with(compact('closedSideBar'));
        });


        View::composer('partials.header1', 'App\Http\ViewComposers\HeaderComposer');

        /**
         *  lessons
         */
        View::composer([
//            'pages.dashboard1',
'partials.sidebar',
        ], function ($view) {
            $sections = (new webBlockCollectionFormatter(new webSetCollectionFormatter()))->format(Block::getMainBlocks());
//            $sections = collect();
//            dd($sections);
            $view->with(compact('sections'));
        });
        view()->share('bonName', Bon::getAlaaBonDisplayName());
        view()->share('userIpAddress', Request::ip());

        View::composer([
            'product.partials.showChildren',
        ], function ($view) {
            $colors = [
                '1' => 'm-switch--primary',
                '2' => 'm-switch--warning',
                '3' => 'm-switch--accent',
                '4' => 'm-switch--success',
                '5' => 'm-switch--brand',
                '6' => 'm-switch--info',
                '7' => 'm-switch--metal',
                '8' => 'm-switch--danger',
            ];
            $view->with(compact('colors'));
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
