<?php

namespace App\Http\Controllers;

use App\Bon;
use App\Lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use LuckyBox\LuckyBox;
use LuckyBox\Card\IdCard;
use Auth;

class LotteryController extends Controller
{
    public function __construct()
    {

        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Holding the lottery
     *
     */
    public function holdLottery(Request $request){
        // Setup
        $lotteryName = "" ;
        if($request->has("lottery"))
        {
            $lotteryName = $request->get("lottery") ;
        }

        $lottery = Lottery::where("name" ,  $lotteryName)
                            ->first();
        if(!isset($lottery))
            dd("Lottery not found!") ;

        $luckyBox = new LuckyBox();
        $luckyBox->setConsumable(true);
        $bonName = config("constants.BON2");
        $bon = Bon::where("name" , $bonName)->first();
        if(!isset($bon))
            dd("Unexpected error! bon not found.") ;

        $participants = \App\Userbon::where("bon_id" , $bon->id)
                                    ->where("userbonstatus_id" , 1)
                                    ->get();

        dump("number of participants: ".$participants->count()) ;
        $participantArray = array();
        foreach ($participants as $participant)
        {
            if(!in_array($participant->user->id , $participantArray))
            {
                $points = $participant->totalNumber - $participant->usedNumber ;
                for($i = $points ; $i>0 ; $i--)
                {
                    $card = new IdCard();
                    $card->setId($participant->user->id)
                        ->setRate(100);
                    $luckyBox->add($card);
                }

                array_push($participantArray , $participant->user->id) ;
            }

        }
        dump($luckyBox);
        // Draw
        $counter = 1 ;
        $successCounter = 0;
        $failedCounter = 0 ;
        $warningCounter = 0;
        while (!$luckyBox->isEmpty()) {
            $card = $luckyBox->draw();

            $user = \App\User::where("id" , $card->getId())->first();
            if(isset($user))
            {
                $userbon = \App\Userbon::where("bon_id" , $bon->id)
                                        ->where("userbonstatus_id" , 1)
                                        ->where("user_id" , $user->id)
                                        ->get()
                                        ->first();
                if(isset($userbon))
                {
                    $userbon->userbonstatus_id = 3 ;
                    $userbon->usedNumber = $userbon->totalNumber  ;
                    $userbon->update();
                }else{
                    dump("Userbon not found for user: ".$user->id) ;
                    $warningCounter++;
                }

                $userlottery =  $user->lotteries->where("lottery_id" , $lottery->id);
                if($userlottery->isEmpty())
                {
                    $user->lotteries()->attach($lottery->id,["rank"=>$counter  ]);
                    dump("#$counter: ".$user->getfullName()." - $user->mobile"." - $user->nationalCode") ;
                    $successCounter++;
                }else
                {
                    if($userlottery->first()->rank == 0)
                    {
                        dump("User ".$user->id." had been removed from lottery") ;
                        $warningCounter++;
                    }
                    else
                    {
                        dump("Critical : User ".$user->id." had been participated in lottery with rank > 0") ;
                        $failedCounter++;
                    }
                }
            }else
            {
                dump("#$counter was not found! User id: ".$card->getId());
                $warningCounter++;
            }
            $counter++ ;
        }

        dump("number of successfully processed users: ".$successCounter);
        dump("number of failed users: ".$failedCounter);
        dump("number of warnings: ".$warningCounter);
        dd("finish");
    }

    /**
     * Giving prizes the lottery winners
     *
     */
    public function givePrizes(Request $request)
    {
        $lotteryName = "" ;
        if($request->has("lottery"))
        {
            $lotteryName = $request->get("lottery") ;
        }

        $lottery = Lottery::where("name" ,  $lotteryName)->first();
        if(!isset($lottery))
            dd("Lottery not found!") ;

        $userlotteries = $lottery->users->sortBy("pivot.rank");

        $successCounter = 0 ;
        $failedCounter = 0 ;
        foreach ($userlotteries as $userlottery)
        {
            $rank = $userlottery->pivot->rank ;
            [
                $prizeName ,
                $amount
            ]= $lottery->prizes($rank);

            $done = true;
            $prizeInfo = "" ;
            if($amount != 0)
            {
                $depositResult =  $userlottery->deposit($amount , config("constants.WALLET_TYPE_GIFT"));
                $done = $depositResult["result"];
                $responseText = $depositResult["responseText"];
                $objectId = $depositResult["wallet"] ;
                $prizeInfo = '
                          "objectType": "App\\\\Wallet",
                          "objectId": "'.$objectId.'"
                          ';
            }
            if($done)
            {
                $prizes = '{
                      "items": [
                        {
                          "name": "'.$prizeName.'",'
                         .(strlen($prizeInfo)>0)?$prizeInfo:"".
                        '}
                      ]
                    }';
                $givePrizeResult = $userlottery->lotteries()->updateExistingPivot($lottery->id ,["prizes" => $prizes]);
                if(!$givePrizeResult)
                {
                    dump("Error on updating prize for user: ".$userlottery->id) ;
                    $failedCounter++ ;
                }
                $successCounter++ ;
            }
            else
            {
                dump("Error on updating wallet for user ".$userlottery->id." ".$responseText);
                $failedCounter++;
            }
        }
        dump("processed users ".$successCounter);
        dump("failed users: ".$failedCounter);
        dd("done") ;
    }
}
