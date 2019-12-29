<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Web\OrderController;
use App\Traits\OrderCommon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckPermissionForSendOrderId
{
    use OrderCommon;

    /**
     * @var OrderController
     */
    private $orderController;

    private $user;

    /**
     * OrderCheck constructor.
     *
     * @param Request         $request
     * @param OrderController $controller
     */
    public function __construct(Request $request, OrderController $controller, $guard = null)
    {
        $this->orderController = $controller;
        $this->user            = $request->user();
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {

        if ($request->has('order_id')) {
            if (!$this->user->can(config('constants.INSERT_ORDERPRODUCT_ACCESS'))) {
                return response()->json([
                    'error' => 'You are not allowed to submit order_id: ' . $request->get('order_id'),
                ], Response::HTTP_FORBIDDEN);
            }
        } else {
            $openOrder = $this->user->getOpenOrder();
            $request->offsetSet('order_id', $openOrder->id);
            $request->offsetSet('openOrder', $openOrder);
        }

        return $next($request);
    }
}
