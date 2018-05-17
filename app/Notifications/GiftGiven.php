<?php

namespace App\Notifications;

use App\Broadcasting\MedianaChannel;
use App\Classes\sms\MedianaMessage;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class GiftGiven extends Notification implements ShouldQueue
{
    use Queueable , SerializesModels;

    /**
     * @var int
     */
    protected  $giftCost;
    /**
     * @var User
     */
    protected $user;
    public $timeout = 120;

    /**
     * Create a new notification instance.
     *
     * @param int $giftCost
     */
    public function __construct( $giftCost)
    {
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

    private function msg() : string {
        if(isset($this->user->gender_id))
        {
            if($this->user->gender->name=="خانم")
                $gender = "خانم ";
            elseif($this->user->gender->name=="آقا")
                $gender = "آقای ";
            else
                $gender = "";
        }else{
            $gender = "";
        }
        $messageCore = "مبلغ ".$this->giftCost." به عنوان هدیه به کیف پول شما افزوده شد."
            ."\n"
            ."آلاء"
            ."\n"
            ."پشتیبانی:"
            ."\n"
            ."https://goo.gl/jme5VU";
        $message = "سلام ".$gender.$this->user->getfullName()."\n".$messageCore;

        return $message;
    }

}
