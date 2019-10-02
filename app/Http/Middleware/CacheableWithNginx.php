<?php

namespace App\Http\Middleware;

use Closure;

class CacheableWithNginx
{
    private $cookieName = 'nginx_not_cacheable';
    private $except     = [
        '/login',
        '/checkout/review',
        '/logout',
        '/goToPaymentRoute/*',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
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
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
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
        \Cookie::queue(cookie()->forever($this->cookieName, '1'));
    }
    
    private function weCanCacheThisRequest(): void
    {
        \Cookie::queue(cookie()->forget($this->cookieName));
    }
}
