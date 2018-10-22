<?php

namespace App\Http\Controllers;

use App\Events\MobileVerified;
use Illuminate\Http\Request;

class MobileVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mobile Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:1,1')->only('verify', 'resend');
    }

    /**
     * Show the mobile verification notice.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedMobile()
            ? redirect()->back()
            : view('auth.verify');
    }

    /**
     * Mark the authenticated user's mobile number as verified.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $code)
    {
        if ($code == $request->user()->getKey() &&
            $request->user()->markMobileAsVerified()) {
            event(new MobileVerified($request->user()));
        }
        return redirect()->back()->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedMobile()) {
            return redirect()->back();
        }
        $request->user()->sendMobileVerificationNotification();
        return back()->with('resent', true);
    }
}
