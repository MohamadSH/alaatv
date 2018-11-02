<?php

namespace App\Http\Controllers;

use App\Events\MobileVerified;
use App\Http\Requests\SubmitVerificationCode;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Redirect;

class MobileVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mobile Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling mobile verification for any
    | user that recently registered with the application. Mobiles may also
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
        $this->middleware('throttle:1,1')
             ->only('resend');
        $this->middleware('throttle:10,1')
             ->only('verify');
    }

    /**
     * Show the mobile verification notice.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user()
                       ->hasVerifiedMobile()
            ? back()
            : view('auth.verify');
    }

    /**
     * Mark the authenticated user's mobile number as verified.
     *
     * @param SubmitVerificationCode $request
     * @param                        $code
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(SubmitVerificationCode $request)
    {
        $user = $request->user();
        $verified = false;
        if ($request->code == $user->getMobileVerificationCode() &&
            $user->markMobileAsVerified()) {
            event(new MobileVerified($user));
            $verified = true;
        }

        if ($verified)
            return response()
                ->json()
                ->setStatusCode(Response::HTTP_OK)
                ->setContent(\Lang::get('verification.Your mobile number is verified.'));
        else
            $request->expectsJson()
                ? abort(Response::HTTP_FORBIDDEN, \Lang::get('verification.Your code is wrong.'))
                : Redirect::route('verification.notice');
    }

    /**
     * Resend the mobile verification notification.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()
                    ->hasVerifiedMobile()) {
            return $request->expectsJson()
                ? abort(Response::HTTP_FORBIDDEN, \Lang::get('verification.Your mobile number is verified.'))
                : Redirect::route('verification.notice');

        }

        $request->user()
                ->sendMobileVerificationNotification();

        return response()
            ->json()
            ->setStatusCode(Response::HTTP_OK)
            ->setContent(\Lang::get('verification.Verification code is sent.'));
    }
}
