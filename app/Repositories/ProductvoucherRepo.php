<?php


namespace App\Repositories;


use App\Productvoucher;

class ProductvoucherRepo
{
    public static function findVoucherByCode(?string $code): ?Productvoucher
    {
        return Productvoucher::where('code', $code)->first();
    }

    public static function disableVoucher(Productvoucher $voucher)
    {
        return $voucher->update([
            'enable'    => 0 ,
        ]);
    }
}
