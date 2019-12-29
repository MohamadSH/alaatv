<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiveWalletCreditRequest;
use App\User;
use App\Wallet;
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

    /**
     * @param Agent $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(Agent $agent): array
    {
        return [];
    }

    /**
     * @param array $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('permission:' . config('constants.GIVE_WALLET_CREDIT'), ['only' => 'giveCredit']);
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
            } else {
                return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

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
            } else {
                return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }
    }

    public function giveCredit(GiveWalletCreditRequest $request)
    {
        $credit = $request->get('credit', 0);
        $user   =
            User::where('mobile', $request->get('mobile'))->where('nationalCode', $request->get('nationalCode'))->first();
        if (!isset($user)) {
            return response()->json([
                'error' => [
                    'code'    => Response::HTTP_NOT_FOUND,
                    'message' => 'User not found',
                ],
            ]);
        }

        $depositResult = $user->deposit($credit, config('constants.WALLET_TYPE_GIFT'));
        if ($depositResult['result']) {
            return response()->json([
                'message'      => 'Credit added successfully',
                'userFullName' => $user->full_name,
            ]);
        }

        return response()->json([
            [
                'error' => [
                    'code'    => Response::HTTP_SERVICE_UNAVAILABLE,
                    'message' => 'Unexpected error',
                ],
            ],
        ]);
    }

}
