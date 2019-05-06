<?php

namespace App\PaymentModule\Gateways\Behpardakht;

use DateTime;
use App\Classes\Nullable;
use Illuminate\Support\Facades\Input;
use App\PaymentModule\{Money,
    RedirectData,
    OnlineGatewayInterface,
    OnlinePaymentRedirectionUriInterface,
    OnlinePaymentVerificationResponseInterface};

class BehpardakhtGateWay implements OnlineGatewayInterface
{
    public $errors = [
        11  => 'شماره کارت نامعتبر است',
        12  => 'موجودی کافی نیست',
        13  => 'رمز نادرست است',
        14  => 'تعداد دفعات وارد کردن رمز بیش از حد مجاز است',
        15  => 'کارت نامعتبر است',
        16  => 'دفعات برداشت وجه بیش از حد مجاز است',
        17  => 'کاربر از انجام تراکنش منصرف شده است',
        18  => 'تاریخ انقضای کارت گذشته است',
        19  => 'مبلغ برداشت وجه بیش از حد مجاز است',
        111 => 'صادر کننده کارت نامعتبر است',
        112 => 'خطای سوییچ صادر کننده کارت',
        113 => 'پاسخی از صادر کننده کارت دریافت نشد',
        114 => 'دارنده این کارت مجاز به انجام این تراکنش نیست',
        21  => 'پذیرنده نامعتبر است',
        23  => 'خطای امنیتی رخ داده است',
        24  => 'اطلاعات کاربری پذیرنده نامعتبر است',
        25  => 'مبلغ نامعتبر است',
        31  => 'پاسخ نامعتبر است',
        32  => 'فرمت اطلاعات وارد شده صحیح نمی‌باشد',
        33  => 'حساب نامعتبر است',
        34  => 'خطای سیستمی',
        35  => 'تاریخ نامعتبر است',
        41  => 'شماره درخواست تکراری است',
        42  => 'تراکنش Sale یافت نشد',
        43  => 'قبلا درخواست Verfiy داده شده است',
        44  => 'درخواست Verfiy یافت نشد',
        45  => 'تراکنش Settle شده است',
        46  => 'تراکنش Settle نشده است',
        47  => 'تراکنش Settle یافت نشد',
        48  => 'تراکنش Reverse شده است',
        49  => 'تراکنش Refund یافت نشد.',
        412 => 'شناسه قبض نادرست است',
        413 => 'شناسه پرداخت نادرست است',
        414 => 'سازمان صادر کننده قبض نامعتبر است',
        415 => 'زمان جلسه کاری به پایان رسیده است',
        416 => 'خطا در ثبت اطلاعات',
        417 => 'شناسه پرداخت کننده نامعتبر است',
        418 => 'اشکال در تعریف اطلاعات مشتری',
        419 => 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است',
        421 => 'IP نامعتبر است',
        51  => 'تراکنش تکراری است',
        54  => 'تراکنش مرجع موجود نیست',
        55  => 'تراکنش نامعتبر است',
        61  => 'خطا در واریز',
    ];
    
    public function generateAuthorityCode(string $callbackUrl, Money $cost, string $description, $orderId = null): Nullable
    {
        $dateTime = new DateTime();

        $fields = [
            'terminalId'     => (int) config('behpardakht.terminalId'),
            'userName'       => config('behpardakht.username'),
            'userPassword'   => (int) config('behpardakht.password'),
            'orderId'        => $orderId,
            'amount'         => $cost->rials(),
            'localDate'      => $dateTime->format('Ymd'),
            'localTime'      => $dateTime->format('His'),
            'additionalData' => $description,
            'callBackUrl'    => $callbackUrl,
            'payerId'        => 0,
        ];

        try {
            $response = $this->makeSoapClient()
                ->bpPayRequest($fields);
        } catch (\SoapFault $e) {
            return nullable(null);
        }

        $response = explode(',', $response->return);

        if ($response[0] != '0') {
            return nullable(null, ['خطای ارتباط با درگاه بانک']);
        }

        return nullable($response[1]);
    }
    
    public function generatePaymentPageUriObject($refId): OnlinePaymentRedirectionUriInterface
    {
        $serverUrl = 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat';
        $data      = [
            ['name' => 'RefId', 'value' => $refId,]
        ];
    
        return RedirectData::instance($serverUrl, $data, 'POST');
    }
    
    public function getAuthorityValue(): string
    {
        return Input::get('RefId', '');
    }
    
    public function verifyPayment(Money $amount, $authority): OnlinePaymentVerificationResponseInterface
    {
        /**
         * `            array:8 [▼
         * "RefId" => "723D241477D96CD1"
         * "ResCode" => "0"
         * "SaleOrderId" => "19"
         * "SaleReferenceId" => "150078823126"
         * "CardHolderInfo" => "DC514292D753D85BD5D91874EBD2A35DD64E8E1EC066A7A2C7D4C9C51BA994C5"
         * "CardHolderPan" => "603799******9276"
         * "FinalAmount" => "1002"
         * "_token" => "CATNE2rXs0TWtSh2I4aFNyqpYMOq15cLGwVgcKpD"`
         * ]
         */
//        if ($amount->rials() !== Input::get('FinalAmount')) {
//            return 'fake request.';
//        }
        /*
        $refId             = Input::get('RefId');
        $trackingCode      = Input::get('SaleReferenceId');
        $cardNumber        = Input::get('CardHolderPan');
        $resCode           = Input::get('ResCode');
        $saleOrderId       = Input::get('SaleOrderId');*/
        
        if (Input::get('ResCode') == 0) {
            $response = $this->verify();
            $response = $this->settleRequest();
            }

            return VerificationResponse::instance(request()->all());
    }
    
    protected function settleRequest()
    {
        /*
         * enseraf karbar :
        array:4 [▼
            "RefId" => "5925E561FF4B2421"
            "ResCode" => "17"
            "SaleOrderId" => "15"
            "_token" => "CATNE2rXs0TWtSh2I4aFNyqpYMOq15cLGwVgcKpD"
        ]
*/
        try {
            return $this->makeSoapClient()
                ->bpSettleRequest($this->getVerificationParams());
        } catch (\SoapFault $e) {
            throw $e;
        }
    }
    
    /**
     * @return array
     */
    private function getVerificationParams(): array
    {
        return [
            'terminalId'      => config('behpardakht.terminalId'),
            'userName'        => config('behpardakht.username'),
            'userPassword'    => config('behpardakht.password'),
            'orderId'         => Input::get('SaleOrderId'),
            'saleOrderId'     => Input::get('SaleOrderId'),
            'saleReferenceId' => Input::get('SaleReferenceId'),
        ];
    }
    
    /**
     * @return \SoapClient
     * @throws \SoapFault
     */
    private function makeSoapClient(): \SoapClient
    {
        return new \SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
    }
    
    /**
     * @return mixed
     * @throws \SoapFault
     */
    private function verify()
    {
        try {
            return $this->makeSoapClient()
                ->bpVerifyRequest($this->getVerificationParams());
        } catch (\SoapFault $e) {
            throw $e;
        }
    }
}