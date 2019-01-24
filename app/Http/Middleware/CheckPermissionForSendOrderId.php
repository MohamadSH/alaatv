<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderController;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckPermissionForSendOrderId
{
    /**
     * @var OrderController
     */
    private $orderController;
    private $user;

    /**
     * OrderCheck constructor.
     * @param Request $request
     * @param OrderController $controller
     */
    public function __construct(Request $request, OrderController $controller)
    {
        $this->orderController = $controller;
        $this->user = $request->user();
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
        if (Auth::guard($guard)->check()) {
            if($request->has('order_id')) {
                if(!$this->user->can(config("constants.INSERT_ORDERPRODUCT_ACCESS"))) {
                    return response()->json([
                        'error' => 'Forbidden'
                    ], Response::HTTP_FORBIDDEN);
                }
            } else {
                $request->offsetSet('order_id', $request->user()->openOrders->id);
            }
        } else {
            return response()->json([
                'error' => 'Unauthenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
