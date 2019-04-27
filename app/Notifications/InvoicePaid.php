<?php

namespace App\Notifications;

use App\Broadcasting\MedianaPatternChannel;
use App\Classes\sms\MedianaMessage;
use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class InvoicePaid extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    protected const MEDIANA_PATTERN_CODE_INVOICE_PAID = 800;
    
    public $timeout = 120;
    
    /**
     * @var Order
     */
    protected $invoice;
    
    /**
     * Create a new notification instance.
     *
     * @param  Order  $invoice
     */
    public function __construct(Order $invoice)
    {
        $this->invoice = $invoice;
    }
    
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [
            MedianaPatternChannel::class,
        ];
    }
    
    /**
     * @param $notifiable
     *
     * @return MedianaMessage
     */
    public function toMediana($notifiable)
    {
        
        return (new MedianaMessage())->content($this->msg())
            ->setInputData($this->getInputData())
            ->setPatternCode(self::MEDIANA_PATTERN_CODE_INVOICE_PAID)
            ->sendAt(Carbon::now());
    }
    
    private function msg(): string
    {
        $user = $this->getInvoiceUser();
        
        return $this->getGender($user);
        
        $messageCore = "سفارش شما با موفقیت ثبت شد."."\n"."شماره سفارش:"."\n".$this->invoice->id."\n"."پشتیبانی:"."\n"."https://goo.gl/jme5VU";
        $message     = "سلام ".$gender.$user->full_name."\n".$messageCore;
        
        return $message;
    }
    
    private function getInvoiceUser(): User
    {
        return $this->invoice->user;
    }
    
    /**
     * @param  \App\User  $user
     *
     * @return string
     */
    private function getGender(User $user): string
    {
        if (!isset($user->gender_id)) {
            return "";
        }
        if ($user->gender->name == "خانم") {
            return "خانم ";
        }
        if ($user->gender->name == "آقا") {
            return "آقای ";
        }
        
        return "";
    }
    
    private function getInputData(): array
    {
        return [
            'code'                   => $this->invoice->id,
            "https://goo.gl/jme5VU " => "https://goo.gl/jme5VU",
        ];
    }
}
