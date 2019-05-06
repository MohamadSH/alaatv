<?php

namespace App\PaymentModule\Repositories;

use App\Order;

class OrdersRepo
{
    public static function closeOrder(int $id)
    {
        return Order::where('id', $id)
            ->update([
                'orderstatus_id' => config('constants.ORDER_STATUS_CLOSED'),
            ]);
    }
}