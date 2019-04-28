<?php

namespace App\PaymentModule\Gateways\Zarinpal;

use App\Classes\Nullable;
use App\Classes\Payment\OnlineGatewayInterface;
use App\Classes\Payment\RedirectData;
use App\PaymentModule\Gateways\OnlinePaymentRedirectionUriInterface;
use App\PaymentModule\OnlinePaymentVerificationResponseInterface;
use DateTime;

class BehpardakhtGateWay implements OnlineGatewayInterface
{
    public $errors = [
        11 => 'شماره کارت نامعتبر است',
        12 => 'موجودی کافی نیست',
        13 => 'رمز نادرست است',
        14 => 'تعداد دفعات وارد کردن رمز بیش از حد مجاز است',
        15 => 'کارت نامعتبر است',
        16 => 'دفعات برداشت وجه بیش از حد مجاز است',
        17 => 'کاربر از انجام تراکنش منصرف شده است',
        18 => 'تاریخ انقضای کارت گذشته است',
        19 => 'مبلغ برداشت وجه بیش از حد مجاز است',
        111 => 'صادر کننده کارت نامعتبر است',
        112 => 'خطای سوییچ صادر کننده کارت',
        113 => 'پاسخی از صادر کننده کارت دریافت نشد',
        114 => 'دارنده این کارت مجاز به انجام این تراکنش نیست',
        21 => 'پذیرنده نامعتبر است',
        23 => 'خطای امنیتی رخ داده است',
        24 => 'اطلاعات کاربری پذیرنده نامعتبر است',
        25 => 'مبلغ نامعتبر است',
        31 => 'پاسخ نامعتبر است',
        32 => 'فرمت اطلاعات وارد شده صحیح نمی‌باشد',
        33 => 'حساب نامعتبر است',
        34 => 'خطای سیستمی',
        35 => 'تاریخ نامعتبر است',
        41 => 'شماره درخواست تکراری است',
        42 => 'تراکنش Sale یافت نشد',
        43 => 'قبلا درخواست Verfiy داده شده است',
        44 => 'درخواست Verfiy یافت نشد',
        45 => 'تراکنش Settle شده است',
        46 => 'تراکنش Settle نشده است',
        47 => 'تراکنش Settle یافت نشد',
        48 => 'تراکنش Reverse شده است',
        49 => 'تراکنش Refund یافت نشد.',
        412 => 'شناسه قبض نادرست است',
        413 => 'شناسه پرداخت نادرست است',
        414 => 'سازمان صادر کننده قبض نامعتبر است',
        415 => 'زمان جلسه کاری به پایان رسیده است',
        416 => 'خطا در ثبت اطلاعات',
        417 => 'شناسه پرداخت کننده نامعتبر است',
        418 => 'اشکال در تعریف اطلاعات مشتری',
        419 => 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است',
        421 => 'IP نامعتبر است',
        51 => 'تراکنش تکراری است',
        54 => 'تراکنش مرجع موجود نیست',
        55 => 'تراکنش نامعتبر است',
        61 => 'خطا در واریز',
    ];

    public function getAuthorityFromGate(string $callbackUrl, int $cost, string $description, $orderId = null): Nullable
    {
        $dateTime = new DateTime();

        $fields = [
            'terminalId' => (int)config('gateway.mellat.terminalId'),
            'userName' => config('gateway.mellat.username'),
            'userPassword' => (int)config('gateway.mellat.password'),
            'orderId' => $orderId,
            'amount' => $cost,
            'localDate' => $dateTime->format('Ymd'),
            'localTime' => $dateTime->format('His'),
            'additionalData' => $description,
            'callBackUrl' => $callbackUrl,
            'payerId' => 0,
        ];

        try {
            $soap = new \SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
            $response = $soap->bpPayRequest($fields);
        } catch (\SoapFault $e) {
            return nullable(null);
        }

        $response = explode(',', $response->return);

        if ($response[0] != '0') {
            return nullable(null, [$this->errors[$response[0]]]);
        }

        return nullable($response[1]);
    }

    public function getGatewayUrl($refId): OnlinePaymentRedirectionUriInterface
    {
        $serverUrl = 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat';
        $data = [['name' => 'RefId', 'value' => $refId,]];

        return RedirectData::instance($serverUrl, $data, 'POST');
    }

    public function getAuthorityKey(): string
    {
        return 'Authority';
    }

    public function verifyPayment($amount, $authority): OnlinePaymentVerificationResponseInterface
    {
        $refId = Input::get('RefId');
        $trackingCode = Input::get('SaleReferenceId');
        $cardNumber = Input::get('CardHolderPan');
        $payRequestResCode = Input::get('ResCode');
        if ($payRequestResCode == '0') {
            return true;
        }

        $fields = array(
            'terminalId' => config('gateway.mellat.terminalId'),
            'userName' => config('gateway.mellat.username'),
            'userPassword' => config('gateway.mellat.password'),
            'orderId' => $refId,
            'saleOrderId' => $refId,
            'saleReferenceId' => $trackingCode
        );
        try {
            $soap = new \SoapClient( 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
            $response = $soap->bpVerifyRequest($fields);
        } catch (\SoapFault $e) {
//            $this->transactionFailed();
//            $this->newLog('SoapFault', $e->getMessage());
            throw $e;
        }


        return VerificationResponse::instance();
    }

    /**
     * Send settle request
     *
     * @return bool
     *
     * @throws MellatException
     * @throws SoapFault
     */
    protected function settleRequest()
    {
        $refId = Input::get('RefId');
        $trackingCode = Input::get('SaleReferenceId');
        $cardNumber = Input::get('CardHolderPan');
        $payRequestResCode = Input::get('ResCode');

        $fields = array(
            'terminalId' => config('gateway.mellat.terminalId'),
            'userName' => config('gateway.mellat.username'),
            'userPassword' => config('gateway.mellat.password'),
            'orderId' => $refId,
            'saleOrderId' => $refId,
            'saleReferenceId' => $trackingCode
        );
        try {
            $soap = new \SoapClient( 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
            $response = $soap->bpSettleRequest($fields);
        } catch (\SoapFault $e) {
//            $this->transactionFailed();
//            $this->newLog('SoapFault', $e->getMessage());
            throw $e;
        }

        if ($response->return == '0' || $response->return == '45') {
//            $this->transactionSucceed();
//            $this->newLog($response->return, Enum::TRANSACTION_SUCCEED_TEXT);
            return true;
        }
//        $this->transactionFailed();
//        $this->newLog($response->return, MellatException::$errors[$response->return]);
//        throw new MellatException($response->return);
    }
}