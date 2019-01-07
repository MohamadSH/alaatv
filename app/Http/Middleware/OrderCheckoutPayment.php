<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OrderCheckoutPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $guard=null)
    {
        $previousPath = url()->previous();
        if (strcmp($previousPath, action("OrderController@checkoutReview")) != 0 &&
            strcmp($previousPath, action("OrderController@checkoutPayment")) != 0)
        {
            return redirect(action("OrderController@checkoutReview"));
        }

        if (Auth::guard($guard)->check())
        {
            $user = Auth::guard($guard)->user();

            if($request->has("order_id"))
            {
                if(!$user->can("constants.SHOW_ORDER_PAYMENT_ACCESS"))
                    return response([] , 403);
            }else
            {
                $openOrder = $user->openOrders()->get()->first();
                if(isset($openOrder))
                    $request->offsetSet("order_id" , $openOrder->id);
            }
        } else {
            return redirect(action("OrderController@checkoutAuth"));
        }

        return $next($request);
    }
}
