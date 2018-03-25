<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/27/2016
 * Time: 3:52 PM
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        require base_path().'/app/Helpers/Helper.php';
    }
}