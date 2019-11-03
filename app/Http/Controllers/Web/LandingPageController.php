<?php

namespace App\Http\Controllers\Web;

use App\Websitesetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    const ROOZE_DANESH_AMOOZ_USER_NECESSARY_INFO = [
            'firstName',
            'lastName' ,
            'major_id',
            'gender_id',
            'city',
            'province',
            'mobile_verified_at',
            'birthdate',
    ];

    const ROOZE_DANESH_AMOOZ_GIFT_CREDIT = 14000;

    public function __construct()
    {
        $this->callMiddlewares($this->getAuthArray());
    }

    /**
     * @return array
     */
    private function getAuthArray(): array
    {
        return ['roozeDaneshAmooz'];
    }

    /**
     * @param array $auth
     */
    private function callMiddlewares(array $auth): void
    {
        $this->middleware('auth', ['only' => $auth]);
    }

    public function roozeDaneshAmooz(Request $request)
    {
        $hasGotGiftBefore     = false;
        $user = $request->user();

        $userCompletion = $user->completion('custom' , self::ROOZE_DANESH_AMOOZ_USER_NECESSARY_INFO);
        if($userCompletion == 100){
            $depositResult =  $user->deposit( self::ROOZE_DANESH_AMOOZ_GIFT_CREDIT  , config('constants.WALLET_TYPE_GIFT'));
            if($depositResult['result']){
                $hasGotGiftBefore = true;
            }else{
                $hasGotGiftBefore = false;
            }
        }

        return view('user.completeRegister2' , compact('user' , 'hasGotGiftBefore' ));
    }
}
