<?php

namespace App\PaymentModule\Repositories;

use App\Order;
use Carbon\Carbon;

class OrdersRepo
{
    public static function closeOrder(int $id)
    {
        return Order::where('id', $id)
            ->update([
                'orderstatus_id' => config('constants.ORDER_STATUS_CLOSED'),
                'completed_at'   => Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran')
            ]);
    }
}
