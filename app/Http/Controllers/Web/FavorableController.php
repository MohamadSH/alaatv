<?php

namespace App\Http\Controllers\Web;

use App\Classes\FavorableInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FavorableController extends Controller
{
    public function __construct()
    {
        $this->callMiddlewares($this->getAuthExceptionArray());
    }

    /**
     * @param $authException
     */
    private function callMiddlewares($authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
    }

    /**
     * @return array
     */
    private function getAuthExceptionArray(): array
    {
        $authException = ['getUsersThatFavoredThisFavorable'];

        return $authException;
    }

    public function markFavorableFavorite(Request $request, FavorableInterface $favorable)
    {
        $favoredResult =  $favorable->favoring($request->user());
        if($favoredResult){
            Cache::tags('favorite_'.$favorable->id)->flush();
            return response()->json([
                'message'   =>  'Favorite added successfully',
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Error on adding Favorite',
            ]
        ]);
    }

    public function markUnFavorableFavorite(Request $request, FavorableInterface $favorable)
    {
        $unfavoredResult =  $favorable->unfavoring($request->user());
        if($unfavoredResult){
            Cache::tags('favorite_'.$favorable->id)->flush();
            return response()->json([
                'message'   =>  'Favorite removed successfully',
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Error on removing Favorite',
            ]
        ]);
    }

    public function getUsersThatFavoredThisFavorable(Request $request, FavorableInterface $favorable)
    {
        $key = md5($request->url());

        return Cache::tags(['favorite' , 'favorite_'.$favorable->id])->remember($key, config('constants.CACHE_1'), function () use ($favorable) {
            return $favorable->favoriteBy()
                ->get()
                ->count();
        });
    }
}
