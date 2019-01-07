<?php

namespace App\Http\Middleware;

use App\Traits\OrderproductControllerCommon;
use Closure;
use Illuminate\Support\Facades\Auth;

class StoreOrderproductCookieInOpenOrder
{

    use OrderproductControllerCommon;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next ,$guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            $cookieOrderproducts = json_decode($request->header("cartItems"));
            if($this->validateCookieOrderproducts($cookieOrderproducts))
            {
                $openOrder = $user->openOrders()->get()->first();
                //ToDo : Make sure there is an open order in a middleware before this
                if(isset($openOrder))
                {
                    foreach ($cookieOrderproducts as $cookieOrderproduct) {
                        $data = [ "order_id" => $openOrder->id ];
                        $this->storeOrderproductJsonObject($cookieOrderproduct, $data);
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
