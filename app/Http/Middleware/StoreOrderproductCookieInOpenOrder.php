<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderproductController;
use Closure;
use Illuminate\Support\Facades\Auth;

class StoreOrderproductCookieInOpenOrder
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
    public function handle($request, Closure $next ,$guard = null)
    {
//        Sample:
//        $_COOKIE["cartItems"]='[{"product_id": 257,"products": [259,261]}]';
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            $cookieOrderproducts = [];
            if(isset($_COOKIE["cartItems"]))
                $cookieOrderproducts = json_decode($_COOKIE["cartItems"]);
            if($this->validateCookieOrderproducts($cookieOrderproducts))
            {
                $openOrder = $user->openOrders->first();
                if(isset($openOrder))
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
