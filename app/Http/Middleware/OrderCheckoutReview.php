<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Web\OrderproductController;
use App\User;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderCheckoutReview
{
    private $orderproductController;

    /**
     * StoreOrderproductCookieInOpenOrder constructor.
     *
     * @param OrderproductController $orderproductController
     */
    public function __construct(OrderproductController $orderproductController)
    {
        $this->orderproductController = $orderproductController;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! Auth::guard($guard)->check()) {
            return $next($request);
        }
        /** @var User $user */
        $user = Auth::guard($guard)->user();

        if ($request->has("order_id")) {
            if (! $user->can("constants.SHOW_ORDER_INVOICE_ACCESS")) {
                return response([], Response::HTTP_FORBIDDEN);
            }

            return $next($request);
        }

        $openOrder = $user->getOpenOrder();
        $request->offsetSet("order_id", $openOrder->id);

        // TODO: $_COOKIE should not be used.
        if (isset($_COOKIE["cartItems"])) {
            $cookieOrderproducts = json_decode($_COOKIE["cartItems"]);
            if ($this->validateCookieOrderproducts($cookieOrderproducts)) {
                foreach ($cookieOrderproducts as $cookieOrderproduct) {
                    $data = ["order_id" => $openOrder->id];
                    $this->orderproductController->storeOrderproductJsonObject($cookieOrderproduct, $data);
                }
            }

            setcookie('cartItems', $_COOKIE["cartItems"], time() - 3600, '/');
        }

        return $next($request);
    }

    /**
     * @param $cookieOrderproducts
     *
     * @return bool
     */
    private function validateCookieOrderproducts($cookieOrderproducts): bool
    {
        return is_array($cookieOrderproducts) && ! empty($cookieOrderproducts);
    }
}
