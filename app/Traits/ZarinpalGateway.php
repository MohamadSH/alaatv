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

    protected  $exceptions = array(
        -1  => 'اطلاعات ارسال شده ناقص است.',
        -2  => 'IP و یا مرچنت کد پذیرنده صحیح نیست',
        -3  => 'رقم باید بالای 100 تومان باشد',
        -4  => 'سطح پذیرنده پایین تر از سطح نقره ای است',
        -11 => 'درخواست مورد نظر یافت نشد',
        -21 => 'کاربر قبل از ورود به درگاه بانک در همان صفحه زرین پال منصرف شده است.',
        -22 => 'تراکنش ناموفق می باشد. کاربر بعد از ورود به درگاه بانک منصرف شده است.',
        -33 => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد',
        -54 => 'درخواست مورد نظر آرشیو شده',
        100 => 'عملیات با موفقیت انجام شد',
        101 => 'عملیات پرداخت با موفقیت انجام شده ولی قبلا عملیات PaymentVertification بر روی این تراکنش انجام شده است',
    );

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
        if (isset($authority[0]))
            return $authority;
        else
            return null;
    }

    /**
     * @param string $redirectUrl
     * @return array
     */
    public function getRedirectData(string $redirectUrl): array {
        $redirectData = [
            'url'    => $redirectUrl,
            'input'  => [],
            'method' => 'GET'
        ];
        return $redirectData;
    }

    /**
     * @param ZarinpalComposer $gatewayComposer
     * @param int              $amount
     * @param array            $paymentData
     *
     * @return array
     */
    public function verify(ZarinpalComposer $gatewayComposer, int $amount, array $paymentData): array
    {
        $gatewayResult = $gatewayComposer->verify($amount, $paymentData["Authority"]);
        $result['data']['zarinpalVerifyResult'] = $gatewayResult;

        if (!isset($gatewayResult)) {
            $result['status'] = false;
            $result['message'][] = 'مشکل در برقراری ارتباط با زرین پال';
            return $result;
        }

        if (isset($gatewayResult['RefID']) && in_array($gatewayResult['Status'], ['verified_before', 'success',])) {
            $result['status'] = true;
            $result['message'][] = 'پرداخت کاربر تایید شد.';
            $result['data']['cardPanMask'] = isset($gatewayResult['ExtraDetail']['Transaction']['CardPanMask'])? $gatewayResult['ExtraDetail']['Transaction']['CardPanMask']:null;
            if ($this->isZarinpalSandboxOn()) {
                $nowUnix = Carbon::now()->timestamp ;
                $result['data']['RefID'] = 'sandbox'.$nowUnix;

            } else {
                $result['data']['RefID'] = $gatewayResult['RefID'];
            }

            if (strcmp($gatewayResult['Status'], 'verified_before') ==0)
                $result['message'][] = $this->exceptions[101];

        } else {
            $result['status'] = false;
            if (strcmp($gatewayResult['Status'], 'canceled') == 0) {
                $result['message'][] = 'کاربر از پرداخت انصراف داده است.';
            }else {
                $result['message'][] = 'خطایی در پرداخت رخ داده است.';
                if (isset($gatewayResult['error'])) {
                    $result['message'][] = $this->exceptions[$gatewayResult['error']];
                }
            }
        }
        return $result;
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
    protected function isZarinGateOn():bool
    {
        return config('Zarinpal.ZarinGate', false);
    }

    /**
     * @param string $paymentMethod
     *
     * @param bool   $withSandBox
     *
     * @return mixed
     */
    protected function buildZarinpalGateway(string $paymentMethod, bool $withSandBox = true)
    {
        $key = 'transactiongateway:Zarinpal';
        $transactiongateway = Cache::remember($key, config('constants.CACHE_600'), function () use ($paymentMethod) {
            return Transactiongateway::name('zarinpal', $paymentMethod)->first();
        });

        if (isset($transactiongateway)) {
            $gatewayComposer = new ZarinpalComposer($transactiongateway->merchantNumber);
            if ($this->isZarinpalSandboxOn() && $withSandBox)
                $gatewayComposer->enableSandbox();

            if ($this->isZarinGateOn())
                $gatewayComposer->isZarinGate();
        } else {
            return [
                'error' => [
                    'message' => 'Could not find gate way',
                    'code'    => Response::HTTP_BAD_REQUEST,
                ],
            ];
        }

        return [
            'transactiongateway' => $transactiongateway,
            'gatewayComposer'    => $gatewayComposer,
        ];
    }

    /**
     * @param string     $description
     * @param User       $user
     * @param Order|null $order
     *
     * @return string
     */
    private function setTransactionDescription(string $description, User $user, Order $order = null): string
    {
        $description .= $user->mobile . ' - محصولات: ';

        if (isset($order)) {
            $orderProducts = $order->orderproducts->load('product');

            foreach ($orderProducts as $orderProduct) {
                if (isset($orderProduct->product->id))
                    $description .= $orderProduct->product->name . ' , ';
                else
                    $description .= 'یک محصول نامشخص , ';
            }
        }

        return $description;
    }
}