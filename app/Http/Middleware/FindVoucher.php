<?php

namespace App\Http\Middleware;

use App\Repositories\ProductvoucherRepo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindVoucher
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

        $voucher = ProductvoucherRepo::findVoucherByCode($code);
        if (is_null($voucher)) {
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
            return redirect(route('web.voucher.submit.form', ['code' => $request->get('code')]));
        }

        $request->offsetSet('voucher', $voucher);

        return $next($request);
    }
}
