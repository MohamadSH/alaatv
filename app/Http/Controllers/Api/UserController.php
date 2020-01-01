<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\User as UserResource;
use App\Traits\RequestCommon;
use App\Traits\UserCommon;
use App\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

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
        if ($user === null) {
            $user = $authenticatedUser;
        }
        try {
            $user->fillByPublic($request->all());
            $file = $this->getRequestFile($request->all(), 'photo');
            if ($file !== false) {
                $this->storePhotoOfUser($user, $file);
            }
        } catch (FileNotFoundException $e) {
            return response([
                "error" => [
                    "text" => $e->getMessage(),
                    "line" => $e->getLine(),
                    "file" => $e->getFile(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //ToDo : place in UserObserver
        if ($user->checkUserProfileForLocking()) {
            $user->lockHisProfile();
        }

        if ($user->update()) {

            $message = 'User profile updated successfully';
            $status  = Response::HTTP_OK;
        } else {
            $message = 'Database error on updating user';
            $status  = Response::HTTP_SERVICE_UNAVAILABLE;
        }

        if ($status == Response::HTTP_OK) {
            $response = [
                'user'    => $user,
                'message' => $message,
            ];
        } else {
            $response = [
                'error' => [
                    'code'    => $status,
                    'message' => $message,
                ],
            ];
        }

        Cache::tags('user_' . $user->id)->flush();

        return response($response, Response::HTTP_OK);
    }

    /**
     * API Version 2
     *
     * @param EditUserRequest $request
     * @param User|null       $user
     *
     * @return ResponseFactory|Response
     */
    public function updateV2(EditUserRequest $request, User $user = null)
    {
        $authenticatedUser = $request->user('api');
        if ($user === null) {
            $user = $authenticatedUser;
        }
        try {
            $user->fillByPublic($request->all());
            $file = $this->getRequestFile($request->all(), 'photo');
            if ($file !== false) {
                $this->storePhotoOfUser($user, $file);
            }
        } catch (FileNotFoundException $e) {
            return response([
                "error" => [
                    "text" => $e->getMessage(),
                    "line" => $e->getLine(),
                    "file" => $e->getFile(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //ToDo : place in UserObserver
        if ($user->checkUserProfileForLocking()) {
            $user->lockHisProfile();
        }

        if ($user->update()) {

            $message = 'User profile updated successfully';
            $status  = Response::HTTP_OK;
        } else {
            $message = 'Database error on updating user';
            $status  = Response::HTTP_SERVICE_UNAVAILABLE;
        }

        if ($status == Response::HTTP_OK) {
            $response = [
                'user'    => new UserResource($user),
                'message' => $message,
            ];
        } else {
            $response = [
                'error' => [
                    'code'    => $status,
                    'message' => $message,
                ],
            ];
        }

        Cache::tags('user_' . $user->id)->flush();

        return response($response, Response::HTTP_OK);
    }

    public function show(Request $request, User $user)
    {
        $authenticatedUser = $request->user('api');

        if ($authenticatedUser->id != $user->id) {
            return response([
                'error' => [
                    'code'    => Response::HTTP_FORBIDDEN,
                    'message' => 'UnAuthorized',
                ],
            ], Response::HTTP_FORBIDDEN);
        }

        return response($user, Response::HTTP_OK);
    }

    /**
     * API Version 2
     *
     * @param Request $request
     * @param User    $user
     *
     * @return ResponseFactory|JsonResponse|Response
     */
    public function showV2(Request $request, User $user)
    {
        $authenticatedUser = $request->user('api');

        if ($authenticatedUser->id != $user->id) {
            return response([
                'error' => [
                    'code'    => Response::HTTP_FORBIDDEN,
                    'message' => 'UnAuthorized',
                ],
            ], Response::HTTP_FORBIDDEN);
        }

        return (new UserResource($user))->response();
    }

    /**
     * Gets a list of user orders
     *
     * @param Request $request
     *
     * @param User    $user
     *
     * @return ResponseFactory|JsonResponse|Response
     */
    public function userOrders(Request $request, User $user)
    {
        /** @var User $user */
        $authenticatedUser = $request->user('api');

        if ($authenticatedUser->id != $user->id) {
            return response([
                'error' => [
                    'code'    => Response::HTTP_FORBIDDEN,
                    'message' => 'UnAuthorized',
                ],
            ], Response::HTTP_OK);
        }

        $orders = $user->getClosedOrders($request->get('orders', 1));

        return response()->json($orders);
    }

    /**
     * API Version 2
     *
     * @param Request $request
     * @param User    $user
     *
     * @return ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|Response
     */
    public function userOrdersV2(Request $request, User $user)
    {
        /** @var User $user */
        $authenticatedUser = $request->user('api');

        if ($authenticatedUser->id != $user->id) {
            return response([
                'error' => [
                    'code'    => Response::HTTP_FORBIDDEN,
                    'message' => 'UnAuthorized',
                ],
            ], Response::HTTP_OK);
        }

        $orders = $user->getClosedOrders($request->get('orders', 1));

        return OrderResource::collection($orders);
    }

    public function getAuth2Profile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'id'    => $user->id,
            'name'  => $user->fullName,
            'email' => md5($user->mobile) . '@sanatisharif.ir',

        ]);
    }
}
