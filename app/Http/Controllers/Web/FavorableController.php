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

    /*
    |--------------------------------------------------------------------------
    | Public methods
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    public function markFavorableFavorite(Request $request, FavorableInterface $favorable)
    {
        $favorable->favoring($request->user());
    }

    public function getUsersThatFavoredThisFavorable(Request $request, FavorableInterface $favorable)
    {
        $key = md5($request->url());
        return Cache::remember($key, config('constants.CACHE_1'), function () use ($favorable) {
            return $favorable->favoriteBy()
                             ->get()
                             ->count();
        });

    }
}
