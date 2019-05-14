<?php


namespace App\Repositories;



use App\Transactiongateway;
use Illuminate\Support\Facades\Cache;

class TransactionGatewayRepo
{
    public static function getTransactionGatewayByName($name){
        $key   = "gateways:".$name;
        return Cache::tags(["transaction"])
            ->remember($key, config("constants.CACHE_600"), function () use ($name) {
                return nullable(Transactiongateway::where('name', $name)->first());
            });
    }
}
