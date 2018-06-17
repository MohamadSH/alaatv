<?php

namespace App\Http\Controllers;

use App\Bon;
use App\Lottery;
use App\Notifications\GiftGiven;
use App\Notifications\LotteryWinner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use LuckyBox\LuckyBox;
use LuckyBox\Card\IdCard;
use Auth;

class LotteryController extends Controller
{

    private $response;
    public function __construct()
    {

        $this->middleware('role:admin');
        $this->response = new response();
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
    public function holdLottery(Request $request)
    {
      try {
          // Setup
          $lotteryName = "";
          if ($request->has("lottery")) {
              $lotteryName = $request->get("lottery");
          }

          $lottery = Lottery::where("name", $lotteryName)
              ->first();
          if (!isset($lottery))
              dd("Lottery not found!");

          $bonName = config("constants.BON2");
          $bon = Bon::where("name", $bonName)->first();
          if (!isset($bon))
              dd("Unexpected error! bon not found.");

          $luckyBox = new LuckyBox();
          $luckyBox->setConsumable(true);

          $participants = \App\Userbon::where("bon_id", $bon->id)
                                      ->where("userbonstatus_id", 1)
                                      ->get();

          dump("Number of participants: " . $participants->count());
          dump("Sum of total points: " . $participants->sum("totalNumber"));
          $participantArray = array();
          foreach ($participants as $participant) {
              if (in_array($participant->user->id, $participantArray))
                  continue;
              else
                  array_push($participantArray, $participant->user->id);

              $points = $participant->totalNumber - $participant->usedNumber;
              for ($i = $points; $i > 0; $i--) {
                  $card = new IdCard();
                  $card->setId($participant->user->id)
                      ->setRate(100);
                  $luckyBox->add($card);
              }
          }
          dump($luckyBox);
          // Draw
          $counter = 0;
          $successCounter = 0;
          $failedCounter = 0;
          $warningCounter = 0;
          $winners = array();
          while (!$luckyBox->isEmpty())
          {
              $card = $luckyBox->draw();
              $cardId = $card->getId();

              if(in_array($cardId , $winners))
                    continue ;

              $user = \App\User::where("id", $cardId)->first();
              if (isset($user))
              {
                  $userbon = $user->userbons->where("bon_id", $bon->id)
                                              ->where("userbonstatus_id", 1)
                                              ->first();

                  if (isset($userbon))
                  {
                      $userbon->userbonstatus_id = 3;
                      $userbon->usedNumber = $userbon->totalNumber;
                      $userbon->update();
                  }
                  else
                  {
                      dump("Warning! Userbon not found for user: " . $user->id);
                      $warningCounter++;
                  }

                  $userlotteries = $user->lotteries->where("lottery_id", $lottery->id);
                  if ($userlotteries->isEmpty())
                  {
                      $counter++;
                      $user->lotteries()->attach($lottery->id, ["rank" => $counter]);
                      echo "<span style='color:red;font-weight: bolder'>". "#$counter: " ."</span>". $user->getfullName() . " - $user->mobile" . " - $user->nationalCode";
                      echo "<br>";
                      $successCounter++;

                      [
                          $prizeName ,
                          $amount
                      ]= $lottery->prizes($counter);

                      $user->notify(new LotteryWinner($lottery , $counter , $prizeName));
                      echo "<span style='color:green;font-weight: bolder'>User notified</span>";
                      echo "<br>";



                      array_push($winners , $cardId) ;
                  }
                  else
                  {
                      if ($userlotteries->first()->pivot->rank == 0) {
                          dump("Warning! User " . $user->id . " had been removed from lottery");
                          $warningCounter++;
                      } else {
                          dump("Failed : User " . $user->id . " had been participated in lottery with rank > 0");
                          $failedCounter++;
                      }
                  }
              } else {
                  dump("Warning! #$counter was not found! User id: " . $card->getId());
                  $warningCounter++;
              }
          }

          dump("number of successfully processed users: " . $successCounter);
          dump("number of failed users: " . $failedCounter);
          dump("number of warnings: " . $warningCounter);
          dd("finish");
      }
      catch(\Exception $e)
      {
          $message = "unexpected error";
          dump($successCounter." users successfully done");
          dump($failedCounter." users failed");
          dump($warningCounter." warnings");
          return $this->response->setStatusCode(503)->setContent(["message" => $message,"number of successfully processed items"=>$counter, "error" => $e->getMessage(), "line" => $e->getLine()]);
      }
    }

    /**
     * Giving prizes the lottery winners
     *
     */
    public function givePrizes(Request $request)
    {
        abort(403);
        try
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
            dump("Number of participants: ".$userlotteries->count());
            foreach ($userlotteries as $userlottery)
            {
                $rank = $userlottery->pivot->rank ;
                [
                    $prizeName ,
                    $amount
                ]= $lottery->prizes($rank);

                if(strlen($prizeName) == 0)
                    continue;

                $done = true;
                $prizeInfo = "" ;
                if($amount > 0)
                {
                    $depositResult =  $userlottery->deposit($amount , config("constants.WALLET_TYPE_GIFT"));
                    $done = $depositResult["result"];
                    $responseText = $depositResult["responseText"];
                    if($done)
                    {
                    $userlottery->notify(new GiftGiven($amount));
                        echo "<span style='color:green' >"."Notification sent to user :".$userlottery->lastName."</span>";
                        echo "<br>";
                        $objectId = $depositResult["wallet"] ;
                        $prizeInfo = '
                          "objectType": "App\\\\Wallet",
                          "objectId": "'.$objectId.'"
                          ';
                    }
                }
                if($done)
                {
                    if(strlen($prizeInfo) > 0)
                    {
                        $prizes = '{
                      "items": [
                        {
                          "name": "'.$prizeName.'",'
                            .$prizeInfo.
                            '}
                      ]
                    }';
                    }
                    else
                    {
                        $prizes = '{
                      "items": [
                        {
                          "name": "'.$prizeName.'"
                        }
                          ]
                    }';

                    }

                    $givePrizeResult = $userlottery->lotteries()
                        ->where("lottery_id" , $lottery->id)
                        ->where("pivot.rank" , $rank)
                        ->updateExistingPivot($lottery->id ,["prizes" => $prizes]);
                    if(!$givePrizeResult)
                    {
                        dump("Failed on updating prize for user: ".$userlottery->id) ;
                        $failedCounter++ ;
                    }
                    else
                    {
                        $successCounter++ ;
                    }
                }
                else
                {
                    dump("Failed on updating wallet for user ".$userlottery->id." ".$responseText);
                    $failedCounter++;
                }
            }
            dump("Successfully processed users ".$successCounter);
            dump("ّFiled users: ".$failedCounter);
            dd("done") ;
        }
        catch(\Exception $e)
        {
            $message = "unexpected error";
            return $this->response
                        ->setStatusCode(503)
                        ->setContent([
                            "message" => $message,
                            "error" => $e->getMessage(),
                            "line" => $e->getLine()
                        ]);
                    }

    }
}
