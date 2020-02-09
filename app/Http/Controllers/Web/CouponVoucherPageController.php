<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class CouponVoucherPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('signed');
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function __invoke(Request $request)
    {
        $decryptedData = (array)decrypt($request->get('encryptionData'));

        $code         = Arr::get($decryptedData, 'code');
        $login        = true;
        $verifyMobile = true;
        $redirectUrl  = route('checkoutReview');

        return view('pages.couponSubmit', compact('code', 'login', 'verifyMobile', 'redirectUrl'));
    }

}
