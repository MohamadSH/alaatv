<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

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

        $pageName = "shop";
        $userAssetsCollection = $user->getDashboardBlocks();
        return view('user.dashboard', compact('user', 'pageName', 'userAssetsCollection'));
    }
}
