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

class sendLink extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    const MEDIANA_PATTERN_CODE_USER_SEND_VERIFICATION_CODE = 'jhgzs0tb77';

    public $timeout = 120;

    /**
     * @var User
     */
    protected $user;

    protected $link;

    /**
     * Create a new notification instance.
     *
     * @param string $link
     */
    public function __construct(string $link)
    {
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
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
     *
     * @return MedianaMessage
     */
    public function toMediana($notifiable)
    {
        return (new MedianaMessage())->content($this->msg())
            ->setInputData($this->getInputData())
            ->setPatternCode(self::MEDIANA_PATTERN_CODE_USER_SEND_VERIFICATION_CODE)
            ->sendAt(Carbon::now());
    }

    private function msg(): string
    {
        return '';
    }

    private function getInputData(): array
    {
        return [
            'name' => $this->getUserFullName(),
            'link' => $this->link,
        ];
    }

    /**
     * @return mixed
     */
    private function getUserFullName(): string
    {
        $userFullName = optional($this->user)->full_name;
        return (isset($userFullName)) ? $userFullName : '';
    }
}
