<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DashboardPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request, User $user)
    {
        if ($request->user()->id != $user->id) {
            abort(Response::HTTP_FORBIDDEN, 'you can\'nt get user '.$user->id.' dashboard!.');
        }
        $pageName             = "shop";
        $userInfoCompletion   = $user->completion();
        $userAssetsCollection = $user->getDashboardBlocks();

        if ($request->expectsJson()) {
            return response()->json([
                'user_id'   => $user->id,
                'data'      => $userAssetsCollection,
            ]);
        }


        $categoryArray = [
            [
                'name'  => 'همه',
                'value' => 'all',
                'selected' => true,
            ],
            [
                'name'  => 'همایش آرش یا طلایی',
                'value' => 'همایش/آرش',
            ],
            [
                'name'  => 'همایش تفتان',
                'value' => 'همایش/تفتان',
            ],
            [
                'name'  => 'همایش گدار یا 5+1',
                'value' => 'همایش/گدار',
            ],
            [
                'name'  => 'نظام قدیم',
                'value' => 'قدیم',
            ],
            [
                'name'  => 'جزوه',
                'value' => 'جزوه',
            ],
            [
                'name'  => 'ویژه',
                'value' => 'VIP',
            ],
        ];
        return view('user.dashboard', compact('user', 'pageName', 'userAssetsCollection' , 'categoryArray', 'userInfoCompletion'));
    }
}
