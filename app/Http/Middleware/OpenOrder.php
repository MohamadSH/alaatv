<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpenOrder
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
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

        if (!$request->has('order_id')) {
            /** @var User $user */
            $openOrder = $user->getOpenOrder();
            $request->offsetSet('order_id', $openOrder->id);
            $request->offsetSet('openOrder', $openOrder);
        }

        return $next($request);
    }
}
