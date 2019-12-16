<?php

namespace App\Http\Middleware;

use Cookie;
use Closure;
use Illuminate\Http\Request;

class CacheableWithNginx
{
    private $cookieName = 'nocache';
    private $except     = [
        '/login',
        '/checkout/review',
        '/logout',
        '/goToPaymentRoute/*',
        '/checkout/*',
        '/api/login',
        '/d/*'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isNotCacheables($request)) {
            if ($this->methodIsGetOrHead($request) && !$request->hasCookie($this->cookieName)) {
                setcookie($this->cookieName , '1', time() + (86400*30), '/');
            }
            return $next($request);
        }
        setcookie($this->cookieName , 'Expired', time() - 100000, '/');
        $response = $next($request);

        if ($this->isCacheables($request)) {
            return $response->withHeaders([
                'Cache-Control' => 'public, max-age='. 60 * (config('cache_time_in_minutes', 60)),
            ]);
        }
        return $response;
    }

    private function methodIsGetOrHead(Request $request)
    {
        return $request->isMethod('GET') || $request->isMethod('HEAD') ? true : false;
    }
    /**
     *
     * @param  Request  $request
     *
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  Request  $request
     *
     * @return bool
     */
    private function isNotCacheables($request): bool
    {
        return $request->user() || $this->inExceptArray($request) || !$this->methodIsGetOrHead($request);
    }

    /**
     * @param $request
     * @return bool
     */
    private function isCacheables($request): bool
    {
        return  !$this->isNotCacheables($request);
    }
}
