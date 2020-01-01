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
    public function handleValidCoupon(AlaaInvoiceGenerator $invoiceGenerator, Coupon $coupon): bool
    {
        $oldCoupon = $this->order->coupon;
        if (!isset($oldCoupon)) {
            $coupon->usageNumber = $coupon->usageNumber + 1;
            if (!$coupon->update()) {
                return false;
            }
            $this->order->coupon_id = $coupon->id;
            if ($coupon->discounttype_id == config('constants.DISCOUNT_TYPE_COST')) {
                $this->order->couponDiscount       = 0;
                $this->order->couponDiscountAmount = (int)$coupon->discount;
            } else {
                $this->order->couponDiscount       = $coupon->discount;
                $this->order->couponDiscountAmount = 0;
            }
            if (!$this->order->updateWithoutTimestamp()) {
                $coupon->usageNumber = $coupon->usageNumber - 1;
                $coupon->update();

                return false;
            }

            return true;
        }
        $flag = ($oldCoupon->usageNumber > 0);

        if ($oldCoupon->id == $coupon->id) {
            return true;
        }

        if ($flag) {
            $oldCoupon->usageNumber = $oldCoupon->usageNumber - 1;
        }
        if (!$oldCoupon->update()) {
            return false;
        }
        $coupon->usageNumber = $coupon->usageNumber + 1;
        if (!$coupon->update()) {
            $oldCoupon->usageNumber = $oldCoupon->usageNumber + 1;
            $oldCoupon->update();

            return false;
        }
        $this->order->coupon_id = $coupon->id;
        if ($coupon->discounttype_id == config('constants.DISCOUNT_TYPE_COST')) {
            $this->order->couponDiscount       = 0;
            $this->order->couponDiscountAmount = (int)$coupon->discount;
        } else {
            $this->order->couponDiscount       = $coupon->discount;
            $this->order->couponDiscountAmount = 0;
        }
        if (!$this->order->updateWithoutTimestamp()) {
            $oldCoupon->usageNumber = $oldCoupon->usageNumber + 1;
            $oldCoupon->update();
            $coupon->usageNumber = $coupon->usageNumber - 1;
            $coupon->update();

            return false;
        }
        $invoiceGenerator->generateOrderInvoice($this->order);

        return true;
    }
}
