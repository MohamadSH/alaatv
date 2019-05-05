<?php

namespace App\PaymentModule\Gateways\Behpardakht;

use App\PaymentModule\Gateways\OnlinePaymentVerificationResponseInterface;
use Carbon\Carbon;

class VerificationResponse implements OnlinePaymentVerificationResponseInterface
{
    protected $exceptions = [
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
        
        /*if ($this->response['error']) {
            $message[] = $this->exceptions[$this->response['error']];
        }*/
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