<?php

namespace App\Providers;


use App\{Adapter\AlaaSftpAdapter,
    Content,
    Observers\ContentObserver,
    Observers\ProductObserver,
    Product,
    Traits\UserCommon};
use Illuminate\Support\Facades\{Auth, Schema, Storage, Validator};
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use League\Flysystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    use UserCommon;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Content::observe(ContentObserver::class);
        Product::observe(ProductObserver::class);

        Horizon::auth(function ($request) {
            if (Auth::check() && Auth::user()->hasRole("admin")) {
                return true;
            } else {
                return false;
            }
        });
        Schema::defaultStringLength(191);

        Storage::extend('sftp', function ($app, $config) {
            return new Filesystem(new AlaaSftpAdapter($config));
        });

        /**
         *  National code validation for registration form
         */
        Validator::extend('validate', function ($attribute, $value, $parameters, $validator) {
            if (strcmp($parameters[0], "nationalCode") == 0) {
                $flag = $this->validateNationalCode($value);
                return $flag;
            }
            return true;

        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
