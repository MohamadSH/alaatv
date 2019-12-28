<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CompleteInfo
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check() || $request->user()->completion("afterLoginForm") == 100) {
            return $next($request);
        }

        if (in_array($request->fullUrl(), [route('checkoutReview'), route('checkoutPayment')])) {
            return redirect()->route("checkoutCompleteInfo");
        }
        session()->put("redirectTo", $request->fullUrl());

        return redirect()->route("completeRegister");

    }
}
