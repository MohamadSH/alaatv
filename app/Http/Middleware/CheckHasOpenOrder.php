<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class CheckHasOpenOrder
{
    private $orderController;
    private $user;

    public function __construct(OrderController $controller)
    {
        $this->orderController = $controller;
    }

    /**
     * Handle an incoming request.
     * set id of an open Order in request
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $this->user = $request->user()->load('openOrders');

            $openOrder = $this->user->openOrders;
            if ($openOrder->isEmpty()) {
                $request->offsetSet('paymentstatus_id', config('constants.PAYMENT_STATUS_UNPAID'));
                $request->offsetSet('orderstatus_id', config('constants.ORDER_STATUS_OPEN'));
                $request->offsetSet('user_id', $this->user->id);
                $controller = $this->orderController;
                $openOrder = $controller->store($request);
            }
            $request->user()->load('openOrders');

            return $next($request);
        } else {
            return response()->json([
                'error' => 'Unauthenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
