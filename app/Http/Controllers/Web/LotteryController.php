<?php

namespace App\Http\Controllers\Web;

use App\Bon;
use App\Http\Controllers\Controller;
use App\Lottery;
use App\Notifications\GiftGiven;
use App\Notifications\LotteryWinner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LuckyBox\Card\IdCard;
use LuckyBox\LuckyBox;

class LotteryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Holding the lottery
     * @param Request $request
     * @return Response
     */
    public function holdLottery(Request $request)
    {
        dd('Access denied');
        $counter        = 0;
        $successCounter = 0;
        $failedCounter  = 0;
        $warningCounter = 0;
        try {
            // Setup
            $lotteryName = '';
            if ($request->has('lottery')) {
                $lotteryName = $request->get('lottery');
            }
            
            $lottery = Lottery::where('name', $lotteryName)->first();
            if (!isset($lottery)) {
                dd('Lottery not found!');
            }
            
            $bonName = config('constants.BON2');
            $bon     = Bon::where('name', $bonName)
                ->first();
            if (!isset($bon)) {
                dd('Unexpected error! bon not found.');
            }
            
            $luckyBox = new LuckyBox();
            $luckyBox->setConsumable(true);
            
            $participants = \App\Userbon::where('bon_id', $bon->id)
                ->where('userbonstatus_id', 1)
                ->get();
            
            dump('Number of userbons: '.$participants->count());
            dump('Sum of total points: '.$participants->sum('totalNumber'));
            
            $participantArray = [];
            foreach ($participants as $participant) {
                $points = $participant->totalNumber - $participant->usedNumber;
                for ($i = $points; $i > 0; $i--) {
                    $card = new IdCard();
                    $card->setId($participant->user->id)
                        ->setRate(100);
                    $luckyBox->add($card);
                }
            }
            dump($luckyBox);
//            dd('stop');
            // Draw
            $winners        = [];
            while (!$luckyBox->isEmpty()) {
                $card   = $luckyBox->draw();
                $cardId = $card->getId();

                $user = \App\User::where('id', $cardId)->first();
                if (isset($user)) {
                    $userbon = $user->userbons->where('bon_id', $bon->id)
                        ->where('userbonstatus_id', 1)
                        ->first();
                    
                    if (isset($userbon)) {
                        $userbon->userbonstatus_id = 3;
                        $userbon->usedNumber       = $userbon->totalNumber;
                        $userbon->update();
                    }

                    if (in_array($cardId, $winners)) {
                        continue;
                    }

                    $userlotteries = $user->lotteries->where('lottery_id', $lottery->id);
                    if ($userlotteries->isEmpty()) {
                        $counter++;
                        $user->lotteries()
                            ->attach($lottery->id, ['rank' => $counter]);
                        echo "<span style='color:red;font-weight: bolder'>"."#$counter: "."</span>".$user->full_name." - $user->mobile"." - $user->nationalCode"." Points: ".$userbon->totalNumber;
                        echo '<br>';
                        $successCounter++;
                        
                        //                        [
                        //                            $prizeName ,
                        //                            $amount
                        //                        ]= $lottery->prizes($counter);
                        
                        //                      $user->notify(new LotteryWinner($lottery , $counter , $prizeName));
                        //                      echo '<span style='color:green;font-weight: bolder'>User notified</span>';
                        //                      echo '<br>';
                        
                        array_push($winners, $cardId);
                    }
                    else {
                        if ($userlotteries->first()->pivot->rank == 0) {
                            dump('Warning! User '.$user->id.' had been removed from lottery');
                            $warningCounter++;
                        }
                        else {
                            dump('Error : User '.$user->id.' had been participated in lottery with rank > 0');
                            $failedCounter++;
                        }
                    }
                }
                else {
                    dump('Warning! #$counter was not found! User id: '.$card->getId());
                    $warningCounter++;
                }
            }
            
            dump('number of successfully processed users: '.$successCounter);
            dump('number of failed users: '.$failedCounter);
            dump('number of warnings: '.$warningCounter);
            dd('finish');
        } catch (\Exception $e) {
            dump($successCounter.' users successfully done');
            dump($failedCounter.' users failed');
            dump($warningCounter.' warnings');
            
            return response()->json( [
                'message'                                => 'unexpected error',
                'number of successfully processed items' => $counter,
                'error'                                  => $e->getMessage(),
                'line'                                   => $e->getLine(),
            ] , Response::HTTP_SERVICE_UNAVAILABLE );
        }
    }

    /**
     * Giving prizes the lottery winners
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function givePrizes(Request $request)
    {
        dd('Access denied');
        try {
            $lotteryName = '';
            if ($request->has('lottery')) {
                $lotteryName = $request->get('lottery');
            }
            
            $lottery = Lottery::where('name', $lotteryName)
                ->first();
            if (!isset($lottery)) {
                dd('Lottery not found!');
            }

            /** @var Lottery $lottery */
            $userlotteries = $lottery->users->sortBy('pivot.rank');
            
            $successCounter = 0;
            $failedCounter  = 0;
            dump('Number of participants: '.$userlotteries->count());
            foreach ($userlotteries as $userlottery) {
                $rank = $userlottery->pivot->rank;
                [
                    $prizeName,
                    $amount,
                    $memorial,
                ] = $lottery->prizes($rank);
                
                $done      = true;
                $prizeInfo = '';
                if ($amount > 0) {
                    $depositResult = $userlottery->deposit($amount, config('constants.WALLET_TYPE_GIFT'));
                    $done          = $depositResult['result'];
                    $responseText  = $depositResult['responseText'];
                    
                    if ($done) {
//                        $userlottery->notify(new GiftGiven($amount));
                        echo "<span style='color:green' >"."Wallet notification sent to user :".$userlottery->lastName."</span>";
                        echo '<br>';
                        
                        $objectId  = $depositResult['wallet'];
                        $prizeInfo = '
                          "objectType": "App\\\\Wallet",
                          "objectId": "'.$objectId.'"
                          ';
                    }
                }
                else {
                    if (strlen($memorial) > 0) {
                        $objectId  = 543;
                        $prizeInfo = '
                          "objectType": "App\\\\Coupon",
                          "objectId": "'.$objectId.'"
                          ';
                    }
                }
                
                if ($done) {
                    if (strlen($prizeName) == 0) {
//                        $userlottery->notify(new LotteryWinner($lottery, $rank, $prizeName, $memorial));
                        echo "<span style='color:green;font-weight: bolder'>User ".$userlottery->mobile." with rank ".$rank." notified</span>";
                        echo '<br>';
                    }
                    
                    $itemName = '';
                    if (strlen($prizeName) > 0) {
                        $itemName = $prizeName;
                    }
                    else {
                        if (strlen($memorial) > 0) {
                            $itemName = $memorial;
                        }
                    }
                    
                    $prizes = '';
                    if (strlen($prizeInfo) > 0) {
                        $prizes = '{
                      "items": [
                        {
                          "name": "'.$itemName.'",'.$prizeInfo.'}
                      ]
                    }';
                    }
                    else {
                        if (strlen($itemName) > 0) {
                            $prizes = '{
                      "items": [
                        {
                          "name": "'.$itemName.'"
                        }
                          ]
                    }';
                        }
                    }
                    
                    $pivotArray = [];
                    if (strlen($prizes) > 0) {
                        $pivotArray['prizes'] = $prizes;
                    }
                    
                    if (!empty($pivotArray)) {
                        $givePrizeResult = $userlottery->lotteries()
                            ->where('lottery_id', $lottery->id)
                            ->where('pivot.rank',
                                $rank)
                            ->updateExistingPivot($lottery->id, $pivotArray);
                        
                        if (!$givePrizeResult) {
                            dump('Failed on updating prize for user: '.$userlottery->id);
                            $failedCounter++;
                        }
                        else {
                            $successCounter++;
                        }
                    }
                    else {
                        $successCounter++;
                    }
                }
                else {
                    dump('Failed on updating wallet for user '.$userlottery->id.' '.$responseText);
                    $failedCounter++;
                }
            }
            dump('Successfully processed users '.$successCounter);
            dump('ّFiled users: '.$failedCounter);
            dd('done');
        } catch (\Exception $e) {
            return response()->json( [
                'message' => 'unexpected error',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
