<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetPaymentRedirectEncryptedLink extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $paymentMethod = $request->get('paymentMethod');
        $device = $request->get('device');
        $encryptedPostfix = encrypt($user->id);

        $encryptedRedirectUrl =  route('GetPaymentRedirectEncryptedLink', ['paymentMethod'=>$paymentMethod, 'device'=>$device , 'encryptionData'=>$encryptedPostfix]);
        $encryptedRedirectUrl .= '?sign=test';

        return response()->json([
            'redirectUrl'   =>  $encryptedRedirectUrl
        ]);
    }
}
