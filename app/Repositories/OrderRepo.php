<?php


namespace App\Repositories;


use App\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderRepo
{
    public static function createOpenOrder(int $userId): Order
    {
        return Order::create([
            'user_id'          => $userId,
            'orderstatus_id'   => config('constants.ORDER_STATUS_OPEN'),
            'paymentstatus_id' => config('constants.PAYMENT_STATUS_UNPAID'),
        ]);
    }

    public static function orderStatusFilter(Builder $orders, $orderStatusesId)
    {
        return $orders->whereIn('orderstatus_id', $orderStatusesId);
    }

    public static function UserMajorFilter(Builder $orders, $majorsId)
    {
        if (in_array(0, $majorsId)) {
            $orders = $orders->whereHas('user', function ($q) use ($majorsId) {
                /** @var Builder $q */
                $q->whereDoesntHave("major");
            });
        } else {
            $orders = $orders->whereHas('user', function ($q) use ($majorsId) {
                /** @var Builder $q */
                $q->whereIn("major_id", $majorsId);
            });
        }

        return $orders;
    }

    public static function paymentStatusFilter(Builder $orders, $paymentStatusesId)
    {
        return $orders->whereIn('paymentstatus_id', $paymentStatusesId);
    }
}
