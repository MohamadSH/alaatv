<?php

namespace App\Notifications;

use App\Broadcasting\MedianaChannel;
use App\Classes\sms\MedianaMessage;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class UserRegisterd extends Notification  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $timeout = 120;
    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct()
    {
        //

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
        if(!isset($this->user))
            $this->user = $notifiable;

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
        $messageCore = "به آلاء خوش آمدید، اطلاعات کاربری شما:"
            ."\n"
            ."نام کاربری:"
            ."\n"
            .$this->user->mobile
            ."\n"
            ."رمز عبور:"
            ."\n"
            .$this->user->nationalCode
            ."\n"
            ."پشتیبانی:"
            ."\n"
            ."https://goo.gl/jme5VU";
        $message = "سلام ".$gender.$this->user->getfullName()."\n".$messageCore;

        return $message;
    }
}
