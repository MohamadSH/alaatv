<?php

namespace App\Observers;

use App\Orderproduct;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class OrderproductObserver
{
    /**
     * Handle the orderproduct "created" event.
     *
     * @param  \App\Orderproduct  $orderproduct
     * @return void
     */
    public function created(Orderproduct $orderproduct)
    {
        Log::debug('in orderproductobserver craeted');
    }

    /**
     * Handle the orderproduct "updated" event.
     *
     * @param  \App\Orderproduct  $orderproduct
     * @return void
     */
    public function updated(Orderproduct $orderproduct)
    {
        //
    }

    /**
     * Handle the orderproduct "deleted" event.
     *
     * @param  \App\Orderproduct  $orderproduct
     * @return void
     */
    public function deleted(Orderproduct $orderproduct)
    {
        Artisan::call('cache:clear');
    }

    /**
     * Handle the orderproduct "restored" event.
     *
     * @param  \App\Orderproduct  $orderproduct
     * @return void
     */
    public function restored(Orderproduct $orderproduct)
    {
        //
    }

    /**
     * Handle the orderproduct "force deleted" event.
     *
     * @param  \App\Orderproduct  $orderproduct
     * @return void
     */
    public function forceDeleted(Orderproduct $orderproduct)
    {
        //
    }

    public function saved(Orderproduct $orderproduct)
    {
        Log::debug('in orderproductobserver saved');
        Artisan::call('cache:clear');
    }

}
