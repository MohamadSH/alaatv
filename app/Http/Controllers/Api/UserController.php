<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{

    /**
     * Gets a list of user orders
     *
     * @param Request $request
     *
     * @return
     */
    public function userOrders(Request $request)
    {
        /** @var User $user */
        $user = $request->user('api');

        $key = "user:orders:" . $user->cacheKey();
        $orders = Cache::remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getClosedOrders()
                ->orderBy('completed_at' , 'desc')
                ->paginate(10 , ['*'] , 'orders');
        });

        return response()->json($orders);
    }

    /**
     * Gets a list of transactions
     *
     * @return
     */
    public function getTransactions(){
        /*$key = "user:transactions:" . $user->cacheKey();
        $transactions = Cache::remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getShowableTransactions()
                ->get()
                ->sortByDesc("completed_at")
                ->groupBy("order_id");
        });

        $key = "user:instalments:" . $user->cacheKey();
        $instalments = Cache::remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getInstalments()
                ->get()
                ->sortBy("deadline_at");
        });

        return response()->json($product);*/
    }
}
