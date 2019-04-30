<?php

namespace App\PaymentModule\Gateways\Behpardakht;

use Illuminate\Support\ServiceProvider;

class BehpardakhtServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'behpardakht');
    }

    public function boot()
    {

    }
}