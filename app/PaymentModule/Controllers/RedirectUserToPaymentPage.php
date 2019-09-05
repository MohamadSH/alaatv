<?php

namespace App\PaymentModule\Controllers;

use App\Product;
use Cache;
use App\User;
use App\Order;
use App\Transaction;
use AlaaTV\Gateways\Money;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\PaymentModule\Responses;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use AlaaTV\Gateways\PaymentDriver;
use App\Repositories\TransactionRepo;
use App\Repositories\TransactionGatewayRepo;
use App\PaymentModule\Repositories\OrdersRepo;
use App\Http\Controllers\Web\TransactionController;
use App\Classes\Payment\RefinementRequest\RefinementLauncher;
use Illuminate\Support\Collection;

class RedirectUserToPaymentPage extends Controller
{
    /**
     * redirect the user to online payment page
     *
     * @param  Request  $request
     * @param  string   $paymentMethod
     * @param  string   $device
     *
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function __invoke(string $paymentMethod, string $device, Request $request)
    {
        Cache::tags('bon')->flush();
        Cache::tags('order')->flush();
        Cache::tags('orderproduct')->flush();

        $data = $this->getRefinementData($request->all(), $request->user());

        if ($data['statusCode'] != Response::HTTP_OK) {
            $this->sendErrorResponse($data['message'] ?: '', $data['statusCode'] ?: Response::HTTP_SERVICE_UNAVAILABLE );
        }

        /** @var User $user */
        $user = $data['user'];
        /** @var Order $order */
        $order = $data['order'];
        /** @var Order $order */
        $orderUniqueId = $data['orderUniqueId'];
        /** @var Money $cost */
        $cost = Money::fromTomans((int) $data['cost']);
        /** @var Transaction $transaction */
        $transaction = $data['transaction'];

        $customerDescription = $request->get('customerDescription');

        $this->shouldGoToOfflinePayment($cost->rials())
            ->thenRespondWith([[Responses::class, 'sendToOfflinePaymentProcess'], [$device, $order,$customerDescription]]);

        /** @var string $description */
        $description = $this->getTransactionDescription($data['description'] , $device, $user->mobile, $order);

        $paymentClient = PaymentDriver::select($paymentMethod);
        $url = $this->comeBackFromGateWayUrl($paymentMethod, $device);

        $authorityCode = nullable($paymentClient->generateAuthorityCode($url, $cost, $description, $orderUniqueId))
            ->orFailWith([Responses::class, 'noResponseFromBankError'] );

        TransactionRepo::setAuthorityForTransaction($authorityCode, $transaction->id , $this->getGatewyId($paymentMethod), $description)
            ->orRespondWith([Responses::class, 'editTransactionError']);

        if ($this->shouldCloseOrder($order))
        {
            OrdersRepo::closeOrder($order->id, ['customerDescription' => $customerDescription]);
            $this->saveOrderInCookie($order);
        }

        return view("order.checkout.gatewayRedirect", ['authority' => $authorityCode, 'paymentMethod' => $paymentMethod]);
    }

    /**
     * @param $inputData
     * @param $user
     *
     * @return array
     */
    private function getRefinementData($inputData, $user): array
    {
        $inputData['transactionController'] = app(TransactionController::class);
        $inputData['user']                  = $user;

        return (new RefinementLauncher($inputData))->getData($inputData);
    }

    /**
     * @param string $msg
     * @param int $statusCode
     *
     * @return JsonResponse
     * @throws \ImanGhafoori\Terminator\TerminateException
     */
    private function sendErrorResponse(string $msg, int $statusCode)
    {
        respondWith()->json(['message' => $msg], $statusCode);
    }

    /**
     * @param string $description
     * @param string $device
     * @param              $mobile
     * @param Order|null $order
     *
     * @return string
     */
    private function getTransactionDescription(string $description ,string $device, $mobile, $order = null)
    {
        $description = '';
        if($device == 'web'){
            $description .= 'سایت آلاء - ';
        }elseif($device == 'android'){
            $description .= 'اپ اندروید آلاء - ';
        }
        $description .= $mobile.' - محصولات: ';

        if (is_null($order)) {
            return $description;
        }

        $order->orderproducts->load('product');

        foreach ($order->orderproducts as $orderProduct) {
            if (isset($orderProduct->product->id)) {
                $description .= $orderProduct->product->name.' , ';
            } else {
                $description .= 'یک محصول نامشخص , ';
            }
        }

        return $description;
    }

    /**
     * @param  int  $cost
     *
     * @return Boolean
     */
    private function shouldGoToOfflinePayment(int $cost)
    {
        return boolean($cost <= 0);
    }

    /**
     * @param  string  $paymentMethod
     * @param  string  $device
     *
     * @return string
     */
    private function comeBackFromGateWayUrl(string $paymentMethod, string $device)
    {
        return route('verifyOnlinePayment',
            ['paymentMethod' => $paymentMethod, 'device' => $device, '_token' => csrf_token()]);
    }

    private function getGatewyId(string $gateway){
        $myGateway = TransactionGatewayRepo::getTransactionGatewayByName($gateway)
            ->orFailWith([Responses::class, 'sendErrorResponse'] , ['msg'   =>  'No DB record found for this gateway' , Response::HTTP_BAD_REQUEST]);

        return $myGateway->id;
    }

    /**
     * @param Order $order
     * @return bool
     */
    private function shouldCloseOrder(Order $order): bool
    {
        return $order->orderstatus_id == config('constants.ORDER_STATUS_OPEN');
    }

    /**
     * Saves order in cookie
     *
     * @param Order $order
     */
    private function saveOrderInCookie(Order $order)
    {
        $orderproducts = $order->orderproducts ;

        $totalCookie = $this->handleOrders($orderproducts);

        if($totalCookie->isNotEmpty())
            setcookie('cartItems', $totalCookie->toJson(), time() + 3600, '/');
    }

    /**
     * @param $orderproducts
     * @return Collection
     */
    private function handleOrders(Collection $orderproducts)
    {
        $totalCookie = collect();
        foreach ($orderproducts as $orderproduct) {
            $extraAttributesIds = $orderproduct->attributevalues->pluck('id')->toArray();
            $myProduct = $orderproduct->product;

            $grandProduct = $myProduct->grand;
            if (is_null($grandProduct)) {
                $totalCookie->push([
                    'product_id' => $myProduct->id,
                    'products' => [],
                    'extraAttribute' => $extraAttributesIds
                ]);
                continue;
            }

            $grandType = $grandProduct->producttype_id;
            if ($grandType == config('constants.PRODUCT_TYPE_SELECTABLE')) {
                $this->makeCookieForSelectableGrand($totalCookie, $grandProduct, $myProduct, $extraAttributesIds);
            } elseif ($grandType == config('constants.PRODUCT_TYPE_CONFIGURABLE')) {
                $this->makeCookieForConfigurableGrand($totalCookie, $myProduct, $grandProduct, $extraAttributesIds);
            }

        }

        return $totalCookie;
    }

    /**
     * @param \Illuminate\Support\Collection $totalCookie
     * @param $grandProduct
     * @param $myProduct
     * @param $extraAttributesIds
     */
    private function makeCookieForSelectableGrand(\Illuminate\Support\Collection $totalCookie, Product $grandProduct, Product $myProduct, array $extraAttributesIds): void
    {
        $isAdded = $totalCookie->where('product_id', $grandProduct->id);
        if ($isAdded->isEmpty()) {
            $totalCookie->push([
                'product_id' => $grandProduct->id,
                'products' => [$myProduct->id],
                'extraAttribute' => $extraAttributesIds
            ]);
        } else {
            $key = $isAdded->keys()->last();
            $addedCookie = $isAdded->first();
            $addedCookie['products'] = array_merge_recursive($addedCookie['products'], [$myProduct->id]);
            $addedCookie['extraAttribute'] = array_merge_recursive($addedCookie['extraAttribute'], $extraAttributesIds);
            $totalCookie->put($key, $addedCookie);
        }
    }

    /**
     * @param \Illuminate\Support\Collection $totalCookie
     * @param $myProduct
     * @param $grandProduct
     * @param $extraAttributesIds
     */
    private function makeCookieForConfigurableGrand(\Illuminate\Support\Collection $totalCookie,Product $myProduct,Product $grandProduct, array $extraAttributesIds): void
    {
        $attributeValueIds = $this->getProductAttributes($myProduct);

        if (!empty($attributeValueIds)) {
            $totalCookie->push([
                'product_id' => $grandProduct->id,
                'attribute' => $attributeValueIds,
                'extraAttribute' => $extraAttributesIds,
            ]);
        }
    }

    /**
     * @param $myProduct
     * @return mixed
     */
    private function getProductAttributes(Product $myProduct)
    {
        return $myProduct->attributevalues()->whereHas('attribute', function ($q) {
            $q->where('attributetype_id', config('constants.ATTRIBUTE_TYPE_MAIN'));
        })->get()->pluck('id')->toArray();
    }
}
