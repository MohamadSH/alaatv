<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class SubmitOrderCoupon
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            if ($request->has("order_id")) {
                if (! $user->can("constants.ADD_COUPON_TO_ORDER")) {
                    return response([], 403);
                }
            } else {
                /** @var User $user */
                $openOrder = $user->getOpenOrder();
                if (isset($openOrder)) {
                    $request->offsetSet("order_id", $openOrder->id);
                    $request->offsetSet("openOrder", $openOrder);
                }
            }
        }

        return $next($request);
    }
}
