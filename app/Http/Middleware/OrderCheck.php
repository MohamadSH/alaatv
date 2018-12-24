<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderController;
use App\Classes\Order\OrderUtility;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderCheck
{
    /**
     * @var OrderController
     */
    private $orderController;
    private $user;

    public function __construct(OrderController $controller)
    {
        $this->orderController = $controller;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param null                      $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        /**
         * Initiating an order for the user
         * at the moment he opens the website
         */
        if (Auth::guard($guard)->check()) {
            $this->user = $request->user();
            if($request->has('order_id')) {
                if($this->user->can(config("constants.INSERT_ORDERPRODUCT_ACCESS"))) {
                    return response()->json([
                        'error' => 'Forbidden'
                    ], 403);
                }
            } else {
                $this->setOpenOrderIdInRequest($request);
            }
        } else {
            return response()->json([
                'error' => 'Unauthenticated'
            ], 401);
        }
        return $next($request);
    }

    private function setOpenOrderIdInRequest(Request $request) {
        $openOrder = $this->user->openOrders()->get();
        if ($openOrder->isEmpty()) {
            $request->offsetSet("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_UNPAID"));
            $request->offsetSet("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
            $request->offsetSet("user_id", $this->user->id);
            $controller = $this->orderController;
            $order = $controller->store($request);
        } else {
            $order = $openOrder->first();
        }
        $request->offsetSet('order_id', $order->id);
        return $order;
    }
}
