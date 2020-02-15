<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SubmitOrderCoupon
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return $next($request);
        }

        $user = Auth::guard($guard)->user();

        if ($request->has('order_id')) {
            if (!$user->can('constants.ADD_COUPON_TO_ORDER')) {
                return response([], Response::HTTP_FORBIDDEN);
            }
        }

        return $next($request);
    }
}
