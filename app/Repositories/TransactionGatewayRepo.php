<?php


namespace App\Repositories;



use App\Transactiongateway;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TransactionGatewayRepo
{
    public static function getTransactionGatewayByName($name){
        $key   = 'gateways:'.$name;
        return Cache::tags(['gateway'])
            ->remember($key, config("constants.CACHE_600"), function () use ($name) {
                return nullable(Transactiongateway::where('name', $name)->first());
            });
    }

    /**
     * @param array $filters
     * @return Transactiongateway|Builder
     */
    public static function getTransactionGateways(array $filters = []){
        $gateways = Transactiongateway::query();
        self::filter($filters, $gateways);
        return $gateways;
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
