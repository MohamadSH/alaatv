<?php

namespace App\Listeners;

use App\Events\FillTmpShareOfOrder;

class FillTmpShareOfOrderListener
{
    /**
     * Handle the event.
     *
     * @param FillTmpShareOfOrder $event
     *
     * @return void
     */
    public function handle(FillTmpShareOfOrder $event)
    {
        $orderproducts = $event->order->orderproducts;
        foreach ($orderproducts as $orderproduct) {
            $orderproduct->setShareCost();
        }
    }
}
