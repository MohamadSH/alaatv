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

class UserRegisterd extends Notification  implements ShouldQueue
{
    use Queueable, SerializesModels;

    const MEDIANA_PATTERN_CODE_USER_REGISTERD = 799;
    public $timeout = 120;
    /**
     * @var User
     */
    protected $user;

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
        if(!isset($this->user))
            $this->user = $notifiable;

        return (new MedianaMessage())
            ->setInputData($this->msg())
            ->setPatternCode(self::MEDIANA_PATTERN_CODE_USER_REGISTERD)
            ->sendAt(Carbon::now());
    }

    private function msg(): array
    {

        return [
            'username' => $this->user->mobile,
            'password' => $this->user->nationalCode,
            "https://goo.gl/jme5VU" => "https://goo.gl/jme5VU",
        ];
    }
}
