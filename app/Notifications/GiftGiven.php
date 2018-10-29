<?php

namespace App\Notifications;

use App\Broadcasting\MedianaChannel;
use App\Classes\sms\MedianaMessage;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class GiftGiven extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $timeout = 120;
    /**
     * @var int
     */
    protected $giftCost;
    /**
     * @var string
     */
    protected $partialMessage;
    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param int $giftCost
     */
    public function __construct($giftCost, $partialMessage = null)
    {
        $this->partialMessage = $partialMessage;
        $this->giftCost = $giftCost;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $this->user = $notifiable;
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

    private function msg(): string
    {
        $partialMessage = "به عنوان هدیه به کیف پول شما افزوده شد.";
        if (isset($this->partialMessage))
            $partialMessage = $this->partialMessage;
        if (isset($this->user->gender_id)) {
            if ($this->user->gender->name == "خانم")
                $gender = "خانم ";
            elseif ($this->user->gender->name == "آقا")
                $gender = "آقای ";
            else
                $gender = "";
        } else {
            $gender = "";
        }
        $messageCore = "مبلغ " . $this->giftCost . " تومان " . $partialMessage
            . "\n"
            . "آلاء"
            . "\n"
            . "پشتیبانی:"
            . "\n"
            . "https://goo.gl/jme5VU";
        $message = "سلام " . $gender . $this->user->getfullName() . "\n" . $messageCore;

        return $message;
    }

}
