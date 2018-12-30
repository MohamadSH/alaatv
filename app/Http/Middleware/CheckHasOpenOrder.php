<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CheckHasOpenOrder
{
    /**
     * @var Request
     */
    private $request;
    private $orderController;
    private $user;

    public function __construct(Request $request, OrderController $controller)
    {
        $this->request = $request;
        $this->user = $this->request->user();
        $this->orderController = $controller;
    }

    /**
     * Handle an incoming request.
     * set id of an open Order in request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $openOrder = $this->user->openOrders()->get();
        if ($openOrder->isEmpty()) {
            $this->request->offsetSet("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_UNPAID"));
            $this->request->offsetSet("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
            $this->request->offsetSet("user_id", $this->user->id);
            $controller = $this->orderController;
            $controller->store($this->request);
        }
        return $next($request);
    }
}
