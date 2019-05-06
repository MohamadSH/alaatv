<?php

namespace App\PaymentModule\Gateways\Behpardakht;

use App\PaymentModule\OnlinePaymentVerificationResponseInterface;

class VerificationResponse implements OnlinePaymentVerificationResponseInterface
{
    protected $exceptions = [
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
    
    public static function instance($result)
    {
        return new static($result);
    }
    
    public function isVerifiedBefore()
    {
        return $this->getStatus() == 43;
    }
    
    private function getStatus(): string
    {
        return $this->response['ResCode'] ?? '';
    }
    
    public function getCardPanMask()
    {
        return array_get($this->response, 'CardHolderPan', '');
    }
    
    /**
     * ` array:8 [▼
     * "RefId" => "723D241477D96CD1"
     * "ResCode" => "0"
     * "SaleOrderId" => "19"
     * "SaleReferenceId" => "150078823126"
     * "CardHolderInfo" => "DC514292D753D85BD5D91874EBD2A35DD64E8E1EC066A7A2C7D4C9C51BA994C5"
     * "CardHolderPan" => "603799******9276"
     * "FinalAmount" => "1002"
     * ]*/
    
    public function getCardHash()
    {
        return array_get($this->response, 'CardHolderInfo', '');
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
    
        $message[] = $this->exceptions[$this->getStatus()];
    
        return $message;
    }
    
    public function isSuccessfulPayment(): bool
    {
        return $this->getStatus() == '0' or $this->isVerifiedBefore();
    }
    
    public function getRefId()
    {
        return $this->response['RefId'] ?? '';
    }
    
    public function hasBeenVerifiedBefore(): bool
    {
        return $this->getStatus() == 43;
    }
    
    public function isCanceled(): bool
    {
        return $this->getStatus() == 17;
    }
}