<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiveWalletCreditRequest;
use App\User;
use App\Wallet;
use App\Websitesetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jenssegers\Agent\Agent;

class WalletController extends Controller
{

    public function __construct(Agent $agent)
    {
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
    }


    public function store(Request $request)
    {
        $wallet = new Wallet();
        $wallet->fill($request->all());

        $done = false;
        if ($wallet->save()) {
            $done = true;
        }

        if ($request->expectsJson()) {
            if ($done) {
                return response()->json(["wallet" => $wallet]);
            }
            else {
                return response()->json( [] , Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }
    }

    public function update(Request $request, Wallet $wallet)
    {
        $wallet->fill($request->all());
        $done = false;
        if ($wallet->update()) {
            $done = true;
        }

        if ($request->expectsJson()) {
            if ($done) {
                return response()->json();
            }
            else {
                return response()->json([] , Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }
    }

    public function giveCredit(GiveWalletCreditRequest $request){
        dd('yes');
        $credit = $request->get('credit' , 0);
        $user = User::where('mobile' , $request->get('mobile'))->where('nationalCode' , $request->get('nationalCode'))->first();
        if(!isset($user)){
            session()->put('error' , 'کاربر مورد نظر یافت نشد');
            return redirect()->back();
        }

        $depositResult =  $user->deposit( $credit , config('constants.WALLET_TYPE_GIFT'));
        if($depositResult['result']){
            session()->put('success' , number_format($credit).' تومان به کیف پول '.$user->full_name.' افزوده شد');
            return redirect()->back();
        }

        session()->put('error' , 'خطا در اعطای اعتبار');
        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param  Agent  $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(Agent $agent): array
    {
        return [];
    }

    /**
     * @param  array  $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('permission:'.config('constants.GIVE_WALLET_CREDIT'), ['only' => 'giveCredit']);
    }

}
