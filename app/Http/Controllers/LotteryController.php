<?php

namespace App\Http\Controllers;

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
    public function holdLottery(){
        // Setup
        $lottery = Lottery::where("name" ,  Config::get("constants.LOTTERY_NAME"))
                            ->get()
                            ->first() ;
        if(!isset($lottery))
            dd("Lottery not found!") ;

        $luckyBox = new LuckyBox();
        $luckyBox->setConsumable(true);
        $participants = \App\Userbon::where("bon_id" , 2)->where("userbonstatus_id" , 1)
                                                        ->get();

        echo "number of participants: ".$participants->count() ;
        $participantArray = array();
        foreach ($participants as $participant)
        {
            if(!in_array($participant->user->id , $participantArray))
            {
                $card = new IdCard();

                $card->setId($participant->user->id)
                    ->setRate(100);

                $luckyBox->add($card);
                array_push($participantArray , $participant->user->id) ;
            }

        }
//        dd($luckyBox);
        // Draw
        $counter = 1 ;
        while (!$luckyBox->isEmpty()) {
            $card = $luckyBox->draw();

            $user = \App\User::where("id" , $card->getId())->get()
                                                            ->first();
            if($user)
            {
                $userbon = \App\Userbon::where("bon_id" , 2)
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
                    dump("userbon not found for user: ".$user->id) ;
                }

                $userlottery =  $user->lotteries->where("lottery_id" , $lottery->id);
                if($userlottery->isEmpty())
                {
                    if($counter==1)
                    {
                        $prizeName = "یک ربع سکه بهار آزادی";
                    }elseif($counter > 1 && $counter <= 8)
                    {
                        $prizeName = "یک همایش 1 + 5 به دلخواه و رایگان";
                    }elseif($counter > 8 && $counter <= 108 )
                    {
                        $prizeName = "کد تخفیف با 60% درصد تخفیف"; //ToDo : name code takhfif
                    }elseif($counter > 108 && $counter <= 309 )
                    {
                        $prizeName = "کد تخفیف با 45% درصد تخفیف"; //ToDo : name code takhfif
                    }
                    $prizes = '{
                          "items": [
                            {
                              "name": "'.$prizeName.'"
                            }
                          ]
                        }';
                    $user->lotteries()->attach($lottery->id,["rank"=>$counter , "prizes"=>$prizes ]);
                    dump("#$counter: ".$user->getfullName()." - $user->mobile"." - $user->nationalCode") ;
                }else
                {
                    if($userlottery->first()->rank == 0)
                        dump("User ".$user->id." had been removed from lottery") ;
                    else
                        dump("Critical : User ".$user->id." had been participated in lottery with rank > 0") ;
                }
            }else
            {
                dump("#$counter was not found! User id: ".$card->getId());
            }
            $counter++ ;
        }
        dd("finish");
    }

    /**
     * Giving prizes the lottery winners
     *
     */
    public function givePrizes()
    {
        abort(404) ;

        $lottery = \App\Lottery::where("name" , Config::get("constants.LOTTERY_NAME"))->get()->first();
        $userlotteries = $lottery->users->where("pivot.rank" ,">" ,  8 )->sortBy("pivot.rank");

        $counter = 0 ;
        $couponController = new \App\Http\Controllers\CouponController() ;
        foreach ($userlotteries as $userlottery)
        {
            $counter++ ;
            $rank = $userlottery->pivot->rank ;
            do {
                $couponCode = str_random(5);
            }while(\App\Coupon::where("code" , $couponCode)->get()->isNotEmpty());

            $insertCouponRequest = new \App\Http\Requests\InsertCouponRequest() ;
            $insertCouponRequest->offsetSet("enable" , 1);
            $insertCouponRequest->offsetSet("name" , "قرعه کشی همایش 1 + 5 برای ".$userlottery->getFullName());
            $insertCouponRequest->offsetSet("description" , "جایزه قرعه کشی");
            $insertCouponRequest->offsetSet("code" , $couponCode);
            $insertCouponRequest->offsetSet("usageNumber" , 0);
            $insertCouponRequest->offsetSet("usageLimit" , 1);
            $insertCouponRequest->offsetSet("limitStatus" , 1);
            $insertCouponRequest->offsetSet("coupontype_id" , 2);
            $couponProducts = \App\Product::whereNotIn("id" , [167,168,169,174,175,170,171,172,173,179,180,176,177,178])->get()->pluck('id')->toArray();
            $insertCouponRequest->offsetSet("products" , $couponProducts);
            $insertCouponRequest->offsetSet("validSince" , "2017-12-17T00:00:00");
            $insertCouponRequest->offsetSet("validUntil" , "2017-12-28T24:00:00");

            if($rank > 8 && $rank <= 108 )
            {
                $insertCouponRequest->offsetSet("discount" , 60);
                $prizeName = "کد تخفیف ".$couponCode." با 60% درصد تخفیف";
            }elseif($rank > 108 && $rank <= 309 )
            {
                $insertCouponRequest->offsetSet("discount" , 45);
                $prizeName = "کد تخفیف ".$couponCode." با 45% درصد تخفیف";
            }
            $storeCoupon = $couponController->store($insertCouponRequest);
            if($storeCoupon->status() == 200){
                $openOrder = $userlottery->openOrders()->get()->first();
                if(isset($openOrder))
                {
                    session()->forget("order_id");
                    session()->put("order_id" , $openOrder->id);
                    $attachCouponRequest = new \App\Http\Requests\SubmitCouponRequest() ;
                    $attachCouponRequest->offsetSet("coupon" , $couponCode);
                    $orderController = new \App\Http\Controllers\OrderController();
                    $orderController->submitCoupon($attachCouponRequest) ;
                    session()->forget('couponMessageError');
                    session()->forget('couponMessageSuccess');
                }

                $couponId = json_decode($storeCoupon->content())->id;
                $prizes = '{
                          "items": [
                            {
                              "name": "'.$prizeName.'",
                              "objectType": "App\\\\Coupon",
                              "objectId": "'.$couponId.'"
                            }
                          ]
                        }';
                if(!$userlottery->lotteries()->updateExistingPivot($lottery->id ,["prizes" => $prizes])){
                    dump("Error on updating prize for user: ".$userlottery->id) ;
                }
            }else{
                dump("Error on creating coupon for user: ".$userlottery->id) ;
            }
        }
        dd("processed winners: ".$counter);

        /**checking session */
//        dd(session()->all());
        /**  **/
    }
}
