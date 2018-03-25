<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CompleteInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->completion("afterLoginForm") != 100) {
            switch ($request->fullUrl())
            {
                case action("OrderController@checkoutReview") :
                    return redirect(action("OrderController@checkoutCompleteInfo")) ;
                    break;
                case action("OrderController@checkoutPayment") :
                    return redirect(action("OrderController@checkoutCompleteInfo")) ;
                    break;
                default : {
                    session()->put("redirectTo" ,  $request->fullUrl());
                    return redirect(action("UserController@completeRegister"));
                    break;
                }
            }
        }
        return $next($request);
    }
}
