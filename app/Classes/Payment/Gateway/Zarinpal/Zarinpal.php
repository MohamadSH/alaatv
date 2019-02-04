<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:31 PM
 */

namespace App\Classes\Payment\Gateway\Zarinpal;

use PHPUnit\Framework\Exception;
use App\Classes\Payment\Gateway\Gateway;
use Illuminate\Support\Facades\Validator;
use Zarinpal\Zarinpal as ZarinpalComposer;

class Zarinpal implements Gateway
{
    /**
     * @var array $result
     */
    protected $result;

    /**
     * @var string $merchantID
     */
    private $merchantID;

    /**
     * @var ZarinpalComposer $zarinpalComposer
     */
    private $zarinpalComposer;

    const EXCEPTION = array(
        -1 => 'اطلاعات ارسال شده ناقص است.',
        -2 => 'IP و یا مرچنت کد پذیرنده صحیح نیست',
        -3 => 'رقم باید بالای 100 تومان باشد',
        -4 => 'سطح پذیرنده پایین تر از سطح نقره ای است',
        -11 => 'درخواست مورد نظر یافت نشد',
        -21 => 'هیچ نوع عملیات مالی برای این تراکنش یافت نشد. کاربر قبل از ورود به درگاه بانک در همان صفحه زرین پال منصرف شده است.',
        -22 => 'تراکنش ناموفق می باشد. کاربر بعد از ورود به درگاه بانک منصرف شده است.',
        -33 => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد',
        -54 => 'درخواست مورد نظر آرشیو شده',
        100 => 'عملیات با موفقیت انجام شد',
        101 => 'عملیات پرداخت با موفقیت انجام شده ولی قبلا عملیات PaymentVertification بر روی این تراکنش انجام شده است',
    );

    public function __construct(array $data)
    {
        $this->result = [
            'status' => true,
            'message' => [],
            'data' => [],
        ];

        $rules = [
            'merchantID' => 'required|string|size:36'
        ];
        $this->dataValidation($data, $rules);
        if (!$this->result['status']) {
            throw new Exception('The merchantID must be 36 characters.');
            /*return $this->result;*/
        } else {
            $this->merchantID = $data['merchantID'];
            $this->zarinpalComposer = new ZarinpalComposer($this->merchantID);
        }

        if($this->isSandboxOn()) {
            $this->zarinpalComposer->enableSandbox(); // active sandbox mod for test env
        }
        if($this->isZarinGateOn()) {
            $this->zarinpalComposer->isZarinGate(); // active zarinGate mode
        }
    }

    /**
     * Making request to ZarinPal gateway
     * must loadForRedirect before
     * @param array $data
     * @return array
     */
    public function paymentRequest(array $data): array
    {
        $rules = [
            'callbackUrl' => 'required|string',
            'amount' => 'required|integer|min:100',
            'description' => 'sometimes|string|min:1',
        ];

        $this->dataValidation($data, $rules);
        if (!$this->result['status']) {
            return $this->result;
        }

        $zarinpalResponse = $this->zarinpalComposer->request($data['callbackUrl'], $data['amount'], $data['description']);
        if (isset($zarinpalResponse['Authority']) && strlen($zarinpalResponse['Authority']) > 0) {
            $this->result['status'] = true;
            $this->result['message'][] = 'درخواست پرداخت با موفقیت ارسال و نتیجه آن دریافت شد.';
            $this->result['data']['Authority'] = $zarinpalResponse['Authority'];
            $this->result['data']['zarinpalResponse'] = $zarinpalResponse;
        } else {
            $this->result['status'] = false;
            $this->result['message'][] = 'مشکل در برقراری ارتباط با درگاه زرین پال';
            $this->result['data']['zarinpalResponse'] = $zarinpalResponse;
        }
        return $this->result;
    }

    /**
     * Making request to ZarinPal gateway
     * must loadForRedirect before
     * @param array $data
     * @return array
     */
    public function getRedirectData(array $data): array
    {
        $redirectData = [
            'url' => $this->zarinpalComposer->redirectUrl(),
            'input' => [],
            'method' => 'GET'
        ];
        return $redirectData;
    }

    /**
     * verify ZarinPal callback request
     * must loadForVerify before
     * @param array $data
     * @return array $this->result
     */
    public function readCallbackData(array $data): array
    {
        $rules = [
            'Authority' => 'required|string|size:36',
            'Status' => 'required|string|min:2|max:3',
        ];

        $this->dataValidation($data, $rules);
        if (!$this->result['status']) {
            return $this->result;
        }

        if($data['Status']=='OK') {
            $this->result['status'] = true;
            $this->result['message'][] = 'کاربر پرداخت را انجام داده است و پرداخت وی می بایست تایید شود.';
            $this->result['data']['Authority'] = $data['Authority'];
        } else {
            $this->result['status'] = false;
            $this->result['message'][] = 'پرداخت کاربر به درستی انجام نشده است.';
            $this->result['data']['Authority'] = $data['Authority'];
        }

        return $this->result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function verify(array $data): array
    {
        $this->result['status'] = true;

        $rules = [
            'amount' => 'required|integer|min:100',
            'Authority' => 'required|string|size:36',
            'Status' => 'required|string|min:2|max:3',
        ];

        $this->dataValidation($data, $rules);
        if (!$this->result['status']) {
            return $this->result;
        }

        $amount = $data['amount'];
        $status = $data['Status'];
        $authority = $data['Authority'];

        $result = $this->zarinpalComposer->verify($status, $amount, $authority);
        $this->result['data']['zarinpalVerifyResult'] = $result;

        if (!isset($result)) {
            $this->result['status'] = false;
            $this->result['message'][] = 'مشکل در برقراری ارتباط با زرین پال';
            return $this->result;
        }

        if (isset($result['RefID']) && strcmp($result['Status'], 'success') == 0) {
            $this->result['status'] = true;
            $this->result['data']['RefID'] = $result['RefID'];
            $this->result['data']['cardPanMask'] = isset($result['ExtraDetail']['Transaction']['CardPanMask'])?$result['ExtraDetail']['Transaction']['CardPanMask']:null;;
            $this->result['message'][] = 'پرداخت کاربر تایید شد.';
        } else {
            $this->result['status'] = false;
            if (strcmp($result['Status'], 'canceled') == 0) {
                $this->result['message'][] = 'کاربر از پرداخت انصراف داده است.';
            } else if (strcmp($result['Status'], 'verified_before') ==0) {
                $this->result['message'][] = self::EXCEPTION[101];
            } else {
                $this->result['message'][] = 'خطایی در پرداخت رخ داده است.';
                if (isset($result['error'])) {
                    $this->result['message'][] = self::EXCEPTION[$result['error']];
                }
            }
        }
        return $this->result;
    }

    /**
     * @return array
     */
    public function getUnverifiedTransactions() {
        $inputs = [
            'MerchantID' => $this->merchantID
        ];
        $result = $this->zarinpalComposer->getDriver()->unverifiedTransactions($inputs);
        return $result;
    }

    /**
     * @param array $data
     * @param array $rules
     * @return void
     */
    private function dataValidation(array $data, array $rules): void
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $this->result['status'] = false;
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                $this->result['message'][] = $messages;
            }
            $this->result['data']['WrongInput'] = $data;
        }
    }

    /**
     * @return bool
     */
    private function isSandboxOn(): bool
    {
        return config('app.env', 'deployment') != 'deployment' && config('Zarinpal.Sandbox', false);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function isZarinGateOn()
    {
        return config('Zarinpal.ZarinGate', false);
    }
}