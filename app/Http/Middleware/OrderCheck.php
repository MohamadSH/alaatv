<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderController;
use App\Orderproduct;
use App\Product;
use App\Classes\Order\OrderUtility;
use App\Traits\ProductCommon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;


use App\Order;
use App\Userbon;
use Illuminate\Support\Facades\DB;

class OrderCheck
{
    use ProductCommon;

    /**
     * @var OrderController
     */
    private $orderController;

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

//            $this->resetOrders();

            $user = $request->user();

//            if user have permission : set orderid from request

//             else :
            /**
             *
             * Making an open order for the user or retrieving the existing one
             */
            $openOrder = $user->openOrders()->get();

            if ($openOrder->isEmpty()) {
                $request->offsetSet("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_UNPAID"));
                $request->offsetSet("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
                $request->offsetSet("user_id", Auth::user()->id);
                $controller = $this->orderController;
                $order = $controller->store($request);
            } else {
                $order = $openOrder->first();
            }

            $request->offsetSet('orderId', $order);

        }
        return $next($request);
    }

    private function resetOrders() {
        $Userbon = Userbon::findOrFail(1);
        $Userbon->usedNumber = 0;
        $Userbon->userbonstatus_id = 1;
        $Userbon->update();
        DB::table('orders')->delete();
        DB::table('orderproducts')->delete();
        DB::table('attributevalue_orderproduct')->delete();

        dd('OrdersReset Done!');
    }

}
