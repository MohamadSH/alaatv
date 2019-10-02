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
        if ($request->user() || $this->inExceptArray($request)) {
            $this->canNotCacheThisRequest();
            return $next($request);
        }
        $this->weCanCacheThisRequest();
        return $next($request);
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
    
    private function canNotCacheThisRequest(): void
    {
        Cookie::queue(cookie()->forever($this->cookieName, '1'));
    }
    
    private function weCanCacheThisRequest(): void
    {
        Cookie::queue(cookie()->forget($this->cookieName));
    }
}
