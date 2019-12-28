<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderCheckoutPayment
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $previousPath = url()->previous();
        if (strcmp($previousPath, action("Web\OrderController@checkoutReview")) != 0 && strcmp($previousPath,
                action("Web\OrderController@checkoutPayment")) != 0) {
            return redirect(action("Web\OrderController@checkoutReview"));
        }

        if (!Auth::guard($guard)->check()) {
            return redirect(action("Web\OrderController@checkoutAuth"));
        }

        $user = Auth::guard($guard)->user();

        if ($request->has("order_id")) {
            if (!$user->can("constants.SHOW_ORDER_PAYMENT_ACCESS")) {
                return response([], Response::HTTP_FORBIDDEN);
            }
        } else {
            /** @var User $user */
            $openOrder = $user->getOpenOrder();
            $request->offsetSet("order_id", $openOrder->id);
        }

        return $next($request);
    }
}
