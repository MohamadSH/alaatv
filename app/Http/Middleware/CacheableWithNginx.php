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
                Cookie::queue(cookie()->forever($this->cookieName, '1'));
            }
            return $next($request);
        }
        Cookie::queue(cookie()->forget($this->cookieName));
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
        return $request->user() || $this->inExceptArray($request);
    }

    /**
     * @param $request
     * @return bool
     */
    private function isCacheables($request): bool
    {
        return $this->methodIsGetOrHead($request) && !$this->isNotCacheables($request);
    }
}
