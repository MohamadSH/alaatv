<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderCheckoutReview
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
        if (Auth::guard($guard)->check())
        {
            $user = Auth::guard($guard)->user();

            if($request->has("order_id"))
            {
                if(!$user->can("constants.SHOW_ORDER_INVOICE_ACCESS"))
                    return response([] , Response::HTTP_FORBIDDEN);
            }else
            {
                //ToDo
                $openOrder = $user->openOrders->first();
//                $openOrder = $user->getOpenOrder();
                if(isset($openOrder))
                    $request->offsetSet("order_id" , $openOrder->id);
            }
        }

        return $next($request);
    }
}
