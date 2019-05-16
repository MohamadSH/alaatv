<?php

namespace App\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class PaymentStatusController extends Controller
{
    /**
     * @param  string   $status
     * @param  string   $paymentMethod
     * @param  string   $device
     * @param  Request  $request
     *
     * @return void
     */
    public function show(string $status, string $paymentMethod, string $device)
    {
        Cache::tags('bon')->flush();
        Cache::tags('order')->flush();
        Cache::tags('user')->flush();
        Cache::tags('orderproduct')->flush();


        $result = Request::session()->pull('verifyResult');
        
        if ($result != null) {
            return view('order.checkout.verification', compact('status', 'paymentMethod', 'device', 'result'));
        }

        return redirect()->action('Web\UserController@userOrders');
    }
}
