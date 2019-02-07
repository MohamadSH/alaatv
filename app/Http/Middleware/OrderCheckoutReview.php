<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderproductController;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderCheckoutReview
{
    private $orderproductController;

    /**
     * StoreOrderproductCookieInOpenOrder constructor.
     * @param OrderproductController $orderproductController
     */
    public function __construct(OrderproductController $orderproductController)
    {
        $this->orderproductController = $orderproductController ;
    }

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
                //ToDo $openOrder = $user->getOpenOrder();
                $openOrder = $user->openOrders->first();
                $request->offsetSet("order_id" , $openOrder->id);

                $cookieOrderproducts = [];
                if(isset($_COOKIE["cartItems"]))
                    $cookieOrderproducts = json_decode($_COOKIE["cartItems"]);
                if($this->validateCookieOrderproducts($cookieOrderproducts))
                {
                    foreach ($cookieOrderproducts as $cookieOrderproduct) {
                        $data = [ "order_id" => $openOrder->id ];
                        $this->orderproductController->storeOrderproductJsonObject($cookieOrderproduct, $data);
                    }

                    //ToDo : empty cookies
                }
            }
        }

        return $next($request);
    }

    /**
     * @param $cookieOrderproducts
     * @return bool
     */
    private function validateCookieOrderproducts($cookieOrderproducts):bool
    {
        return isset($cookieOrderproducts) && is_array($cookieOrderproducts) && !empty($cookieOrderproducts);
    }
}
