<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RemoveOrderCoupon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)
            ->check()) {
            $user = Auth::guard($guard)
                ->user();
            
            if ($request->has("order_id")) {
                if (!$user->can("constants.REMOVE_COUPON_ACCESS")) {
                    return response([], Response::HTTP_FORBIDDEN);
                }
            }
            else {
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
