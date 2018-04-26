<?php

namespace App\Providers;

use App\Broadcasting\MedianaChannel;
use App\Classes\sms\MedianaClient;
use Illuminate\Support\ServiceProvider;

use GuzzleHttp\Client as HttpClient;
class MedianaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(MedianaChannel::class)
            ->needs(MedianaClient::class)
            ->give(function (){
                $config = $this->app['config']['services.medianaSMS.normal'];

                return new MedianaClient(
                    new HttpClient,
                    $config['userName'],
                    $config['password'],
                    $config['from'],
                    $config['url']
                );
            });
    }

}
