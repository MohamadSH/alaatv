<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardPageController extends Controller
{
    /**
     * DashboardPageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request, User $user)
    {
        if ($request->user()->id !== $user->id) {
            abort(Response::HTTP_FORBIDDEN, 'you can\'nt get user ' . $user->id . ' dashboard!.');
        }
        $userAssetsCollection = $user->getDashboardBlocks();

        return response()->json([
            'user_id' => $user->id,
            'data'    => $userAssetsCollection,
        ]);
    }
}
