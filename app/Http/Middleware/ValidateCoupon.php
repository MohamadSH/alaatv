<?php

namespace App\Http\Middleware;

use App\Coupon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ValidateCoupon
{
    /**
     * Handle an incoming request.
     *
     * @param Request                  $request
     * @param Closure                  $next
     * @param                          $coupon
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Coupon $coupon */
        $coupon = $request->get('coupon');
        if (isset($coupon)) {
            $couponValidationStatus = $coupon->validateCoupon();
            if ($couponValidationStatus != Coupon::COUPON_VALIDATION_STATUS_OK) {
                return response()->json([
                    'error' => [
                        'message' => Coupon::COUPON_VALIDATION_INTERPRETER[$couponValidationStatus] ?? 'Coupon validation status is undetermined',
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $next($request);
    }
}
