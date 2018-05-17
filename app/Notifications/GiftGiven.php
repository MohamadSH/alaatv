<?php

namespace App\Notifications;

use App\Broadcasting\MedianaChannel;
use App\Classes\sms\MedianaMessage;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class GiftGiven extends Notification implements ShouldQueue
{
    use Queueable , SerializesModels;

    /**
     * @var Wallet
     */
    protected  $wallet;
    public $timeout = 120;

    /**
     * Create a new notification instance.
     *
     * @param Wallet $wallet
     * @param int $giftCost
     */
    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
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

    private function getWalletUser() : User {
        $user = $this->wallet->user;
        return $user;
    }

    private function msg() : string {
        $user = $this->getWalletUser();
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
        $messageCore = "مبلغی  به عنوان هدبه به کیف پول شما افزوده شد."
            ."\n"
            ."آلاء"
            ."\n"
            ."پشتیبانی:"
            ."\n"
            ."https://goo.gl/jme5VU";
        $message = "سلام ".$gender.$user->getfullName()."\n".$messageCore;

        return $message;
    }

}
