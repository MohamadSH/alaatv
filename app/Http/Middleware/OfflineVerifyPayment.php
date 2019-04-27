<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OfflineVerifyPayment
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
        if ($request->has("coi")) {
            $request->offsetSet("order_id", $request->coi);
        }
        elseif (Auth::guard($guard)
            ->check()) {
            $user      = $request->user();
            $openOrder = $user->openOrders->first();
            if (isset($openOrder)) {
                $request->offsetSet("order_id", $openOrder->id);
            }
        }
        else {
            return response()
                ->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->setContent(["message" => "Bad input"]);
        }
        
        return $next($request);
    }
}
