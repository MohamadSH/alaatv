<?php

namespace App\Classes\Payment;

use App\Transaction;
use App\Transactiongateway;
use Cache;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ZarinPal
{
    public function interactWithZarinPal(string $paymentMethod, string $device, int $cost, string $description, Transaction $transaction): array
    {
        $gatewayResult = $this->buildZarinpalGateway($paymentMethod);

        $transactiongateway = $gatewayResult['transactiongateway'];
        $gateway = $gatewayResult['gatewayComposer'];

        $callbackUrl = action('Web\OnlinePaymentController@verifyPayment', ['paymentMethod' => $paymentMethod, 'device' => $device]);

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
    private function buildZarinpalGateway(string $paymentMethod, bool $withSandBox = true)
    {
        $transactiongateway = $this->getGateWayCredentials($paymentMethod, 'transactiongateway:Zarinpal');

        if (! isset($transactiongateway)) {
            throw new HttpResponseException($this->sendErrorResponse('درگاه مورد نظر یافت نشد', Response::HTTP_BAD_REQUEST));
        }

        $gatewayComposer = new ZarinpalComposer($transactiongateway->merchantNumber);
        if ($this->isZarinpalSandboxOn() && $withSandBox) {
            $gatewayComposer->enableSandbox();
        }

        if ($this->isZarinGateOn()) {
            $gatewayComposer->isZarinGate();
        }

        return [
            'transactiongateway' => $transactiongateway,
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
     * @param string $paymentMethod
     * @param string $key
     * @return mixed
     */
    protected function getGateWayCredentials(string $paymentMethod, string $key): mixed
    {
        return Cache::remember($key, config('constants.CACHE_600'), function () use ($paymentMethod) {
            return Transactiongateway::name('zarinpal', $paymentMethod)->first();
        });
    }

    /**
     * @param string $str
     * @param int $s1
     * @return JsonResponse
     */
    private function sendErrorResponse(string $str, int $s1): JsonResponse
    {
        return response()->json(['message' => $str], $s1);
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
        $data['destinationBankAccount_id'] = 1; // ToDo: Hard Code
        $data['authority'] = $authority;
        $data['transactiongateway_id'] = $transactiongatewayId;
        $data['paymentmethod_id'] = config('constants.PAYMENT_METHOD_ONLINE');
        $data['description'] = $description;
        $transactionModifyResult = $this->transactionController->modify($transaction, $data);

        return $transactionModifyResult;
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
}