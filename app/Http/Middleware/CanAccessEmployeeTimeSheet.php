<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CanAccessEmployeeTimeSheet
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user->can(config('constants.EDIT_EMPLOPYEE_WORK_SHEET'))) {
            if ($request->ip() != config('constants.ALAA_IP')) {
                return response()->json([
                    'error' => 'This request is forbidden from you IP',
                ], Response::HTTP_FORBIDDEN);
            }
        }

        return $next($request);
    }
}
