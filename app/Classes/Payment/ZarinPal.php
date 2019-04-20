<?php

namespace App\Classes\Payment;

use App\Classes\Nullable;
use App\Transaction;
use App\Transactiongateway;
use Cache;
use Facades\App\Http\Controllers\Web\TransactionController;
use Illuminate\Http\Response;
use Zarinpal\Zarinpal as ZarinpalClient;

class ZarinPal
{
    public function interactWithZarinPal(string $paymentMethod, string $device, int $cost, string $description, Transaction $transaction): array
    {
        [$transactionGateway, $gateway] = $this->buildZarinPalGateway();

        /**
         * @var $gateway
         */
        $callbackUrl = $this->getCallbackUrl($paymentMethod, $device);

        $authority = $this->paymentRequest($gateway, $callbackUrl, $cost, $description);

        $transactionModifyResult = $this->setAuthorityForTransaction($authority, $transactionGateway->id, $transaction, $description);

        if ($transactionModifyResult['statusCode'] != Response::HTTP_OK) {
            Responses::editTransactionError();
        }

        return $this->getRedirectData($gateway->redirectUrl());
    }

    /**
     * @param bool $withSandBox
     *
     * @return mixed
     */
    public function buildZarinPalGateway(bool $withSandBox = true)
    {
        $transactionGateWay = $this->getGateWayCredentials()->getValue(function () {
            Responses::gateWayNotFoundError();
        });
      /*
        if (is_null($transactionGateWay)) {
            Responses::gateWayNotFoundError();
        }
      */

        return [
          $transactionGateWay,
          $this->initializeZarinPalClient($withSandBox, $transactionGateWay),
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
    protected function getGateWayCredentials(): Nullable
    {
        $result = Cache::remember('transactiongateway:Zarinpal', config('constants.CACHE_600'), function () {
            return Transactiongateway::where('name', 'zarinpal')->first();
        });

        return nullable($result);
    }

    /**
     * @param $gatewayComposer
     * @param string $callbackUrl
     * @param int $amount
     * @param string $description
     * @return string
     */
    public function paymentRequest(ZarinpalClient $gatewayComposer, string $callbackUrl, int $amount, string $description): string
    {
        $zarinpalResponse = $gatewayComposer->request($callbackUrl, $amount, $description);
        $authority = $zarinpalResponse['Authority'];

        if (! isset($authority[0])) {
            Responses::noResponseFromBackError();
        }

        return $authority;
    }

    /**
     * @param string $authority
     * @param int $transactionGatewayId
     * @param Transaction $transaction
     * @param string $description
     * @return array
     */
    private function setAuthorityForTransaction(string $authority, int $transactionGatewayId, Transaction $transaction, string $description): array
    {
        $data = [
            'destinationBankAccount_id' => 1,
            'authority' => $authority,
            'transactiongateway_id' => $transactionGatewayId,
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

    /**
     * @param bool $withSandBox
     * @param \App\Transactiongateway $transactionGateWay
     * @return \Zarinpal\Zarinpal
     */
    private function initializeZarinPalClient(bool $withSandBox, Transactiongateway $transactionGateWay): \Zarinpal\Zarinpal
    {
        $gatewayComposer = new ZarinpalClient($transactionGateWay->merchantNumber);
        if ($this->isZarinpalSandboxOn() && $withSandBox) {
            $gatewayComposer->enableSandbox();
        }

        if ($this->isZarinGateOn()) {
            $gatewayComposer->isZarinGate();
        }

        return $gatewayComposer;
    }
}