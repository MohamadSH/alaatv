<?php namespace App\Traits;

use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait OrderCommon
{
    protected function  payOrderCostByWallet($user , $order , $cost)
    {
        $walletPaidFlag = false;
        $wallets = $user->wallets->sortByDesc("wallettype_id") ; //Chon mikhastim aval az kife poole hedie kam shavad!
        foreach ($wallets as $wallet)
        {
            if($cost < 0)
                break;
            $amount = $wallet->balance ;
            if($amount > 0 )
            {
                if($cost < $amount)
                    $amount = $cost;

                $result =  $wallet->withdraw($amount ,$order->id) ;
                if($result["result"])
                {
                    $cost = $cost - $amount;
                    $walletPaidFlag = true;
                }
            }
        }

        return [
            "result" => $walletPaidFlag ,
            "cost" => $cost
            ];
    }
}