<?php

namespace App\Http\Controllers\Api;

use App\Classes\CouponSubmitter;
use App\Classes\Pricing\Alaa\AlaaInvoiceGenerator;
use App\Collection\OrderCollections;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\OrderproductController;
use App\Http\Requests\DonateRequest;
use App\Http\Requests\SubmitCouponRequest;
use App\Http\Resources\Coupon as CouponResource;
use App\Http\Resources\Invoice as InvoiceResource;
use App\Order;
use App\Orderproduct;
use App\Product;
use App\Repositories\CouponRepo;
use App\Traits\User\ResponseFormatter;
use App\User;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class OrderController extends Controller
{
    use ResponseFormatter;

    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware(['submitOrderCoupon', 'openOrder'], ['only' => ['submitCoupon', 'submitCouponV2'],]);
        $this->middleware('removeOrderCoupon', ['only' => ['removeCoupon'],]);
    }

    /**
     * Showing authentication step in the checkout process
     *
     * @param Request $request
     *
     * @return Response
     * @throws Exception
     */
    public function checkoutReview(Request $request)
    {
        $user = $request->user('api');

        $order = $user->getOpenOrder();

        $invoiceGenerator = new AlaaInvoiceGenerator();

        $invoiceInfo = $invoiceGenerator->generateOrderInvoice($order);
        unset($invoiceInfo['price']['payableByWallet']);

        return response($invoiceInfo);
    }

    /**
     * API Version 2
     *
     * @param Request $request
     *
     * @return ResponseFactory|JsonResponse|Response
     * @throws Exception
     */
    public function checkoutReviewV2(Request $request)
    {
        /** @var User $user */
        $user  = $request->user('api');
        $order = $user->getOpenOrder();

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
        $invoiceGenerator = new AlaaInvoiceGenerator();
        $invoiceInfo      = $invoiceGenerator->generateOrderInvoice($order);
        if (isset($coupon)) {
            $order->orderproducts->checkIncludedInCoupon($coupon);
        }
        $invoiceInfo = array_merge($invoiceInfo, [
            'coupon'            => $coupon,
            'orderHasDonate'    => $orderHasDonate,
            'redirectToGateway' => $this->getEncryptedUrl('zarinpal', 'android', $this->getEncryptedPostfix($user, $order->id)),
        ]);

        return (new InvoiceResource($invoiceInfo))->response();
    }

    /**
     * Showing payment step in checkout the process
     *
     * @param Request $request
     *
     * @return Response
     * @throws Exception
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
            'price'                       => $invoiceInfo['price'],
            'wallet'                      => $wallets,
            'couponInfo'                  => $coupon,
            'notIncludedProductsInCoupon' => $notIncludedProductsInCoupon,
            'orderHasDonate'              => $orderHasDonate,
        ]);
    }

    /**
     * Submits a coupon for the order
     *
     * @param SubmitCouponRequest  $request
     *
     * @param AlaaInvoiceGenerator $invoiceGenerator
     *
     * @return ResponseFactory|Response
     * @throws Exception
     */
    public function submitCoupon(SubmitCouponRequest $request, AlaaInvoiceGenerator $invoiceGenerator)
    {
        $coupon = CouponRepo::findCouponByCode($request->get('code'));
        if ($request->has('openOrder')) {
            $order = $request->get('openOrder');
        } else {
            $order = Order::Find($request->get('order_id'));
            if (!isset($order)) {
                return response($this->makeErrorResponse(Response::HTTP_BAD_REQUEST, 'Invalid order'));
            }
        }

        if (!isset($coupon)) {
            return response($this->makeErrorResponse(Response::HTTP_BAD_REQUEST, 'Invalid coupon'));
        }

        $couponValidationStatus = $coupon->validateCoupon();
        if ($couponValidationStatus != Coupon::COUPON_VALIDATION_STATUS_OK) {
            return response($this->makeErrorResponse(Response::HTTP_BAD_REQUEST, Coupon::COUPON_VALIDATION_INTERPRETER[$couponValidationStatus] ?? 'Coupon validation status is undetermined'));
        }

        $result = (new CouponSubmitter($order))->submit($coupon);
        if ($result === true) {
            Cache::tags([
                'order_' . $order->id . '_coupon',
                'order_' . $order->id . '_cost',
            ])->flush();
            $invoiceGenerator->generateOrderInvoice($order);
            return response( [
                $coupon,
                'message' => 'Coupon attached successfully',
            ]);
        }

        return response($this->makeErrorResponse(Response::HTTP_SERVICE_UNAVAILABLE, 'Database error'));
    }

    /** API Version 2
     *
     * @param SubmitCouponRequest  $request
     * @param AlaaInvoiceGenerator $invoiceGenerator
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function submitCouponV2(SubmitCouponRequest $request, AlaaInvoiceGenerator $invoiceGenerator)
    {
        $coupon = CouponRepo::findCouponByCode($request->get('code'));
        if ($request->has('openOrder')) {
            $order = $request->get('openOrder');
        } else {
            $order = Order::Find($request->get('order_id'));
            if (!isset($order)) {
                return response()->json($this->makeErrorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid order'));
            }
        }

        if (!isset($coupon)) {
            return response()->json($this->makeErrorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid coupon'));
        }

        $couponValidationStatus = $coupon->validateCoupon();
        if ($couponValidationStatus != Coupon::COUPON_VALIDATION_STATUS_OK) {
            return response()->json($this->makeErrorResponse($couponValidationStatus, Coupon::COUPON_VALIDATION_INTERPRETER[$couponValidationStatus] ?? 'Coupon validation status is undetermined'));
        }

        $result = (new CouponSubmitter($order))->submit($coupon);
        if ($result === true) {
            Cache::tags([
                'order_' . $order->id . '_coupon',
                'order_' . $order->id . '_cost',
            ])->flush();
            $invoiceGenerator->generateOrderInvoice($order);
            return (new CouponResource($coupon))->response();
        }

        return response()->json($this->makeErrorResponse(Response::HTTP_SERVICE_UNAVAILABLE, 'Error on attaching coupon to order'));
    }

    /**
     * @param Request $request
     *
     * @return ResponseFactory|Response
     */
    public function removeCoupon(Request $request)
    {
        if ($request->has('openOrder')) {
            $order = $request->get('openOrder');
        } else {
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
                    $resultText = 'Coupon detached successfully';
                } else {
                    $resultCode = Response::HTTP_SERVICE_UNAVAILABLE;
                    $resultText = 'Database error';
                }
            } else {
                $resultCode = Response::HTTP_BAD_REQUEST;
                $resultText = 'No coupon found for this order';
            }
        } else {
            $resultCode = Response::HTTP_BAD_REQUEST;
            $resultText = 'Unknown order';
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

        return response($response);
    }

    /**
     * Makes a donate request
     *
     * @param DonateRequest          $request
     * @param OrderproductController $orderproductController
     *
     * @return RedirectResponse
     */
    public function donateOrder(DonateRequest $request)
    {
        $user = $request->user('alaatv');
        if ($user === null) {
            abort(Response::HTTP_FORBIDDEN, 'Not authorized.');
        }
        $amount = $request->get('amount');
        /** @var OrderCollections $donateOrders */
        $donateOrders = $user->orders->where('orderstatus_id', config('constants.ORDER_STATUS_OPEN_DONATE'));
        if ($donateOrders->isNotEmpty()) {
            $donateOrder = $donateOrders->first();
        } else {
            $donateOrder = Order::create([
                'orderstatus_id'   => config('constants.ORDER_STATUS_OPEN_DONATE'),
                'paymentstatus_id' => config('constants.PAYMENT_STATUS_UNPAID'),
                'user_id'          => $user->id,
            ]);
        }

        $donateProduct = Product::FindOrFail(Product::CUSTOM_DONATE_PRODUCT);

        $oldOrderproducts = $donateOrder->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
            ->where('product_id', $donateProduct->id)
            ->get();

        if ($oldOrderproducts->isNotEmpty()) {
            $oldOrderproduct       = $oldOrderproducts->first();
            $oldOrderproduct->cost = $amount;
            $oldOrderproduct->update();
        } else {
            $donateOrderproduct = Orderproduct::Create([
                'order_id'            => $donateOrder->id,
                'product_id'          => $donateProduct->id,
                'cost'                => $amount,
                'orderproducttype_id' => config('constants.ORDER_PRODUCT_TYPE_DEFAULT'),
            ]);
        }

        $donateOrder                    = $donateOrder->fresh();
        $orderCost                      = $donateOrder->obtainOrderCost(true, false);
        $donateOrder->cost              = $orderCost['rawCostWithDiscount'];
        $donateOrder->costwithoutcoupon = $orderCost['rawCostWithoutDiscount'];
        $donateOrder->update();

        return redirect()->route('api.v1.payment.getEncryptedLink', ['order_id' => $donateOrder->id]);
    }

    /**
     * API Version 2
     *
     * @param DonateRequest $request
     *
     * @return array
     */
    public function donateOrderV2(DonateRequest $request)
    {
        $user = $request->user('alaatv');
        if ($user === null) {
            abort(Response::HTTP_FORBIDDEN, 'Not authorized.');
        }
        $amount = $request->get('amount');
        /** @var OrderCollections $donateOrders */
        $donateOrders = $user->orders->where('orderstatus_id', config('constants.ORDER_STATUS_OPEN_DONATE'));
        if ($donateOrders->isNotEmpty()) {
            $donateOrder = $donateOrders->first();
        } else {
            $donateOrder = Order::create([
                'orderstatus_id'   => config('constants.ORDER_STATUS_OPEN_DONATE'),
                'paymentstatus_id' => config('constants.PAYMENT_STATUS_UNPAID'),
                'user_id'          => $user->id,
            ]);
        }

        $donateProduct = Product::FindOrFail(Product::CUSTOM_DONATE_PRODUCT);

        $oldOrderproducts = $donateOrder->orderproducts(config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
            ->where('product_id', $donateProduct->id)
            ->get();

        if ($oldOrderproducts->isNotEmpty()) {
            $oldOrderproduct       = $oldOrderproducts->first();
            $oldOrderproduct->cost = $amount;
            $oldOrderproduct->update();
        } else {
            $donateOrderproduct = Orderproduct::Create([
                'order_id'            => $donateOrder->id,
                'product_id'          => $donateProduct->id,
                'cost'                => $amount,
                'orderproducttype_id' => config('constants.ORDER_PRODUCT_TYPE_DEFAULT'),
            ]);
        }

        $donateOrder                    = $donateOrder->fresh();
        $orderCost                      = $donateOrder->obtainOrderCost(true, false);
        $donateOrder->cost              = $orderCost['rawCostWithDiscount'];
        $donateOrder->costwithoutcoupon = $orderCost['rawCostWithoutDiscount'];
        $donateOrder->update();

        return [
            'data' => [
                'link' => route('api.v1.payment.getEncryptedLink', ['order_id' => $donateOrder->id]),
            ],
        ];
    }

    /**
     * @param User     $user
     *
     * @param int|null $orderId
     *
     * @return string
     */
    private function getEncryptedPostfix(User $user, $orderId): string
    {
        $toEncrypt = ['user_id' => $user->id,];

        if (isset($orderId)) {
            $toEncrypt = Arr::add($toEncrypt, 'order_id', $orderId);
        }

        return encrypt($toEncrypt);
    }

    /**
     * @param string $paymentMethod
     * @param string $device
     * @param string $encryptedPostfix
     *
     * @return string
     */
    private function getEncryptedUrl(string $paymentMethod, string $device, string $encryptedPostfix)
    {
        $parameters = [
            'paymentMethod'  => $paymentMethod,
            'device'         => $device,
            'encryptionData' => $encryptedPostfix,
        ];

        return URL::temporarySignedRoute(
            'redirectToPaymentRoute',
            3600,
            $parameters
        );
    }

}
