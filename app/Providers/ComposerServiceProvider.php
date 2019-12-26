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
        View::composer('pages.content-search', 'App\Http\ViewComposers\ContentSearchComposer');

        View::composer([
            'content.show',
            'pages.product-search',
            'product.show',
            'product.customShow.raheAbrisham',
            'pages.content-search',
            'pages.shop',
            'order.checkout.review',
            'order.checkout.payment',
            'user.dashboard',
            'product.landing.landing7',
            'product.landing.landing8',
            'product.landing.landing9',
            'product.landing.landing10',
            'product.landing.landing11',
            'pages.dashboard1',
            'user.salesReport',
            'pages.sharifLanding',
            'pages.liveView',
            'set.show',
            'user.completeRegister2'
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

        View::composer([
            '*'
        ], function ($view){
            $view->with('bonName',Bon::getAlaaBonDisplayName());
            $view->with('userIpAddress', Request::ip());
            $view->with('wSetting',optional(alaaSetting())->setting);
            $view->with('wLogoUrl',optional(alaaSetting())->site_logo_url);
            $view->with('setting',alaaSetting());
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
