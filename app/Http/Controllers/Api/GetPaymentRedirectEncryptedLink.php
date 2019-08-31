<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class GetPaymentRedirectEncryptedLink extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $paymentMethod = $request->get('paymentMethod', 'zarinpal');
        $device        = $request->get('device', 'android');
        $orderId       = $request->get('order_id');
        $user          = $request->user();

        $encryptedPostfix = $this->getEncryptedPostfix($user , $orderId);

        $redirectTo = $this->getEncryptedUrl($paymentMethod, $device, $encryptedPostfix);

        return response()->json([
            'url' => $redirectTo,
        ]);
    }

    /**
     * @param User $user
     *
     * @param int|null $orderId
     * @return string
     */
    private function getEncryptedPostfix(User $user , $orderId): string
    {
        $toEncrypt = ['user_id' => $user->id,];

        if(isset($orderId))
        {
            $toEncrypt = Arr::add($toEncrypt , 'order_id' , $orderId);
        }

        return encrypt($toEncrypt);
    }

    /**
     * @param string $paymentMethod
     * @param string $device
     * @param string $encryptedPostfix
     *
     * @return string
     */
    private function getEncryptedUrl(string $paymentMethod, string $device, string $encryptedPostfix)
    {
        $parameters = [
            'paymentMethod'  => $paymentMethod,
            'device'         => $device,
            'encryptionData' => $encryptedPostfix,
        ];

        return URL::temporarySignedRoute(
            'redirectToPaymentRoute',
            3600,
            $parameters
        );
    }
}
