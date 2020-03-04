<?php

namespace App\Listeners;

use App\Events\UserRedirectedToPayment;
use Illuminate\Support\Facades\Cache;

class UserRedirectedToPaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserRedirectedToPaymentListener $event
     *
     * @return void
     */
    public function handle(UserRedirectedToPayment $event)
    {
        $user = $event->user;
        Cache::tags([
            'user_' . $user->id . '_closedOrders',
            'user_' . $user->id . '_transactions',
            'user_' . $user->id . '_instalments',
            'user_' . $user->id . '_totalBonNumber',
            'user_' . $user->id . '_validBons',
            'user_' . $user->id . '_hasBon',
            'user_'.$user->id.'_obtainPrice',
            'userAsset_'.$user->id,
        ])->flush();

        if (isset($event->order)) {
            Cache::tags('order_' . $event->order->id)->flush();
        }

        if (isset($event->transaction)) {
            Cache::tags('transaction_' . $event->transaction->id)->flush();
        }
    }
}
