<?php


namespace App\Classes;


use App\Classes\Pricing\Alaa\AlaaInvoiceGenerator;
use App\Coupon;
use App\Order;

class CouponSubmitter
{

    private $order;

    /**
     * CouponSubmitter constructor.
     *
     * @param $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param AlaaInvoiceGenerator $invoiceGenerator
     * @param Coupon               $coupon
     *
     * @return bool
     * @throws \Exception
     */
    public function submit(Coupon $coupon): bool
    {
        $oldCoupon = $this->order->coupon;
        if (!isset($oldCoupon)){
            $coupon->increaseUseNumber()->update();
            $orderUpdateResult = $this->order->attachCoupon($coupon)->updateWithoutTimestamp();
            if ($orderUpdateResult) {
                return true;
            }
            $coupon->decreaseUseNumber()->update();
            return false;
        }

        if ($oldCoupon->id == $coupon->id){
            return true;
        }

        $oldCoupon->decreaseUseNumber()->update();
        $coupon->increaseUseNumber()->update();
        $orderUpdateResult = $this->order->attachCoupon($coupon)->updateWithoutTimestamp();
        if ($orderUpdateResult) {
            return true;
        }

        $oldCoupon->increaseUseNumber()->update();
        $coupon->decreaseUseNumber()->update();

        return true;
    }
}
