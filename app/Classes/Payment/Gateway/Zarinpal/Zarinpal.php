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

class Zarinpal extends Gateway
{
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
        $this->refreshResult();
        $rules = [
            'merchantID' => 'required|string|size:36'
        ];
        $this->dataValidation($data, $rules);
        if (!$this->getResultStatus()) {
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
     * @param array $data
     * @return string|null
     */
    protected function getPaymentRequestToken(array $data): ?string
    {
        $zarinpalResponse = $this->zarinpalComposer->request($data['callbackUrl'], $data['amount'], $data['description']);
        $authority = $zarinpalResponse['Authority'];
        if (isset($authority[0])) {
            $this->setResultData('zarinpalResponse', $zarinpalResponse);
            return $authority;
        } else {
            $this->setResultData('zarinpalResponse', $zarinpalResponse);
            return null;
        }
    }

    /**
     * verify ZarinPal callback request
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
        if (!$this->getResultStatus()) {
            return $this->getResult();
        }

        if($data['Status']=='OK') {
            $this->setResultStatus(true);
            $this->addResultMessage('کاربر پرداخت را انجام داده است و پرداخت وی می بایست تایید شود.');
            $this->setResultData('Authority', $data['Authority']);
        } else {
            $this->setResultStatus(false);
            $this->addResultMessage('پرداخت کاربر به درستی انجام نشده است.');
            $this->setResultData('Authority', $data['Authority']);
        }

        return $this->getResult();
    }

    /**
     * @param array $data
     * @return array
     */
    public function verify(array $data): array
    {
        $this->setResultStatus(true);

        $rules = [
            'amount' => 'required|integer|min:100',
            'Authority' => 'required|string|size:36',
            'Status' => 'required|string|min:2|max:3',
        ];

        $this->dataValidation($data, $rules);
        if (!$this->getResultStatus()) {
            return $this->getResult();
        }

        $amount = $data['amount'];
        $status = $data['Status'];
        $authority = $data['Authority'];

        $result = $this->zarinpalComposer->verify($status, $amount, $authority);
        $this->setResultData('zarinpalVerifyResult', $result);

        if (!isset($result)) {
            $this->setResultStatus(false);
            $this->addResultMessage('مشکل در برقراری ارتباط با زرین پال');
            return $this->getResult();
        }

        if (isset($result['RefID']) && strcmp($result['Status'], 'success') == 0) {
            $this->setResultStatus(true);
            $this->setResultData('RefID', $result['RefID']);
            $this->setResultData('cardPanMask', isset($result['ExtraDetail']['Transaction']['CardPanMask'])?$result['ExtraDetail']['Transaction']['CardPanMask']:null);
            $this->addResultMessage('پرداخت کاربر تایید شد.');
        } else {
            $this->setResultStatus(false);
            if (strcmp($result['Status'], 'canceled') == 0) {
                $this->addResultMessage('کاربر از پرداخت انصراف داده است.');
            } else if (strcmp($result['Status'], 'verified_before') ==0) {
                $this->addResultMessage(self::EXCEPTION[101]);
            } else {
                $this->addResultMessage('خطایی در پرداخت رخ داده است.');
                if (isset($result['error'])) {
                    $this->addResultMessage(self::EXCEPTION[$result['error']]);
                }
            }
        }
        return $this->getResult();
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
            $this->setResultStatus(false);
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                $this->addResultMessage($messages);
            }
            $this->setResultData('WrongInput',$data);
        }
    }

    protected function getPaymentRequestInputRules(array $data): array
    {
        return  [
            'callbackUrl' => 'required|string',
            'amount' => 'required|integer|min:100',
            'description' => 'sometimes|string|min:1',
        ];
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

    protected function gatewayRedirectUrl(array $data): string
    {
        return $this->zarinpalComposer->redirectUrl();
    }

    protected function gatewayRedirectMethod(array $data): string
    {
        return 'GET';
    }

    protected function gatewayRedirectInputs(array $data): array
    {
        return [];
    }
}