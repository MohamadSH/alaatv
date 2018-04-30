<?php

namespace App\Notifications;

use App\Broadcasting\MedianaChannel;
use App\Classes\sms\MedianaMessage;
use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class InvoicePaid extends Notification implements ShouldQueue
{
    use Queueable , SerializesModels;

    /**
     * @var Order
     */
    protected  $invoice;
    public $timeout = 120;

    /**
     * Create a new notification instance.
     *
     * @param Order $invoice
     */
    public function __construct(Order $invoice )
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            MedianaChannel::class,
        ];
    }

    /**
     * @param $notifiable
     * @return MedianaMessage
     */
    public function toMediana($notifiable)
    {

        return (new MedianaMessage())
            ->content($this->msg())
            ->sendAt(Carbon::now());
    }

    private function getInvoiceUser() : User {
        $user = $this->invoice->user;
        return $user;
    }

    private function msg() : string {
        $user = $this->getInvoiceUser();
        if(isset($user->gender_id))
        {
            if($user->gender->name=="خانم")
                $gender = "خانم ";
            elseif($user->gender->name=="آقا")
                $gender = "آقای ";
            else
                $gender = "";
        }else{
            $gender = "";
        }
        $messageCore = "سفارش شما با موفقیت ثبت شد."
            ."\n"
            ."شماره سفارش:"
            ."\n"
            .$this->invoice->id
            ."\n"
            ."پشتیبانی:"
            ."\n"
            ."https://goo.gl/jme5VU";
        $message = "سلام ".$gender.$user->getfullName()."\n".$messageCore;

        return $message;
    }

}
