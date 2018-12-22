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
            /**
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
            /**
             *  end
             */


//            /**
//             *  Putting found order id in session
//             */
//            if (isset($order)) {
//                session()->put("order_id", $order->id);
//                //                session()->save();
//            }
//            /**
//             *  end
//             */
//
//            /**
//             *  Pulling orderProducts that user has added to the cart before login
//             */
//            if (session()->has("orderproducts")) {
//                $products = session()->pull("orderproducts");
//                if (session()->has("orderproductAttributes"))
//                    $attributes = session()->pull("orderproductAttributes");
//                foreach ($products as $key => $value) {
//                    $product = Product::where("id", $key)
//                                      ->get()
//                                      ->first();
//                    if (isset($product) && strlen($product->validateProduct()) == 0) {
//                        $orderproduct = new Orderproduct();
//                        $orderproduct->product_id = $product->id;
//                        $orderproduct->order_id = $order->id;
//
//                        if ($orderproduct->save()) {
//
//                            if (isset($product->amount)) {
//                                $product->amount = $product->amount - 1;
//                                $product->update();
//                            }
//                            if (isset($attributes) && isset($attributes[$product->id])) {
//                                $orderproductAttributes = $attributes[$product->id];
//                                foreach ($orderproductAttributes as $orderproductAttribute => $extraCost) {
//                                    $myParent = $this->makeParentArray($product);
//                                    $myParent = end($myParent);
//                                    $attributevalues = $myParent->attributevalues->where("id", $orderproductAttribute);
//                                    if ($attributevalues->isNotEmpty()) {
//                                        $orderproduct->attributevalues()
//                                                     ->attach($attributevalues->first()->id, ["extraCost" => $attributevalues->first()->pivot->extraCost]);
//                                    }
//                                }
//                            }
//
//                            $costArray = $orderproduct->obtainOrderproductCost();
//                            if (isset($costArray["cost"]))
//                                $orderproduct->cost = $costArray["customerPrice"];
//                            else
//                                $orderproduct->cost = null;
//                            $orderproduct->update();
//
//                            /**
//                             * Attaching simple product gifts to the order
//                             */
//                            $attachedGifts = [];
//                            foreach ($value["gifts"] as $gift) {
//                                if (in_array($gift->id, $attachedGifts))
//                                    continue;
//                                else
//                                    array_push($attachedGifts, $gift->id);
//                                if ($order->orderproducts(Config::get("constants.ORDER_PRODUCT_GIFT"))
//                                          ->whereHas("product", function ($q) use ($gift) {
//                                              $q->where("id", $gift->id);
//                                          })
//                                          ->get()
//                                          ->isNotEmpty())
//                                    continue;
//
//                                $orderproduct->attachGift($gift);
//                            }
//                            /**
//                             *    end
//                             */
//
//                        }
//                    }
//                }
//            }
//            /**
//             *  end
//             */

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
