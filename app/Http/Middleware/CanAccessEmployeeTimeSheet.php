<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Response;

class CanAccessEmployeeTimeSheet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
        /** @var User $user */
        $user = $request->user();

        if(!$user->can(config('constants.EDIT_EMPLOPYEE_WORK_SHEET'))) {
            if($request->ip() != '79.127.123.246') {
                return response()->json([
                    'error' => 'FORBIDDEN'
                ], Response::HTTP_FORBIDDEN);
            }
        }

        return $next($request);
    }
}
