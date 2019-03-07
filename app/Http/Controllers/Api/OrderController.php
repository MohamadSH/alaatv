<?php

namespace App\Http\Controllers\Api;

use App\Classes\Pricing\Alaa\AlaaInvoiceGenerator;
use App\Coupon;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class OrderController extends Controller
{

    /**
     * Showing authentication step in the checkout process
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function checkoutReview(Request $request)
    {
        $user = $request->user('api');

        $order = $user->getOpenOrder();

        $invoiceGenerator = new AlaaInvoiceGenerator();

        $invoiceInfo = $invoiceGenerator->generateOrderInvoice($order);

        return response($invoiceInfo, Response::HTTP_OK);
    }

    /**
     * Showing payment step in checkout the process
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function checkoutPayment(Request $request)
    {
        $user = $request->user('api');
        /** @var Order $order */
        $order = $user->getOpenOrder();

        $credit = optional($order->user)->getTotalWalletBalance();
        $orderHasDonate = $order->hasTheseProducts([
            Product::CUSTOM_DONATE_PRODUCT,
            Product::DONATE_PRODUCT_5_HEZAR,
        ]);

        $coupon = $order->coupon;
        $couponValidationStatus = optional($coupon)->validateCoupon();
        if (in_array($couponValidationStatus, [
            Coupon::COUPON_VALIDATION_STATUS_DISABLED,
            Coupon::COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN,
            Coupon::COUPON_VALIDATION_STATUS_EXPIRED,
        ])) {
            $order->detachCoupon();
            if ($order->updateWithoutTimestamp()) {
                $coupon->decreaseUseNumber();
                $coupon->update();
            }

            $order = $order->fresh();
        }
        $coupon = $order->coupon_info;
        $notIncludedProductsInCoupon = $order->reviewCouponProducts();

        $invoiceGenerator = new AlaaInvoiceGenerator();
        $invoiceInfo = $invoiceGenerator->generateOrderInvoice($order);

        return response([
            "invoiceInfo"                 => $invoiceInfo,
            "credit"                      => $credit,
            "couponInfo"                  => $coupon,
            "notIncludedProductsInCoupon" => $notIncludedProductsInCoupon,
            "orderHasDonate"              => $orderHasDonate,
        ], Response::HTTP_OK);
    }
}
