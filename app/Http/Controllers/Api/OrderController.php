<?php

namespace App\Http\Controllers\Api;

use App\Classes\Pricing\Alaa\AlaaInvoiceGenerator;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitCouponRequest;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('SubmitOrderCoupon', ['only' => ['submitCoupon'],]);
        $this->middleware('RemoveOrderCoupon', ['only' => ['removeCoupon'],]);
    }

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
        unset($invoiceInfo['price']['payableByWallet']);
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

        $wallets = optional($order->user)->getWallet();
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
            "price"                       => $invoiceInfo['price'],
            "wallet"                      => $wallets,
            "couponInfo"                  => $coupon,
            "notIncludedProductsInCoupon" => $notIncludedProductsInCoupon,
            "orderHasDonate"              => $orderHasDonate,
        ], Response::HTTP_OK);
    }

    /**
     * Submits a coupon for the order
     *
     * @param \App\Http\Requests\SubmitCouponRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function submitCoupon(SubmitCouponRequest $request)
    {
        $coupon = Coupon::code($request->get('code'))->first();
        if ($request->has('openOrder')) {
            $order = $request->get('openOrder');
        } else {
            $order_id = $request->get('order_id');
            $order = Order::Find($order_id);
        }

        if (isset($coupon) && isset($order)) {


            /** @var Coupon $coupon */
            $couponValidationStatus = $coupon->validateCoupon();
            if ($couponValidationStatus == Coupon::COUPON_VALIDATION_STATUS_OK) {
                $oldCoupon = $order->coupon;
                if (isset($oldCoupon)) {
                    $flag = ($oldCoupon->usageNumber > 0);
                    if ($oldCoupon->id != $coupon->id) {
                        if ($flag)
                            $oldCoupon->usageNumber = $oldCoupon->usageNumber - 1;
                        if ($oldCoupon->update()) {
                            $coupon->usageNumber = $coupon->usageNumber + 1;
                            if ($coupon->update()) {
                                $order->coupon_id = $coupon->id;
                                if ($coupon->discounttype_id == config('constants.DISCOUNT_TYPE_COST')) {
                                    $order->couponDiscount = 0;
                                    $order->couponDiscountAmount = (int)$coupon->discount;
                                } else {
                                    $order->couponDiscount = $coupon->discount;
                                    $order->couponDiscountAmount = 0;
                                }
                                if ($order->updateWithoutTimestamp()) {
                                    $resultCode = Response::HTTP_OK;
                                    $resultText = 'Coupon attached successfully';
                                } else {
                                    $oldCoupon->usageNumber = $oldCoupon->usageNumber + 1;
                                    $oldCoupon->update();
                                    $coupon->usageNumber = $coupon->usageNumber - 1;
                                    $coupon->update();
                                    $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                                    $resultText = 'Database error';
                                }
                            } else {
                                $oldCoupon->usageNumber = $oldCoupon->usageNumber + 1;
                                $oldCoupon->update();
                                $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                                $resultText = 'Database error';
                            }
                        } else {
                            $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                            $resultText = 'Database error';
                        }
                    } else {
                        $resultCode = Response::HTTP_BAD_REQUEST;
                        $resultText = 'This coupon is already attached to the order';
                    }
                } else {
                    $coupon->usageNumber = $coupon->usageNumber + 1;
                    if ($coupon->update()) {
                        $order->coupon_id = $coupon->id;
                        if ($coupon->discounttype_id == config('constants.DISCOUNT_TYPE_COST')) {
                            $order->couponDiscount = 0;
                            $order->couponDiscountAmount = (int)$coupon->discount;
                        } else {
                            $order->couponDiscount = $coupon->discount;
                            $order->couponDiscountAmount = 0;
                        }
                        if ($order->updateWithoutTimestamp()) {
                            $resultText = 'Coupon attached successfully';
                            $resultCode = Response::HTTP_OK;
                        } else {
                            $coupon->usageNumber = $coupon->usageNumber - 1;
                            $coupon->update();
                            $resultText = 'Database error';
                            $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                        }
                    } else {
                        $resultText = 'Database error';
                        $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                    }
                }
            } else {
                switch ($couponValidationStatus) {
                    case Coupon::COUPON_VALIDATION_STATUS_DISABLED:
                        $resultText = 'Coupon is disabled';
                        break;
                    case Coupon::COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED:
                        $resultText = 'Coupon number is finished';
                        break;
                    case Coupon::COUPON_VALIDATION_STATUS_EXPIRED:
                        $resultText = 'Coupon is expired';
                        break;
                    case Coupon::COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN:
                        $resultText = 'Coupon usage period has not started';
                        break;
                    default:
                        $resultText = 'Coupon validation status is undetermined';
                        break;
                }
                $resultCode = Response::HTTP_BAD_REQUEST;
            }

        } else {
            $resultCode = Response::HTTP_BAD_REQUEST;
            if (!isset($coupon))
                $resultText = 'Coupon code is wrong';
            else
                $resultText = 'Unknown order';
        }

        if ($resultCode == Response::HTTP_OK)
            $response = [
                $coupon,
                'message' => 'Coupon attached successfully',
            ];
        else
            $response = [
                'error' => [
                    'code'    => $resultCode ?? $resultCode,
                    'message' => $resultText ?? $resultText,
                ],
            ];
        return response($response, Response::HTTP_OK);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function removeCoupon(Request $request)
    {
        if ($request->has('openOrder')) {
            $order = $request->get('openOrder');
        } else {
            $order_id = $request->get('order_id');
            $order = Order::Find($order_id);
        }

        if (isset($order)) {
            $coupon = $order->coupon;
            if (isset($coupon)) {
                $order->detachCoupon();
                if ($order->updateWithoutTimestamp()) {
                    $coupon->decreaseUseNumber();
                    $coupon->update();
                    $resultCode = Response::HTTP_OK;
                    $resultText = "Coupon detached successfully";
                } else {
                    $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                    $resultText = "Database error";
                }
            } else {
                $resultCode = Response::HTTP_BAD_REQUEST;
                $resultText = "No coupon found for this order";
            }
        } else {
            $resultCode = Response::HTTP_BAD_REQUEST;
            $resultText = "Unknown order";
        }

        if ($resultCode == Response::HTTP_OK) {
            $response = [
                'message' => 'Coupon detached successfully',
            ];
        } else {
            $response = [
                'error' => [
                    'code'    => $resultCode ?? $resultCode,
                    'message' => $resultText ?? $resultText,
                ],
            ];
        }

        return response($response, Response::HTTP_OK);
    }
}
