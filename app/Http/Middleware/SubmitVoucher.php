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
            return redirect(route('web.voucher.submit.form', ['code' => $code]));
        }

        if (!$user->hasVerifiedMobile()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'User is not verified',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return redirect(route('web.voucher.submit.form', ['code' => $code]));
        }

        /** @var Productvoucher $voucher */
        $voucher = Productvoucher::where('code', $code)->first();
        if (!isset($voucher)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Voucher not found',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $flash = [
                'title' => 'خطا',
                'body'  => 'کد شما یافت نشد',
            ];
            setcookie('flashMessage', json_encode($flash), time() + (86400 * 30), '/');
            return redirect(route('web.voucher.submit.form', ['code' => $code]));
        }

        if (!$voucher->isValid()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Voucher is not valid',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $flash = [
                'title' => 'خطا',
                'body'  => 'کد شما یافت نشد',
            ];
            setcookie('flashMessage', json_encode($flash), time() + (86400 * 30), '/');
            return redirect(route('web.voucher.submit.form', ['code' => $code]));
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


            $flash = [
                'title' => 'خطا',
                'body'  => 'کد قبلا استفاده شده است',
            ];
            setcookie('flashMessage', json_encode($flash), time() + (86400 * 30), '/');
            return redirect(route('web.voucher.submit.form', ['code' => $code]));
        }

        $request->offsetSet('voucher', $voucher);

        return $next($request);
    }
}
