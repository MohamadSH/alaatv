<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:14
 */

namespace App\Traits\User;

use App\Order;
use Cache;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Kalnoy\Nestedset\QueryBuilder;

trait PaymentTrait
{
    public function getOpenOrder(): Order
    {
        $openOrder = $this->firstOrCreateOpenOrder($this);

        return $openOrder;
    }

    public function getNumberOfProductsInBasketAttribute()
    {
        return $this->openOrders->getNumberOfProductsInThisOrderCollection();
    }

    public function ordermanagercomments()
    {
        return $this->hasMany('App\Ordermanagercomment');
    }

    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    */
    public function bankaccounts()
    {
        return $this->hasMany('\App\Bankaccount');
    }

    public function openOrders()
    {
        return $this->hasMany('App\Order')
            ->where("orderstatus_id", config("constants.ORDER_STATUS_OPEN"));
    }

    /**
     * Gets user's transactions that he is allowed to see
     *
     * @return HasManyThrough
     */
    public function getShowableTransactions(): HasManyThrough
    {
        $showableTransactionStatuses = [
            config("constants.TRANSACTION_STATUS_SUCCESSFUL"),
            config("constants.TRANSACTION_STATUS_ARCHIVED_SUCCESSFUL"),
            config("constants.TRANSACTION_STATUS_PENDING"),
        ];
        $transactions                = $this->orderTransactions()
            ->whereDoesntHave("parents")
            ->where(function ($q) use ($showableTransactionStatuses) {
                /** @var QueryBuilder $q */
                $q->whereIn("transactionstatus_id", $showableTransactionStatuses);
            });

        return $transactions;
    }

    /**
     * Retrieve only order ralated transactions of this user
     */
    public function orderTransactions()
    {
        return $this->hasManyThrough("\App\Transaction", "\App\Order");
    }

    /**
     * Gets user's instalments
     *
     * @return HasManyThrough
     */
    public function getInstalments(): HasManyThrough
    {
        //ToDo : to be tested
        return $this->orderTransactions()
            ->whereDoesntHave("parents")
            ->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_UNPAID"));
    }

    public function orderproducts()
    {
        return $this->hasManyThrough("\App\Orderproduct", "\App\Order");
    }

    public function closedorderproducts()
    {
        return $this->hasManyThrough("\App\Orderproduct", "\App\Order")
            ->whereNotIn("orders.orderstatus_id", Order::OPEN_ORDER_STATUSES);
    }

    /**
     * Retrieve only order ralated transactions of this user
     */
    public function walletTransactions()
    {
        return $this->hasManyThrough("\App\Transaction", "\App\Wallet");
    }

    /**
     * Retrieve all transactions of this user
     */
    public function transactions()
    {
        return $this->hasManyThrough("\App\Transaction", "\App\Wallet");
    }

    public function getClosedOrders($pageNumber = 1)
    {
        $user = $this;
        $key  = 'user:closedOrders:page-' . $pageNumber . ':' . $user->cacheKey();

        return Cache::tags(['user', 'order', 'closedOrder', 'user_' . $user->id, 'user_' . $user->id . '_closedOrders'])->remember($key, config("constants.CACHE_10"), function () use ($user, $pageNumber) {
            return $user->closedOrders()
                ->orderBy('completed_at', 'desc')
                ->paginate(10, ['*'], 'orders', $pageNumber);
        });
    }

    /**
     * Get user's orders that he is allowed to see
     *
     * @return HasMany
     */
    public function closedOrders(): HasMany
    {
        return $this->orders()
            ->whereNotIn("orderstatus_id", Order::OPEN_ORDER_STATUSES);
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
