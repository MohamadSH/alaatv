<?php

namespace App\Http\Controllers\Api;

use App\Collection\OrderCollections;
use App\Http\Controllers\Web\OrderproductController;
use App\Http\Requests\DonateRequest;
use App\Order;
use App\Coupon;
use App\Orderproduct;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\SubmitCouponRequest;
use App\Classes\Pricing\Alaa\AlaaInvoiceGenerator;

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
     * @param  Request  $request
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
     * @param  Request  $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function checkoutPayment(Request $request)
    {
        $user = $request->user('api');
        /** @var Order $order */
        $order = $user->getOpenOrder();

        $wallets        = optional($order->user)->getWallet();
        $orderHasDonate = $order->hasTheseProducts([
            Product::CUSTOM_DONATE_PRODUCT,
            Product::DONATE_PRODUCT_5_HEZAR,
        ]);

        $coupon                 = $order->coupon;
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
        $coupon                      = $order->coupon_info;
        $notIncludedProductsInCoupon = $order->reviewCouponProducts();

        $invoiceGenerator = new AlaaInvoiceGenerator();
        $invoiceInfo      = $invoiceGenerator->generateOrderInvoice($order);

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
     * @param  \App\Http\Requests\SubmitCouponRequest  $request
     *
     * @param  AlaaInvoiceGenerator                    $invoiceGenerator
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function submitCoupon(SubmitCouponRequest $request, AlaaInvoiceGenerator $invoiceGenerator)
    {
        $coupon = Coupon::code($request->get('code'))
            ->first();
        if ($request->has('openOrder')) {
            $order = $request->get('openOrder');
        }
        else {
            $order_id = $request->get('order_id');
            $order    = Order::Find($order_id);
        }

        list($resultCode, $resultText) = $this->processCoupon($invoiceGenerator, $coupon, $order);

        if ($resultCode == Response::HTTP_OK) {
            $response = [
                $coupon,
                'message' => 'Coupon attached successfully',
            ];
        }
        else {
            $response = [
                'error' => [
                    'code'    => $resultCode ?? $resultCode,
                    'message' => $resultText ?? $resultText,
                ],
            ];
        }

        Cache::tags('order')->flush();

        return response($response, Response::HTTP_OK);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function removeCoupon(Request $request)
    {
        if ($request->has('openOrder')) {
            $order = $request->get('openOrder');
        }
        else {
            $order_id = $request->get('order_id');
            $order    = Order::Find($order_id);
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
                }
                else {
                    $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                    $resultText = "Database error";
                }
            }
            else {
                $resultCode = Response::HTTP_BAD_REQUEST;
                $resultText = "No coupon found for this order";
            }
        }
        else {
            $resultCode = Response::HTTP_BAD_REQUEST;
            $resultText = "Unknown order";
        }

        if ($resultCode == Response::HTTP_OK) {
            $response = [
                'message' => 'Coupon detached successfully',
            ];
        }
        else {
            $response = [
                'error' => [
                    'code'    => $resultCode ?? $resultCode,
                    'message' => $resultText ?? $resultText,
                ],
            ];
        }

        return response($response, Response::HTTP_OK);
    }

    /**
     * Makes a donate request
     *
     * @param  \App\Http\Requests\DonateRequest  $request
     * @param  OrderproductController            $orderproductController
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function donateOrder(DonateRequest $request)
    {
        $user = $request->user('alaatv');
        if ($user === null) {
            abort(403, 'Not authorized.');
        }
        $amount       = $request->get('amount');
        /** @var OrderCollections $donateOrders */
        $donateOrders = $user->orders->where('orderstatus_id', config('constants.ORDER_STATUS_OPEN_DONATE'));
        if ($donateOrders->isNotEmpty()) {
            $donateOrder = $donateOrders->first();
        } else {
            $donateOrder = Order::create([
                'orderstatus_id'      =>  config('constants.ORDER_STATUS_OPEN_DONATE'),
                'paymentstatus_id'    =>  config('constants.PAYMENT_STATUS_UNPAID'),
                'user_id'             =>  $user->id,
            ]);
        }

        $donateProduct        = Product::FindOrFail(Product::CUSTOM_DONATE_PRODUCT);

        $oldOrderproducts = $donateOrder->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
            ->where('product_id', $donateProduct->id)
            ->get();

        if($oldOrderproducts->isNotEmpty())
        {
            $oldOrderproduct = $oldOrderproducts->first();
            $oldOrderproduct->cost = $amount;
            $oldOrderproduct->update();
        }else{
            $donateOrderproduct = Orderproduct::Create([
                'order_id'  =>  $donateOrder->id,
                'product_id' => $donateProduct->id,
                'cost'  =>  $amount,
                'orderproducttype_id'  =>  config('constants.ORDER_PRODUCT_TYPE_DEFAULT'),
            ]);
        }

        $donateOrder                    = $donateOrder->fresh();
        $orderCost                      = $donateOrder->obtainOrderCost(true, false);
        $donateOrder->cost              = $orderCost['rawCostWithDiscount'];
        $donateOrder->costwithoutcoupon = $orderCost['rawCostWithoutDiscount'];
        $donateOrder->update();

        return redirect()->route('api.payment.getEncryptedLink' , ['order_id'  =>  $donateOrder->id]);
    }

    /**
     * @param  \App\Classes\Pricing\Alaa\AlaaInvoiceGenerator  $invoiceGenerator
     * @param                                                  $coupon
     * @param                                                  $order
     *
     * @return array
     * @throws \Exception
     */
    private function processCoupon(AlaaInvoiceGenerator $invoiceGenerator, $coupon, $order): array
    {
        if (!isset($coupon) || !isset($order)) {
            $resultText = isset($coupon) ? 'Unknown order' : 'Coupon code is wrong';

            return [Response::HTTP_BAD_REQUEST, $resultText];
        }

        /** @var Coupon $coupon */
        $couponValidationStatus = $coupon->validateCoupon();
        if ($couponValidationStatus == Coupon::COUPON_VALIDATION_STATUS_OK) {
            list($resultCode, $resultText) = $this->handleValidCoupon($invoiceGenerator, $coupon, $order);
        }
        else {
            list($resultText, $resultCode) = $this->handleInvalidCoupon($couponValidationStatus);
        }

        return [$resultCode, $resultText];
    }

    /**
     * @param  \App\Classes\Pricing\Alaa\AlaaInvoiceGenerator  $invoiceGenerator
     * @param                                                  $coupon
     * @param                                                  $order
     *
     * @return array
     * @throws \Exception
     */
    private function handleValidCoupon(AlaaInvoiceGenerator $invoiceGenerator, $coupon, $order): array
    {
        $oldCoupon = $order->coupon;
        if (!isset($oldCoupon)) {
            $coupon->usageNumber = $coupon->usageNumber + 1;
            if (!$coupon->update()) {
                return $this->databaseError();
            }
            $order->coupon_id = $coupon->id;
            if ($coupon->discounttype_id == config('constants.DISCOUNT_TYPE_COST')) {
                $order->couponDiscount       = 0;
                $order->couponDiscountAmount = (int) $coupon->discount;
            }
            else {
                $order->couponDiscount       = $coupon->discount;
                $order->couponDiscountAmount = 0;
            }
            if (!$order->updateWithoutTimestamp()) {
                $coupon->usageNumber = $coupon->usageNumber - 1;
                $coupon->update();

                return $this->databaseError();
            }

            return [Response::HTTP_OK, 'Coupon attached successfully'];
        }
        $flag = ($oldCoupon->usageNumber > 0);

        if ($oldCoupon->id == $coupon->id) {
            return [Response::HTTP_BAD_REQUEST, 'This coupon is already attached to the order'];
        }

        if ($flag) {
            $oldCoupon->usageNumber = $oldCoupon->usageNumber - 1;
        }
        if (!$oldCoupon->update()) {
            return $this->databaseError();
        }
        $coupon->usageNumber = $coupon->usageNumber + 1;
        if (!$coupon->update()) {
            $oldCoupon->usageNumber = $oldCoupon->usageNumber + 1;
            $oldCoupon->update();

            return $this->databaseError();
        }
        $order->coupon_id = $coupon->id;
        if ($coupon->discounttype_id == config('constants.DISCOUNT_TYPE_COST')) {
            $order->couponDiscount       = 0;
            $order->couponDiscountAmount = (int) $coupon->discount;
        }
        else {
            $order->couponDiscount       = $coupon->discount;
            $order->couponDiscountAmount = 0;
        }
        if (!$order->updateWithoutTimestamp()) {
            $oldCoupon->usageNumber = $oldCoupon->usageNumber + 1;
            $oldCoupon->update();
            $coupon->usageNumber = $coupon->usageNumber - 1;
            $coupon->update();

            return $this->databaseError();
        }
        $invoiceInfo = $invoiceGenerator->generateOrderInvoice($order);

        return [Response::HTTP_OK, 'Coupon attached successfully'];
    }

    /**
     * @return array
     */
    private function databaseError(): array
    {
        return [Response::HTTP_SERVICE_UNAVAILABLE, 'Database error'];
    }

    /**
     * @param  int  $couponValidationStatus
     *
     * @return array
     */
    private function handleInvalidCoupon(int $couponValidationStatus): array
    {
        $mapper     = [
            Coupon::COUPON_VALIDATION_STATUS_DISABLED             => 'Coupon is disabled',
            Coupon::COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED => 'Coupon number is finished',
            Coupon::COUPON_VALIDATION_STATUS_EXPIRED              => 'Coupon is expired',
            Coupon::COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN => 'Coupon usage period has not started',
        ];
        $resultText = $mapper[$couponValidationStatus] ?? 'Coupon validation status is undetermined';

        return [$resultText, Response::HTTP_BAD_REQUEST];
    }
}
