<?php

namespace App\Observers;

use App\Orderproduct;
use Illuminate\Support\Facades\Cache;

class OrderproductObserver
{

    /**
     * Handle the orderproduct "created" event.
     *
     * @param Orderproduct $orderproduct
     * @return void
     */
    public function created(Orderproduct $orderproduct)
    {
    }

    /**
     * Handle the orderproduct "updated" event.
     *
     * @param Orderproduct $orderproduct
     * @return void
     */
    public function updated(Orderproduct $orderproduct)
    {
        //
    }

    /**
     * Handle the orderproduct "deleted" event.
     *
     * @param Orderproduct $orderproduct
     * @return void
     */
    public function deleted(Orderproduct $orderproduct)
    {
    }

    /**
     * Handle the orderproduct "restored" event.
     *
     * @param Orderproduct $orderproduct
     * @return void
     */
    public function restored(Orderproduct $orderproduct)
    {
        //
    }

    /**
     * Handle the orderproduct "force deleted" event.
     *
     * @param Orderproduct $orderproduct
     * @return void
     */
    public function forceDeleted(Orderproduct $orderproduct)
    {
        //
    }

    public function saving(Orderproduct $orderproduct)
    {


    }

    public function saved(Orderproduct $orderproduct)
    {
        Cache::tags([
            'order_'.$orderproduct->order_id , 'orderproduct_'.$orderproduct->id ])->flush();
    }

}
