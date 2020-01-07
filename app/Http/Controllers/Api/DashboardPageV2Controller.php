<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlockV2;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DashboardPageV2Controller extends Controller
{
    /**
     * DashboardPageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     *
     * @param User    $user
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(Request $request, User $user)
    {
        if ($request->user()->id !== $user->id) {
            abort(Response::HTTP_FORBIDDEN, 'you can\'nt get user ' . $user->id . ' dashboard!');
        }

        return BlockV2::collection($user->getDashboardBlocks());
    }
}
