<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Traits\HandleOrderPayment;
use App\Traits\OrderCommon;
use App\Traits\ZarinpalGateway;
use Facades\App\Classes\Payment\PaymentVerifier;
use Facades\App\Classes\Payment\ZarinPal;
use Illuminate\Support\Facades\Request;

class PaymentStatusController extends Controller
{

    /**
     * @param string $status
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     * @return void
     */
    public function show(string $status, string $paymentMethod, string $device)
    {
        $result = Request::session()->pull('verifyResult');

        if ($result != null) {
            return view("order.checkout.verification", compact('status', 'paymentMethod', 'device', 'result'));
        }

        return redirect()->action('Web\UserController@userOrders');
    }
}
