<?php

namespace App\PaymentModule\Gateways\Zarinpal;

use App\PaymentModule\OnlinePaymentVerificationResponseInterface;
use Carbon\Carbon;

class VerificationResponse implements OnlinePaymentVerificationResponseInterface
{
    protected $exceptions = [
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
    ];
    
    private $response;
    
    /**
     * VerificationResponse constructor.
     *
     * @param $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }
    
    public static function instance($result) : OnlinePaymentVerificationResponseInterface
    {
        return new static($result);
    }
    
    public function isVerifiedBefore()
    {
        return $this->getStatus() === 'verified_before';
    }
    
    private function getStatus(): string
    {
        return $this->response['Status'] ?? '';
    }
    
    public function getCardPanMask()
    {
        return array_get($this->response, 'ExtraDetail.Transaction.CardPanMask');
    }
    
    public function getCardHash()
    {
        return array_get($this->response, 'ExtraDetail.Transaction.CardPanHash');
    }
    
    public function getMessages()
    {
        if ($this->isSuccessfulPayment()) {
            
            $message = ['پرداخت کاربر تایید شد.'];
            if ($this->hasBeenVerifiedBefore()) {
                $message[] = $this->exceptions[101];
            }
            
            return $message;
        }
        
        if ($this->isCanceled()) {
            return ['کاربر از پرداخت انصراف داده است.'];
        }
        
        $message = ['خطایی در پرداخت رخ داده است.'];
        
        if ($this->response['error']) {
            $message[] = $this->exceptions[$this->response['error']];
        }
    }
    
    public function isSuccessfulPayment(): bool
    {
        return in_array($this->getStatus(), ['verified_before', 'success',]) && $this->getRefId();
    }
    
    public function getRefId()
    {
        if (app()['zarinpal.isSandBox']) {
            return 'sandbox'.Carbon::now()->timestamp;
        }
        
        return $this->response['RefID'] ?? '';
    }
    
    public function hasBeenVerifiedBefore(): bool
    {
        return $this->getStatus() === 'verified_before';
    }
    
    public function isCanceled(): bool
    {
        return $this->getStatus() === 'canceled';
    }
}