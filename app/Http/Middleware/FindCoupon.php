<?php

namespace App\Http\Middleware;

use App\Repositories\CouponRepo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindCoupon
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
        $code = $request->get('code');

        $coupon = CouponRepo::findCouponByCode($code);
        if (is_null($coupon)) {
            return response()->json([
                'message' => 'Coupon not found',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $request->offsetSet('coupon', $coupon);

        return $next($request);
    }
}
