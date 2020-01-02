<?php

namespace App\Providers;

use App\{Adapter\AlaaSftpAdapter,
    Block,
    Content,
    Contentset,
    Coupon,
    Employeetimesheet,
    Observers\BlockObserver,
    Observers\ContentObserver,
    Observers\CouponObserver,
    Observers\EmployeetimesheetObserver,
    Observers\OrderproductObserver,
    Observers\ProductObserver,
    Observers\SetObserver,
    Observers\SlideshowObserver,
    Observers\TransactionObserver,
    Observers\UserObserver,
    Orderproduct,
    Product,
    Slideshow,
    Traits\UserCommon,
    Transaction,
    User};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Auth, Schema, Storage, Validator};
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use League\Flysystem\Filesystem;

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
                    ->hasRole('admin'));
        });
        Schema::defaultStringLength(191);

        Storage::extend('sftp', static function ($app, $config) {
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
        Employeetimesheet::observe(EmployeetimesheetObserver::class);
        Product::observe(ProductObserver::class);
        Contentset::observe(SetObserver::class);
        Orderproduct::observe(OrderproductObserver::class);
        Transaction::observe(TransactionObserver::class);
        User::observe(UserObserver::class);
        Slideshow::observe(SlideshowObserver::class);
        Block::observe(BlockObserver::class);
        Coupon::observe(CouponObserver::class);
        $this->defineValidationRules();
//        Resource::withoutWrapping();
    }

    private function defineValidationRules(): void
    {
        /**
         *  National code validation for registration form
         */
        Validator::extend('validate', function ($attribute, $value, $parameters, $validator) {
            if (strcmp($parameters[0], 'nationalCode') === 0) {
                return $this->validateNationalCode($value);
            }

            return true;
        });

        Validator::extend('activeProduct', function ($attribute, $value, $parameters, $validator) {
            return Product::findOrFail($value)->active;
        });
    }
}
