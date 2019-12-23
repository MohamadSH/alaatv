<?php

namespace App\Http\Middleware;

use Cookie;
use Closure;
use Illuminate\Http\Request;

class CacheableWithNginx
{
    private $cookieName = 'nocache';
    /**
     * The authentication guard.
     *
     * @var string
     */
    protected $guard;
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
     * @param Request $request
     * @param Closure $next
     *
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $this->guard = $guard;
        $requestHasUser = $this->requestHasUser($request);
        if ($requestHasUser) {
            setcookie($this->cookieName , '1', time() + (86400*30), '/');
        }
        if ($requestHasUser || $this->inExceptArray($request) || !$this->methodIsGetOrHead($request)) {
            return $next($request);
        }
        $response = $next($request);
        return $response->withHeaders([
            'Cache-Control' => 'public, max-age='. 60 * (config('cache_time_in_minutes', 60)),
        ]);
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
    private function requestHasUser($request)
    {
        return $request->user($this->guard);
    }
}
