<?php

namespace App\Http\Middleware;

use App\Order;
use Closure;
use Illuminate\Http\Request;

class IsOrderEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has("order_id")) {
            $order = Order::Find($request->order_id);
            if (isset($order) and $order->orderproducts->isEmpty()) {
                return redirect(action("Web\OrderController@checkoutReview"));
            }
        }

        return $next($request);
    }
}
