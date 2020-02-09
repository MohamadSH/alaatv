<?php

namespace App\Http\Middleware;

use App\Productvoucher;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ValidateVoucher
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
        $code = $request->get('code');
        /** @var Productvoucher $voucher */
        $voucher = $request->get('voucher');
        $user    = Auth::guard($guard)->user();


        if (isset($voucher) && !$voucher->isValid()) {
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
            return redirect(route('web.voucher.submit.form', ['code' => isset($code) ? $code : null]));
        }

        if (isset($voucher) && $voucher->hasBeenUsed()) {
//            if ($voucher->user_id == $user->id) {
//                //ToDo: log
//            } else {
//                //ToDo: log
//            }

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
            return redirect(route('web.voucher.submit.form', ['code' => isset($code) ? $code : null]));
        }

        return $next($request);
    }
}
