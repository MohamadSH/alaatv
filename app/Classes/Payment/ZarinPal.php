<?php

namespace App\Classes\Payment;

use App\Http\Controllers\Web\TransactionController;
use App\Transaction;
use App\Transactiongateway;
use Cache;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Zarinpal\Zarinpal as ZarinpalComposer;

class ZarinPal
{
    public function interactWithZarinPal(string $paymentMethod, string $device, int $cost, string $description, Transaction $transaction): array
    {
        $gatewayResult = $this->buildZarinPalGateway();

        $transactiongateway = $gatewayResult['transactiongateway'];
        $gateway = $gatewayResult['gatewayComposer'];

        $callbackUrl = $this->getCallbackUrl($paymentMethod, $device);

        $authority = $this->paymentRequest($gateway, $callbackUrl, $cost, $description);

        $transactionModifyResult = $this->setAuthorityForTransaction($authority, $transactiongateway->id, $transaction, $description);

        if ($transactionModifyResult['statusCode'] != Response::HTTP_OK) {
            throw new HttpResponseException($this->sendErrorResponse('مشکلی در ویرایش تراکنش رخ داده است.', Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return $this->getRedirectData($gateway->redirectUrl());
    }

    /**
     * @param string $paymentMethod
     *
     * @param bool $withSandBox
     *
     * @return mixed
     */
    public function buildZarinPalGateway(bool $withSandBox = true)
    {
        $transactiongateWay = $this->getGateWayCredentials();

        if (is_null($transactiongateWay)) {
            throw new HttpResponseException($this->sendErrorResponse('درگاه مورد نظر یافت نشد', Response::HTTP_BAD_REQUEST));
        }

        $gatewayComposer = new ZarinpalComposer($transactiongateWay->merchantNumber);
        if ($this->isZarinpalSandboxOn() && $withSandBox) {
            $gatewayComposer->enableSandbox();
        }

        if ($this->isZarinGateOn()) {
            $gatewayComposer->isZarinGate();
        }

        return [
            'transactiongateway' => $transactiongateWay,
            'gatewayComposer' => $gatewayComposer,
        ];
    }

    /**
     * @return bool
     */
    protected function isZarinpalSandboxOn(): bool
    {
        return config('app.env', 'deployment') != 'deployment' && config('Zarinpal.Sandbox', false);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function isZarinGateOn(): bool
    {
        return config('Zarinpal.ZarinGate', false);
    }

    /**
     * @param string $key
     * @return Transactiongateway
     */
    protected function getGateWayCredentials(): Transactiongateway
    {
        return Cache::remember('transactiongateway:Zarinpal', config('constants.CACHE_600'), function () {
            return Transactiongateway::where('name', 'zarinpal')->first();
        });
    }

    /**
     * @param string $msg
     * @param int $statusCode
     * @return JsonResponse
     */
    private function sendErrorResponse(string $msg, int $statusCode): JsonResponse
    {
        return response()->json(['message' => $msg], $statusCode);
    }

    /**
     * @param $gatewayComposer
     * @param string $callbackUrl
     * @param int $amount
     * @param string $description
     * @return string
     */
    public function paymentRequest(ZarinpalComposer $gatewayComposer, string $callbackUrl, int $amount, string $description): string
    {
        $zarinpalResponse = $gatewayComposer->request($callbackUrl, $amount, $description);
        $authority = $zarinpalResponse['Authority'];

        if (! isset($authority[0])) {
            throw new HttpResponseException($this->sendErrorResponse('پاسخی از بانک دریافت نشد', Response::HTTP_SERVICE_UNAVAILABLE));
        }

        return $authority;
    }

    /**
     * @param string $authority
     * @param int $transactiongatewayId
     * @param Transaction $transaction
     * @param string $description
     * @return array
     */
    private function setAuthorityForTransaction(string $authority, int $transactiongatewayId, Transaction $transaction, string $description): array
    {
        $data = [
            'destinationBankAccount_id' => 1,
            'authority' => $authority,
            'transactiongateway_id' => $transactiongatewayId,
            'paymentmethod_id' => config('constants.PAYMENT_METHOD_ONLINE'),
            'description' => $description,
        ];

        return TransactionController::modify($transaction, $data);
    }

    /**
     * @param string $redirectUrl
     * @return array
     */
    public function getRedirectData(string $redirectUrl): array
    {
        return [
            'url' => $redirectUrl,
            'input' => [],
            'method' => 'GET',
        ];
    }

    /**
     * @param string $paymentMethod
     * @param string $device
     * @return string
     */
    public function getCallbackUrl(string $paymentMethod, string $device): string
    {
        return action('Web\OnlinePaymentController@verifyPayment', ['paymentMethod' => $paymentMethod, 'device' => $device]);
    }
}