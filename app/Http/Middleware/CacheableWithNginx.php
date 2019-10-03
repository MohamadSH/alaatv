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
        if ($this->isNotCachable($request)) {
            if ($this->methodIsGetOrHead($request) && !$request->hasCookie($this->cookieName)) {
                Cookie::queue(cookie()->forever($this->cookieName, '1'));
            }
            return $next($request);
        }
        $this->weCanCacheThisRequest();
        $response = $next($request);
    
        if ($this->methodIsGetOrHead($request)) {
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
    
    private function weCanCacheThisRequest(): void
    {
        Cookie::queue(cookie()->forget($this->cookieName));
    }
    
    /**
     * @param  Request  $request
     *
     * @return bool
     */
    private function isNotCachable($request): bool
    {
        return $request->user() || $this->inExceptArray($request);
    }
}
