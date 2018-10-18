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
    use Queueable , SerializesModels;

    protected const MEDIANA_PATTERN_CODE_INVOICE_PAID = 315;
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
            MedianaPatternChannel::class,
        ];
    }

    /**
     * @param $notifiable
     * @return MedianaMessage
     */
    public function toMediana($notifiable)
    {

        return (new MedianaMessage())
            ->setInputData($this->msg())
            ->setPatternCode(self::MEDIANA_PATTERN_CODE_INVOICE_PAID)
            ->sendAt(Carbon::now());
    }

    private function getInvoiceUser() : User {
        $user = $this->invoice->user;
        return $user;
    }

    private function msg(): array
    {
        return [
            'code' => $this->invoice->id
        ];
    }

}
