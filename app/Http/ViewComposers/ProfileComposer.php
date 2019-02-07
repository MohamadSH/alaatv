<?php

namespace App\Http\ViewComposers;


use App\Gender;
use App\Major;
use App\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileComposer
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new Profile composer.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->user = $this->request->user();
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {

        $genders = Gender::pluck('name', 'id')
            ->prepend("نامشخص");
        $majors = Major::pluck('name', 'id')
            ->prepend("نامشخص");
        $sideBarMode = "closed";

        /** LOTTERY */
        [
            $exchangeAmount,
            $userPoints,
            $userLottery,
            $prizeCollection,
            $lotteryRank,
            $lottery,
            $lotteryMessage,
            $lotteryName,
        ] = $this->user->getLottery();

        $view->with(compact('genders', 'majors', 'sideBarMode', 'exchangeAmount', 'userPoints', 'userLottery', 'prizeCollection', 'lotteryRank', 'lottery', 'lotteryMessage', 'lotteryName'));
    }
}