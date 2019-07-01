<?php


namespace App\Repositories;


use App\Orderproduct;

class OrderproductRepo
{
    public static function refreshOrderproductTmpPrice( Orderproduct $orderproduct , int $tmpFinal , int $tmpExtraCost): bool
    {
        return $orderproduct->update([
            'tmp_final_cost' => $tmpFinal,
            'tmp_extra_cost' => $tmpExtraCost
        ]);
    }

    public static function refreshOrderproductTmpShare( Orderproduct $orderproduct , $share): bool
    {
        return $orderproduct->update([
            'tmp_share_order' => $share,
        ]);
    }
}
