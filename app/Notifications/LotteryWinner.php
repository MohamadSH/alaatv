<?php

namespace App\Notifications;

use App\Broadcasting\MedianaChannel;
use App\Classes\sms\MedianaMessage;
use App\Lottery;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class LotteryWinner extends Notification implements ShouldQueue
{
    use Queueable , SerializesModels;

    /**
     * @var int
     */
    protected  $rank;
    /**
     * @var string
     */
    protected  $prize;
    /**
     * @var Lottery
     */
    protected  $lottery;
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
    public function __construct(Lottery $lottery , $rank , $prize)
    {
        $this->lottery = $lottery;
        $this->rank = $rank;
        $this->prize = $prize ;
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
        $lotteryName = $this->lottery->name;
        $rank = $this->rank;
        $prize = $this->prize;
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

        if(strlen($prize) > 0)
            $messageCore = "شما برنده ".$rank." در قرعه کشی ".$lotteryName." شده اید. جایزه شما ".$prize." می باشد و در سریع ترین زمان به شما تقدیم خواهد شد.";
        else
            $messageCore = "شما نفر ".$rank." در قرعه کشی ".$lotteryName." شدید و متاسفانه چیزی برنده نشدید.".$prize." از اینکه در قرعه کشی شرکت نمودید سپاسگزاریم." ;

        $messageCore = $messageCore
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
