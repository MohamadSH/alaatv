<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VoucherPageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $code = $request->get('code');

        $mobile = null;
        if (isset($user)) {
            $mobile = $user->mobile;
        }

        $hasVerifiedMobile = $user->hasVerifiedMobile();
        $isUserVerified    = false;
        if ($hasVerifiedMobile) {
            $isUserVerified = true;
        }

        return view('auth.voucherLogin', compact('mobile', 'isUserVerified', 'code'));
    }
}
