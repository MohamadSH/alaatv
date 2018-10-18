<?php

namespace App\Notifications;

use App\Broadcasting\MedianaPatternChannel;
use App\Classes\sms\MedianaMessage;
use App\Lottery;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class LotteryWinner extends Notification implements ShouldQueue
{
    use Queueable , SerializesModels;
    const MEDIANA_PATTERN_CODE_LOTTERY_WINNER = 315;
    const MEDIANA_PATTERN_CODE_LOTTERY_LOOSER = 315;
    const MEDIANA_PATTERN_CODE_MEMORIAL = 315;

    /**
     * @var int
     */
    protected  $rank;
    /**
     * @var string
     */
    protected  $prize;
    /**
     * @var string
     */
    protected  $memorial;
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
     * @param Lottery $lottery
     * @param $rank
     * @param $prize
     * @param $memorial
     */
    public function __construct(Lottery $lottery , $rank , $prize , $memorial)
    {
        $this->lottery = $lottery;
        $this->rank = $rank;
        $this->prize = $prize ;
        $this->memorial = $memorial ;
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
            ->setPatternCode($this->getPatternCode())
            ->sendAt(Carbon::now());
    }

    private function getPatternCode(): int
    {
        if (strlen($this->prize) > 0)
            return self::MEDIANA_PATTERN_CODE_LOTTERY_WINNER;
        elseif (strlen($this->memorial) > 0)
            return self::MEDIANA_PATTERN_CODE_MEMORIAL;
        else
            return self::MEDIANA_PATTERN_CODE_LOTTERY_LOOSER;
    }

    private function msg(): array
    {
        $lotteryName = $this->lottery->displayName;
        return [
            'rank' => $this->rank,
            'name' => $lotteryName,
            'prize' => (strlen($this->prize) > 0 ? $this->prize : $this->memorial)
        ];
    }

}
