<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProductvoucherRepo;
use App\Http\Resources\HekmatVoucher as VerifyVoucherResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VoucherController extends Controller
{
    public function __construct()
    {
        $authException = $this->getAuthExceptionArray();
        $this->callMiddlewares($authException);
    }

    public function verify(Request $request)
    {
        $voucher = ProductvoucherRepo::findVoucherByCode($request->get('code'));
        if(!isset($voucher)){
            return response()->json( [
                'error' => 'Resource not found'
            ] , Response::HTTP_NOT_FOUND);
        }
        return new VerifyVoucherResource($voucher);
    }

    public function disable(Request $request)
    {
        $voucher = ProductvoucherRepo::findVoucherByCode($request->get('code'));
        if(!isset($voucher)){
            return response()->json( [
                'error' => 'Resource not found'
            ] , Response::HTTP_NOT_FOUND);
        }
        if (ProductvoucherRepo::disableVoucher($voucher)){
            return response()->json([
                'date' => [
                    'message' => 'ووچر با موفقیت غیر فعال شد',
                ],
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Server error',
            ],
        ] , Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param Agent $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(): array
    {
        return [];
    }

    /**
     * @param $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . config('constants.VERIFY_HEKMAT_VOUCHER'), ['only' => ['verify',],]);
        $this->middleware('permission:' . config('constants.DISABLE_HEKMAT_VOUCHER'), ['only' => ['disable',],]);
    }
}
