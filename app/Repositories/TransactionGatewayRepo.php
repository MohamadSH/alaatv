<?php


namespace App\Repositories;



use App\Transactiongateway;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
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

    /**
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getTransactionGateways(array $filters = []):Collection{
        $transactions = Transactiongateway::query();
        self::filter($filters, $transactions);
        return $transactions->get();
    }

    /**
     * @param array $filters
     * @param $transactions
     */
    private static function filter(array $filters, Builder $transactions): void
    {
        foreach ($filters as $key => $filter) {
            $transactions->where($key, $filter);
        }
    }
}
