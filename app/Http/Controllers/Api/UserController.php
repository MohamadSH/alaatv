<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    /**
     * Gets a list of user orders
     *
     * @param Request $request
     *
     * @param User    $user
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function userOrders(Request $request, User $user)
    {
        /** @var User $user */
        $authenticatedUser = $request->user('api');

        if ($authenticatedUser->id != $user->id)
            return response([
                'error' => [
                    'code'    => Response::HTTP_FORBIDDEN,
                    'message' => 'UnAuthorized',
                ],
            ], Response::HTTP_OK);

        $orders = $user->closed_orders;

        return response()->json($orders);
    }

    /**
     * Gets a list of transactions
     *
     * @return
     */
    public function getTransactions()
    {
        //ToDo
        return response();
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
