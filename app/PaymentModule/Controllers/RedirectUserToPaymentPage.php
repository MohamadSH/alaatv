<?php

namespace App\PaymentModule\Controllers;

//use App\Classes\Payment\OnlineGateWay;
use App\User;
use App\Order;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\PaymentModule\Responses;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\PaymentModule\OnlineGateWay;
use App\PaymentModule\PaymentDriver;
use App\Repositories\TransactionRepo;
use App\Http\Controllers\Web\TransactionController;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Classes\Payment\RefinementRequest\RefinementLauncher;

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
        $data = $this->getRefinementData($request->all(), $request->user());

        /** @var User $user */
        $user = $data['user'];
        /** @var Order $order */
        $order = $data['order'];
        /** @var int $cost */
        $cost = (int) $data['cost'];
        /** @var Transaction $transaction */
        $transaction = $data['transaction'];

        if ($data['statusCode'] != Response::HTTP_OK) {
            $this->sendErrorResponse($data['message'], $data['statusCode']);
        }

        /** @var string $description */
        $description = $this->getTransactionDescription($data['description'], $user->mobile, $order);

        if ($this->isPayingAnOrder($order)) {
            $order->customerDescription = $request->get('customerDescription');
        }

        $this->shouldGoToOfflinePayment($cost)->thenRespondWith([Responses::class, 'sendToOfflinePaymentProcess'], [$device, $order->id]);

        PaymentDriver::select($paymentMethod);
        $url = $this->comeBackFromGateWayUrl($paymentMethod, $device);
        $authorityCode = OnlineGateWay::generateAuthorityCode($url, $cost, $description, $order->id)->orFailWith([Responses::class, 'noResponseFromBankError']);

        TransactionRepo::setAuthorityForTransaction($authorityCode, $transaction->id, $description)->orRespondWith([Responses::class, 'editTransactionError']);

        $redirectData = OnlineGateWay::generatePaymentPageUriObject($authorityCode);

        return view("order.checkout.gatewayRedirect", compact('redirectData'));
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
        $inputData['user'] = $user;

        return (new RefinementLauncher($inputData))->getData($inputData);
    }

    /**
     * @param string $msg
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    private function sendErrorResponse(string $msg, int $statusCode): JsonResponse
    {
        $resp = response()->json(['message' => $msg], $statusCode);
        throw new HttpResponseException($resp);
    }

    /**
     * @param string $description
     * @param              $mobile
     * @param Order|null $order
     *
     * @return string
     */
    private function getTransactionDescription(string $description, $mobile, $order = null)
    {
        $description .= 'سایت آلاء - ';
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
     * @param Order $order
     *
     * @return bool
     */
    private function isPayingAnOrder($order): bool
    {
        return isset($order);
    }

    /**
     * @param int $cost
     *
     * @return Boolean
     */
    private function shouldGoToOfflinePayment(int $cost)
    {
        return boolean($cost <= 0);
    }

    /**
     * @param string $paymentMethod
     * @param string $device
     *
     * @return string
     */
    private function comeBackFromGateWayUrl(string $paymentMethod, string $device)
    {
        return route('verifyOnlinePayment', ['paymentMethod' => $paymentMethod, 'device' => $device]);
    }
}