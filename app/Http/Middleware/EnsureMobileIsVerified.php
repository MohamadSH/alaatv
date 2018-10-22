<?php

namespace App\Http\Middleware;

use App\Classes\Verification\MustVerifyMobileNumber;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;


class EnsureMobileIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user() ||
            ($request->user() instanceof MustVerifyMobileNumber &&
                !$request->user()->hasVerifiedMobile())) {
            return $request->expectsJson()
                ? abort(Response::HTTP_FORBIDDEN, 'Your mobile number is not verified.')
                : Redirect::route('verification.notice');
        }
        return $next($request);
    }
}
