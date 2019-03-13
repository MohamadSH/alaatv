<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Traits\RequestCommon;
use App\Traits\UserCommon;
use App\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    use RequestCommon;
    use UserCommon;

    /**
     * Update the specified resource in storage.
     * Note: Requests to this method must pass \App\Http\Middleware\trimUserRequest middle ware
     *
     * @param EditUserRequest $request
     * @param User            $user
     *
     * @return array|Response
     */
    public function update(EditUserRequest $request, User $user = null)
    {
        $authenticatedUser = $request->user('api');
        if ($user === null)
            $user = $authenticatedUser;
        try {
            $user->fillByPublic($request->all());
            $file = $this->getRequestFile($request->all(), 'photo');
            if ($file !== false)
                $this->storePhotoOfUser($user, $file);
        } catch (FileNotFoundException $e) {
            return response(
                [
                    "error" => [
                        "text" => $e->getMessage(),
                        "line" => $e->getLine(),
                        "file" => $e->getFile(),
                    ],
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        //ToDo : place in UserObserver
        if ($user->checkUserProfileForLocking())
            $user->lockProfile();

        if ($user->update()) {

            //ToDo : place in UserObserver
            if ($request->has('roles'))
                $this->attachRoles($request->get('roles'), $authenticatedUser , $user);

            $message = 'User profile updated successfully';
            $status = Response::HTTP_OK;
        } else {
            $message = 'Database error on updating user';
            $status = Response::HTTP_SERVICE_UNAVAILABLE;
        }

        if($status == Response::HTTP_OK)
            $response = [
                'user'      => $user,
                'message'   => $message,
            ];
        else
            $response = [
                'error' =>  [
                    'code'      =>  $status ,
                    'message'   =>  $message ,
                ]
            ];

        return response(
            $response
            ,
            Response::HTTP_OK
        );
    }

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
            ], Response::HTTP_OK);

        $orders = $user->closed_orders;

        return response()->json($orders);
    }

    public function userAssets(Request $request, User $user){
        $authenticaedUser = $request->user('api');
        if ($authenticaedUser->id != $user->id)
            abort(Response::HTTP_FORBIDDEN, 'you can\'nt get user ' . $user->id . ' dashboard!.');

        $userAssetsCollection = $user->getDashboardBlocks();
        return response()->json([
                $userAssetsCollection,
        ]);
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
