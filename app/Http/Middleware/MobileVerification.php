<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MobileVerification
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /** @var User $user */
        $user = Auth::guard($guard)->user();

        if (isset($user) && !$user->hasVerifiedMobile()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'User is not verified',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return redirect(route('web.voucher.submit.form', ['code' => $request->get('code')]));
        }

        return $next($request);
    }
}
