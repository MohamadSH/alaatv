<?php

namespace App\Http\Middleware;

use App\Productvoucher;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubmitVoucher
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
        $user = $request->user();
        $code = $request->get('code');

        if (!isset($user)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return redirect(route('web.voucher.submit', ['code' => $code]));
        }

        if (!$user->hasVerifiedMobile()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'User is not verified',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return redirect(route('web.voucher.submit', ['code' => $code]));
        }

        /** @var Productvoucher $voucher */
        $voucher = Productvoucher::where('code', $code)->first();
        if (!isset($voucher)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Voucher not found',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            session()->put('error', 'کد وارد شده یافت نشد');
            return redirect(route('web.voucher.submit', ['code' => $code]));
        }

        if (!$voucher->isValid()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Voucher is not valid',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            session()->put('error', 'کد وارد شده معتبر نمی باشد');
            return redirect(route('web.voucher.submit', ['code' => $code]));
        }

        if ($voucher->hasBeenUsed()) {
            if ($voucher->user_id == $user->id) {
                //ToDo: log
            } else {
                //ToDo: log
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Voucher has been used before',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }


            session()->put('error', 'کد قبلا استفاده شده است');
            return redirect(route('web.voucher.submit', ['code' => $code]));
        }

        $request->offsetSet('voucher', $voucher);

        return $next($request);
    }
}
