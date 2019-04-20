<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 2/10/2019
 * Time: 11:15 AM
 */

namespace App\Traits;

use App\Order;
use App\Transactiongateway;
use App\User;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Zarinpal\Zarinpal as ZarinpalComposer;

trait ZarinpalGateway
{
    protected $exceptions = [
        -1 => 'اطلاعات ارسال شده ناقص است.',
        -2 => 'IP و یا مرچنت کد پذیرنده صحیح نیست',
        -3 => 'رقم باید بالای 100 تومان باشد',
        -4 => 'سطح پذیرنده پایین تر از سطح نقره ای است',
        -11 => 'درخواست مورد نظر یافت نشد',
        -21 => 'کاربر قبل از ورود به درگاه بانک در همان صفحه زرین پال منصرف شده است.',
        -22 => 'تراکنش ناموفق می باشد. کاربر بعد از ورود به درگاه بانک منصرف شده است.',
        -33 => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد',
        -54 => 'درخواست مورد نظر آرشیو شده',
        100 => 'عملیات با موفقیت انجام شد',
        101 => 'عملیات پرداخت با موفقیت انجام شده ولی قبلا عملیات PaymentVertification بر روی این تراکنش انجام شده است',
    ];

    /**
     * @param ZarinpalComposer $gatewayComposer
     * @param int $amount
     * @param array $authority
     *
     * @return array
     */
    public function verify(ZarinpalComposer $gatewayComposer, int $amount, array $authority): array
    {
        $gatewayResult = $gatewayComposer->verify($amount, $authority);

        $result = $this->prepareResponse($gatewayResult);
        $result['__zarinpalVerifyResult'] = $gatewayResult;

        return $result;
    }

    /**
     * @param string $description
     * @param User $user
     * @param Order|null $order
     *
     * @return string
     */
    private function getTransactionDescription(string $description, User $user, Order $order = null): string
    {
        $description .= $user->mobile.' - محصولات: ';

        if (! isset($order)) {
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
     * @param $gatewayResult
     * @return bool
     */
    private function isSuccessfulPayment($gatewayResult): bool
    {
        return isset($gatewayResult['RefID']) && in_array($gatewayResult['Status'], ['verified_before', 'success',]);
    }

    /**
     * @param $refId
     * @param $gatewayStatus
     * @param $cardPanMask
     * @return mixed
     */
    private function handleSuccessfulPayment($gatewayStatus, $refId, $cardPanMask)
    {
        $message[] = 'پرداخت کاربر تایید شد.';
        if ($this->hasBeenVerifiedBefore($gatewayStatus['Status'])) {
            $message[] = $this->exceptions[101];
        }

        return $this->getResult($message, true, $refId, $cardPanMask);
    }

    /**
     * @param $status
     * @param $error
     * @return mixed
     */
    private function handleUnsuccessfulPayment($status, $error)
    {
        if (strcmp($status, 'canceled') == 0) {
            return $this->getResult(['کاربر از پرداخت انصراف داده است.']);
        }
        $message[] = 'خطایی در پرداخت رخ داده است.';

        if ($error) {
            $message[] = $this->exceptions[$error];
        }

        return $this->getResult($message);
    }

    /**
     * @param $refId
     * @return mixed
     */
    private function getRefId($refId)
    {
        if ($this->isZarinpalSandboxOn()) {
            return 'sandbox'.Carbon::now()->timestamp;
        } else {
            return $refId;
        }
    }

    /**
     * @param $status
     * @return bool
     */
    private function hasBeenVerifiedBefore($status): bool
    {
        return strcmp($status, 'verified_before') == 0;
    }

    /**
     * @param $refId
     * @param null $cardPanMask
     * @return array
     */
    private function getData($refId = null, $cardPanMask = null): array
    {
        return [
            'cardPanMask' => $cardPanMask ?: '',
            'RefID' => $refId ? $this->getRefId($refId) : '',
        ];
    }

    /**
     * @param $refId
     * @param $cardPanMask
     * @param bool $status
     * @param $message
     * @return array
     */
    private function getResult($message, bool $status = false, $refId = null, $cardPanMask = null): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $this->getData($refId, $cardPanMask),
        ];
    }

    /**
     * @param $gatewayResult
     * @return array|mixed
     */
    private function prepareResponse($gatewayResult)
    {
        if (! isset($gatewayResult)) {
            return $this->getResult(['مشکل در برقراری ارتباط با زرین پال']);
        }

        if ($this->isSuccessfulPayment($gatewayResult)) {
            $cardPanMask = array_get($gatewayResult, 'ExtraDetail.Transaction.CardPanMask');

            return $this->handleSuccessfulPayment($gatewayResult['Status'], $gatewayResult['RefID'], $cardPanMask);
        }

        return $this->handleUnsuccessfulPayment($gatewayResult['Status'], $gatewayResult['error'] ?? null);
    }
}