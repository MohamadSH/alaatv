<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Productvoucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function verify(Request $request, Productvoucher $voucher)
    {
        if ($voucher->isVaild()) {
            return response()->json([
                'date' => [
                    'result' => true,
                ],
            ]);
        }

        return response()->json([
            'data' => [
                'result' => false,
            ],
        ]);
    }

    public function disable(Request $request, Productvoucher $voucher)
    {
        if ($voucher->disable()) {
            return response()->json([
                'date' => [
                    'message' => 'Voucher disabled successfully',
                ],
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Please try again later',
            ],
        ]);
    }
}
