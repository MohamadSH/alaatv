<?php

namespace App\Http\Controllers\Web;

use App\Events\MobileVerified;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitVerificationCode;
use App\User;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Redirect;
use Lang;

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
     * @param Request $request
     *
     * @return Response
     */
    public function show(Request $request)
    {
        return $request->user()
            ->hasVerifiedMobile() ? back() : view('auth.verify');
    }

    /**
     * Mark the authenticated user's mobile number as verified.
     *
     * @param SubmitVerificationCode   $request
     * @param                          $code
     *
     * @return Response
     */
    public function verify(SubmitVerificationCode $request)
    {
        $user     = $request->user();
        $verified = false;
        if ($request->code == $user->getMobileVerificationCode() && $user->markMobileAsVerified()) {
            event(new MobileVerified($user));
            $verified = true;
        }

        if ($verified) {
            return response([
                'user'    => $user,
                'message' => Lang::get('verification.Your mobile number is verified.'),
            ], Response::HTTP_OK);
        } else {
            $request->expectsJson() ? abort(Response::HTTP_FORBIDDEN,
                Lang::get('verification.Your code is wrong.')) : Redirect::route('verification.notice');
        }
    }

    /**
     * Resend the mobile verification notification.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function resend(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        if ($user->hasVerifiedMobile()) {
            return $request->expectsJson() ? abort(Response::HTTP_FORBIDDEN,
                Lang::get('verification.Your mobile number is verified.')) : Redirect::route('verification.notice');
        }

        $user->sendMobileVerificationNotification();

        return response([
            'message' => Lang::get('verification.Verification code is sent.'),
        ], Response::HTTP_OK);
    }
}
