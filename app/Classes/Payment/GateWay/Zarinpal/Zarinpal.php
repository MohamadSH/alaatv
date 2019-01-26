<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:31 PM
 */

namespace App\Classes\Payment\GateWay\Zarinpal;

use Illuminate\Support\Facades\Validator;
use Zarinpal\Zarinpal as ZarinpalComposer;
use App\Classes\Payment\GateWay\GateWayAbstract;

class Zarinpal extends GateWayAbstract
{
    private $merchantID;
    private $returnStatus;
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

    public function __construct(string $merchantID)
    {
        parent::__construct();
        $this->merchantID = $merchantID;
        $this->zarinpalComposer = new ZarinpalComposer($this->merchantID);

        if(config('app.env', 'deployment')!='deployment' && config('Zarinpal.Sandbox', false)) {
            $this->zarinpalComposer->enableSandbox(); // active sandbox mod for test env
        }
        if(config('Zarinpal.ZarinGate', false)) {
            $this->zarinpalComposer->isZarinGate(); // active zarinGate mode
        }
    }

    /**
     * Making request to ZarinPal gateway
     * must loadForRedirect before
     * @param int $amount
     * @param string $callbackUrl
     * @param string|null $description
     * @return array
     */
    public function paymentRequest(int $amount, string $callbackUrl, string $description=null): array
    {
        $result = [
            'status'=>false,
            'message'=>[],
            'data'=>[]
        ];

        $zarinpalResponse = $this->zarinpalComposer->request($callbackUrl, $amount, $description);
        if (isset($zarinpalResponse['Authority']) && strlen($zarinpalResponse['Authority']) > 0) {
            $result['status'] = true;
            $result['message'][] = 'درخواست پرداخت با موفقیت ارسال و نتیجه آن دریافت شد.';
            $result['data']['Authority'] = $zarinpalResponse['Authority'];
            $result['data']['zarinpalResponse'] = $zarinpalResponse;
        } else {
            $result['status'] = false;
            $result['message'][] = 'مشکل در برقراری ارتباط با درگاه زرین پال';
            $result['data']['zarinpalResponse'] = $zarinpalResponse;
        }
        return $result;
    }

    /**
     * Making request to ZarinPal gateway
     * must loadForRedirect before
     * @return void
     */
    public function redirect(): void
    {
        $this->zarinpalComposer->redirect();
    }

    /**
     * verify ZarinPal callback request
     * must loadForVerify before
     * @return array $this->result
     */
    public function getCallbackData(): array
    {
        $this->validateCallbackData($this->request->all());

        if (!$this->result['status']) {
            return $this->result;
        }

        $this->returnStatus = $this->result['data']['callbackData']['Authority'];
        if($this->returnStatus=='OK') {
            $this->result['status'] = true;
            $this->result['message'][] = 'کاربر پرداخت را انجام داده است و پرداخت وی می بایست تایید شود.';
            $this->result['Authority'] = $this->result['data']['callbackData']['Authority'];
        } else {
            $this->result['status'] = false;
            $this->result['message'][] = 'پرداخت کاربر به درستی انجام نشده است.';
            $this->result['Authority'] = $this->result['data']['callbackData']['Authority'];
        }

        return $this->result;
    }

    /**
     * @param int $amount
     * @param array $data
     * @return array
     */
    public function verify(int $amount, array $data=null): array
    {
        if (isset($data['Authority'])) {
            $authority = $data['Authority'];
        } else {
            $authority = $this->request->get('Authority');
        }
        if (isset($data['Status'])) {
            $status = $data['Status'];
        } else {
            $status = $this->request->get('Status');
        }

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
     * @param array $callbackData
     * @return void
     */
    private function validateCallbackData(array $callbackData): void
    {
        $validator = Validator::make($callbackData, [
            'Authority' => 'required|string|min:36|max:36',
            'Status' => 'required|string|min:2|max:3',
        ]);
        if ($validator->fails()) {
            $this->result['status'] = false;
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                $this->result['message'][] = $messages;
            }
        }
        $this->result['data']['callbackData'] = $callbackData;
    }
}