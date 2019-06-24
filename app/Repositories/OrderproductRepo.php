<?php


namespace App\Repositories;


use App\Orderproduct;

class OrderproductRepo
{
    public static function refreshOrderproductTmpPrice( Orderproduct $orderproduct , int $tmpFinal , int $tmpExtraCost): void
    {
        $orderproduct->update([
            'tmp_final_cost' => $tmpFinal,
            'tmp_extra_cost' => $tmpExtraCost
        ]);
    }

}
