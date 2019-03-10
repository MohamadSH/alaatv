<?php

namespace App\Http\Controllers\Web;

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
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\User                 $user
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, User $user)
    {

        if ($request->user()->id != $user->id)
            abort(Response::HTTP_FORBIDDEN, 'you can\'nt get user ' . $user->id . ' dashboard!.');
        $pageName = "shop";
        $userAssetsCollection = $user->getDashboardBlocks();
//        return $userAssetsCollection;
//        return $userAssetsCollection->first()->products->first()->sets->first()->contents;
        if ($request->expectsJson())
            return response()->json([
                'user_id' => $user->id,
                'data'    => $userAssetsCollection,
            ]);
        return view('user.dashboard', compact('user', 'pageName', 'userAssetsCollection'));
    }
}
