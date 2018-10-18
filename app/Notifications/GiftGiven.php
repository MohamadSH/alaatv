<?php

namespace App\Notifications;

use App\Broadcasting\MedianaPatternChannel;
use App\Classes\sms\MedianaMessage;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class GiftGiven extends Notification implements ShouldQueue
{
    use Queueable , SerializesModels;
    protected const MEDIANA_PATTERN_CODE_GIFT_GIVEN = 315;

    /**
     * @var int
     */
    protected  $giftCost;
    /**
     * @var string
     */
    protected  $partialMessage;
    /**
     * @var User
     */
    protected $user;
    public $timeout = 120;

    /**
     * Create a new notification instance.
     *
     * @param int $giftCost
     * @param null $partialMessage
     */
    public function __construct( $giftCost , $partialMessage = null)
    {
        $this->partialMessage = $partialMessage ;
        $this->giftCost = $giftCost;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $this->user = $notifiable;
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
            ->setPatternCode(self::MEDIANA_PATTERN_CODE_GIFT_GIVEN)
            ->sendAt(Carbon::now());
    }

    private function msg(): array
    {
        return [
            'amount' => $this->giftCost,
        ];
    }

}
