<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     *
     *
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function show(Request $request, User $user)
    {
        $authenticatedUser = $request->user('api');

        if ($authenticatedUser->id != $user->id)
            return response([
                'error' => [
                    'code'    => Response::HTTP_FORBIDDEN,
                    'message' => 'UnAuthorized',
                ],
            ], 403);

        return response($user, Response::HTTP_OK);
    }

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
            ], 403);

        $key = "user:orders:" . $user->cacheKey();
        $orders = Cache::remember($key, config("constants.CACHE_60"), function () use ($user) {
            return $user->getClosedOrders()
                        ->orderBy('completed_at', 'desc')
                        ->paginate(10, ['*'], 'orders');
        });

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
