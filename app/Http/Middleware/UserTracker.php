<?php

namespace App\Http\Middleware;

use App\Traits\UserSeenTrait;
use Closure;

class UserTracker
{
    use UserSeenTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $seenCount = optional($request->user())->seen($request->path());

        $this->setSeenCountInRequestBody($request, $seenCount);

        $response = $next($request);
        return $response;
    }


}
