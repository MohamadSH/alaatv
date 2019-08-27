<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use League\Flysystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Auth, Schema, Storage, Validator};
use App\{Content,
    Observers\EmployeeTimesheetObserver,
    Product,
    Contentset,
    Orderproduct,
    Traits\UserCommon,
    Observers\SetObserver,
    Adapter\AlaaSftpAdapter,
    Observers\ProductObserver,
    Observers\ContentObserver,
    Observers\OrderproductObserver};

class AppServiceProvider extends ServiceProvider
{
    use UserCommon;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Horizon::auth(function ($request) {
            return (Auth::check() && Auth::user()
                    ->hasRole("admin"));
        });
        Schema::defaultStringLength(191);

        Storage::extend('sftp', function ($app, $config) {
            return new Filesystem(new AlaaSftpAdapter($config));
        });

        Collection::macro('pushAt', function ($key, $item) {
            return $this->put($key, collect($this->get($key))->push($item));
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Content::observe(ContentObserver::class);
        Content::observe(EmployeeTimesheetObserver::class);
        Product::observe(ProductObserver::class);
        Contentset::observe(SetObserver::class);
        Orderproduct::observe(OrderproductObserver::class);
        $this->defineValidationRules();
    }

    private function defineValidationRules(): void
    {
        /**
         *  National code validation for registration form
         */
        Validator::extend('validate', function ($attribute, $value, $parameters, $validator) {
            if (strcmp($parameters[0], 'nationalCode') == 0) {
                return $this->validateNationalCode($value);
            }

            return true;
        });

        Validator::extend('activeProduct', function ($attribute, $value, $parameters, $validator) {
            return Product::findOrFail($value)->active;
        });
    }
}
