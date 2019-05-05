<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

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
        $paymentMethod = $request->get('paymentMethod' , 'zarinpal');
        $device = $request->get('device' , 'android');
        $user = $request->user();

        $encryptedPostfix = $this->getEncryptedPostfix($user);

        $redirectTo = $this->getEncryptedUrl($paymentMethod, $device, $encryptedPostfix);

        return response()->json([
            'redirectUrl'   =>  $redirectTo
        ]);
    }

    /**
     * @param $user
     * @return string
     */
    private function getEncryptedPostfix($user): string
    {
        return encrypt([
            'user_id' => $user->id,
        ]);
    }

    /**
     * @param string $paymentMethod
     * @param string $device
     * @param string $encryptedPostfix
     * @return string
     */
    private function getEncryptedUrl(string $paymentMethod,string $device, string $encryptedPostfix)
    {
        $parameters = [
            'paymentMethod' => $paymentMethod,
            'device' => $device,
            'encryptionData' => $encryptedPostfix
        ];

        return URL::temporarySignedRoute(
            'redirectToPaymentRoute',
            3600,
            $parameters
        );
    }
}
