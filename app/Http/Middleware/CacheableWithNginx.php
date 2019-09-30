<?php

namespace App\Http\Middleware;

use Closure;

class CacheableWithNginx
{
    private $cookieName = 'nginx_not_cacheable';
    
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
        if ($request->user()) {
            \Cookie::queue(cookie()->forever($this->cookieName, '1'));
        } else {
            \Cookie::queue(cookie()->forget($this->cookieName));
        }
        return $next($request);
    }
}
