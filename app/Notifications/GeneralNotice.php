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

class GeneralNotice extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $timeout = 120;
    /**
     * @var string
     */
    protected $message;
    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param int $giftCost
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
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
     *
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
        //        if(isset($this->user->gender_id))
        //        {
        //            if($this->user->gender->name=="خانم")
        //                $gender = "خانم ";
        //            elseif($this->user->gender->name=="آقا")
        //                $gender = "آقای ";
        //            else
        //                $gender = "";
        //        }else{
        //            $gender = "";
        //        }

        $messageCore = $this->message;
        //        $message = "سلام ".$gender.$this->user->full_name."\n".$messageCore;
        $message = $messageCore;

        return $message;
    }

}
