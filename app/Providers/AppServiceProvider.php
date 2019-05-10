<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use League\Flysystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Auth, Schema, Storage, Validator};
use App\{Content,
    Product,
    Contentset,
    Traits\UserCommon,
    Observers\SetObserver,
    Adapter\AlaaSftpAdapter,
    Observers\ProductObserver,
    Observers\ContentObserver};

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
        Content::observe(ContentObserver::class);
        Product::observe(ProductObserver::class);
        Contentset::observe(SetObserver::class);
        
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
        $this->defineValidationRules();
    }
    
    private function defineValidationRules(): void
    {
        /**
         *  National code validation for registration form
         */
        Validator::extend('validate', function ($attribute, $value, $parameters, $validator) {
            if (strcmp($parameters[0], "nationalCode") == 0) {
                return $this->validateNationalCode($value);
            }
            
            return true;
        });
        
        Validator::extend('activeProduct', function ($attribute, $value, $parameters, $validator) {
            return Product::findOrFail($value)->active;
        });
    }
}
