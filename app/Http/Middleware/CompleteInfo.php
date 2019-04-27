<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CompleteInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @param  null                      $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)
                ->check() && $request->user()
                ->completion("afterLoginForm") != 100) {
            switch ($request->fullUrl()) {
                case action("Web\OrderController@checkoutReview") :
                case action("Web\OrderController@checkoutPayment") :
                    return redirect(action("Web\OrderController@checkoutCompleteInfo"));
                    break;
                default :
                    session()->put("redirectTo", $request->fullUrl());
                    
                    return redirect(action("Web\UserController@completeRegister"));
                    break;
            }
        }
        
        return $next($request);
    }
}
