<?php

namespace App;

use Cache;
use App\Collection\TransactionCollection;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

/**
 * App\Transaction
 *
 * @property int                                                              $id
 * @property int|null                                                         $order_id                  آیدی مشخص
 *           کننده سفارشی که تراکنش متعلق به آن است
 * @property int|null                                                         $wallet_id                 آیدی مشخص
 *           کننده کیف پولی که تراکنش متعلق به آن است
 * @property int|null                                                         $cost                      مبلغ تراکنش
 * @property string|null                                                      $authority                 شماره اتوریتی
 *           تولید شده از طرف درگاه
 * @property string|null                                                      $transactionID             کد پیگیری
 *           تراکنش
 * @property string|null                                                      $traceNumber               شماره پیگیری
 * @property string|null                                                      $referenceNumber           شماره مرجع
 * @property string|null                                                      $paycheckNumber            شماره چک (در
 *           صورت پرداخت با چک بانکی)
 * @property string|null                                                      $managerComment            توضیح مسئول
 *           درباره تراکنش
 * @property int|null                                                         $sourceBankAccount_id      آی دی مشخص
 *           کننده شماره حساب مبدا
 * @property int|null                                                         $destinationBankAccount_id آی دی مشخص
 *           کننده شماره حساب مقصد
 * @property int|null                                                         $paymentmethod_id          آی دی مشخص
 *           کننده روش پرداخت
 * @property int|null                                                         $transactiongateway_id     آیدی مشخص
 *           کننده درگاه تراکنش
 * @property int|null                                                         $transactionstatus_id      آیدی مشخص
 *           کننده وضعیت تراکنش
 * @property Carbon|null                                              $created_at
 * @property string|null                                                      $deadline_at               مهلت پرداخت
 * @property string|null                                                      $completed_at              تاریخ پرداخت
 * @property Carbon|null                                              $updated_at
 * @property Carbon|null                                              $deleted_at
 * @property-read Collection|Transaction[] $children
 * @property-read Bankaccount $destinationBankAccount
 * @property-read Order|null                                             $order
 * @property-read Collection|Transaction[] $parents
 * @property-read Paymentmethod|null                                     $paymentmethod
 * @property-read Bankaccount $sourceBankAccount
 * @property-read Transactiongateway|null                                $transactiongateway
 * @property-read Transactionstatus|null                                 $transactionstatus
 * @property-read Wallet|null                                            $wallet
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Transaction onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Transaction whereAuthority($value)
 * @method static Builder|Transaction whereCompletedAt($value)
 * @method static Builder|Transaction whereCost($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereDeadlineAt($value)
 * @method static Builder|Transaction whereDeletedAt($value)
 * @method static Builder|Transaction whereDestinationBankAccountId($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereManagerComment($value)
 * @method static Builder|Transaction whereOrderId($value)
 * @method static Builder|Transaction wherePaycheckNumber($value)
 * @method static Builder|Transaction wherePaymentmethodId($value)
 * @method static Builder|Transaction whereReferenceNumber($value)
 * @method static Builder|Transaction whereSourceBankAccountId($value)
 * @method static Builder|Transaction whereTraceNumber($value)
 * @method static Builder|Transaction whereTransactionID($value)
 * @method static Builder|Transaction whereTransactiongatewayId($value)
 * @method static Builder|Transaction whereTransactionstatusId($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @method static Builder|Transaction whereWalletId($value)
 * @method static \Illuminate\Database\Query\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Transaction withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction authority($authority)
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|Transaction walletMethod()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property string|null                                                      $description               توضیح تراکنش
 * @method static Builder|Transaction whereDescription($value)
 * @property-read mixed                                                       $jalali_completed_at
 * @property-read mixed                                                       $jalali_deadline_at
 * @property-read mixed                                                       $transaction_gateway
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property mixed jalali_created_at
 * @property int|null $device_id آی دی دیوایس کاربر
 * @property-read int|null $children_count
 * @property-read mixed $edit_link
 * @property-read mixed $remove_link
 * @property-read int|null $parents_count
 * @method static Builder|Transaction whereDeviceId($value)
 */
class Transaction extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'order_id',
        'wallet_id',
        'cost',
        'authority',
        'transactionID',
        'traceNumber',
        'referenceNumber',
        'paycheckNumber',
        'managerComment',
        'sourceBankAccount_id',
        'destinationBankAccount_id',
        'paymentmethod_id',
        'transactiongateway_id',
        'transactionstatus_id',
        'completed_at',
        'deadline_at',
        'description',
        'device_id',
    ];

    protected $appends = [
        'paymentmethod',
        'transactiongateway',
        'jalaliCompletedAt',
        'jalaliDeadlineAt',
        'editLink',
        'removeLink',
    ];

    protected $hidden = [
        'order_id',
        'destinationBankAccount_id',
        'paymentmethod_id',
        'transactiongateway_id',
        'updated_at',
    ];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return TransactionCollection
     */
    public function newCollection(array $models = [])
    {
        return new TransactionCollection($models);
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function transactionstatus()
    {
        return $this->belongsTo('App\Transactionstatus');
    }

    public function sourceBankAccount()
    {
        return $this->belongsTo('\App\Bankaccount', 'bankaccounts', 'sourceBankAccount_id', 'id');
    }

    public function destinationBankAccount()
    {
        return $this->belongsTo('\App\Bankaccount', 'bankaccounts', 'destinationBankAccount_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo("\App\Wallet");
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function DeadlineAt_Jalali()
    {
        /*$explodedDateTime = explode(" ", $this->deadline_at);*/
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->deadline_at, "toJalali");
    }

    public function parents()
    {
        return $this->belongsToMany('App\Transaction', 'transaction_transaction', 't2_id',
            't1_id')
            ->withPivot('relationtype_id')
            ->join('transactioninterraltions', 'relationtype_id',
                'transactioninterraltions.id')//            ->select('major1_id AS id', 'majorinterrelationtypes.name AS pivot_relationName' , 'majorinterrelationtypes.displayName AS pivot_relationDisplayName')
        ->where("relationtype_id", config("constants.TRANSACTION_INTERRELATION_PARENT_CHILD"));
    }

    public function children()
    {
        return $this->belongsToMany('App\Transaction', 'transaction_transaction', 't1_id',
            't2_id')
            ->withPivot('relationtype_id')
            ->join('transactioninterraltions', 'relationtype_id', 'contenttypeinterraltions.id')
            ->where("relationtype_id",
                config("constants.TRANSACTION_INTERRELATION_PARENT_CHILD"));
    }

    public function getGrandParent()
    {
        $counter       = 1;
        $parentsArray  = [];
        $myTransaction = $this;
        while ($myTransaction->hasParents()) {
            $parentsArray  = Arr::add($parentsArray, $counter++, $myTransaction->parents->first());
            $myTransaction = $myTransaction->parents->first();
        }
        if (empty($parentsArray)) {
            return false;
        }
        else {
            return Arr::last($parentsArray);
        }
    }

    public function hasParents($depth = 1)
    {
        $counter       = 0;
        $myTransaction = $this;
        while (!$myTransaction->parents->isEmpty()) {
            if ($counter >= $depth) {
                break;
            }
            $myTransaction = $myTransaction->parents->first();
            $counter++;
        }
        if ($myTransaction->id == $this->id || $counter != $depth) {
            return false;
        }
        else {
            return true;
        }
    }

    public function getCode()
    {
        if (isset($this->transactionID)) {
            return "شماره تراکنش: ".$this->transactionID;
        }
        else {
            if (isset($this->traceNumber)) {
                return "شماره پیگیری: ".$this->traceNumber;
            }
            else {
                if (isset($this->referenceNumber)) {
                    return "شماره مرجع: ".$this->referenceNumber;
                }
                else {
                    if (isset($this->paycheckNumber)) {
                        return "شماره چک: ".$this->paycheckNumber;
                    }
                    else {
                        return false;
                    }
                }
            }
        }
    }

    /**
     * @param  Builder  $query
     * @param  string                                 $authority
     *
     * @return Builder
     */
    public function scopeAuthority($query, string $authority)
    {
        return $query->where('authority', $authority);
    }

    /**
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeWalletMethod($query)
    {
        return $query->where("paymentmethod_id", config("constants.PAYMENT_METHOD_WALLET"));
    }

    public function depositThisWalletTransaction()
    {
        $wallet = $this->wallet;
        $amount = $this->cost;
        if (isset($wallet)) {
            $response = $wallet->deposit($amount);
        }
        else {
            $response = ["result" => false];
        }

        return $response;
    }

    public function getTransactionGatewayAttribute()
    {
        return optional($this->transactiongateway()
            ->first())->setVisible([
            'name',
            'displayName',
            'description',
        ]);
    }

    public function transactiongateway()
    {
        return $this->belongsTo('App\Transactiongateway');
    }

    public function getPaymentmethodAttribute()
    {
        return optional($this->paymentmethod()
            ->first())->setVisible([
            'name',
            'displayName',
            'description',
        ]);
    }

    public function paymentmethod()
    {
        return $this->belongsTo('\App\Paymentmethod');
    }

    public function getJalaliCompletedAtAttribute()
    {
        $transaction = $this;
        $key         = "transaction:jalaliCompletedAt:".$transaction->cacheKey();
        return Cache::tags(["transaction"])
            ->remember($key, config("constants.CACHE_600"), function () use ($transaction) {
                if(isset($transaction->completed_at))
                    return $this->convertDate($transaction->completed_at, "toJalali");

                return null;
            });
    }

    public function getJalaliDeadlineAtAttribute()
    {
        $transaction = $this;
        $key         = "transaction:jalaliDeadlineAt:".$transaction->cacheKey();
        return Cache::tags(["transaction"])
            ->remember($key, config("constants.CACHE_600"), function () use ($transaction) {
                if(isset($transaction->deadline_at))
                    return $this->convertDate($transaction->deadline_at, "toJalali");

                return null;
            });
    }

    public function getJalaliCreatedAtAttribute()
    {
        $transaction = $this;
        $key         = "transaction:jalaliCreatedAt:".$transaction->cacheKey();
        return Cache::tags(["transaction"])
            ->remember($key, config("constants.CACHE_600"), function () use ($transaction) {
                if(isset($transaction->created_at))
                    return $this->convertDate($transaction->created_at, "toJalali");

                return null;
            });
    }

    public function getEditLinkAttribute()
    {
        if (hasAuthenticatedUserPermission(config('constants.EDIT_TRANSACTION_ACCESS')))
            return action('Web\TransactionController@edit', $this->id);

        return null;

    }

    public function getRemoveLinkAttribute()
    {
        if (hasAuthenticatedUserPermission(config('constants.REMOVE_TRANSACTION_ACCESS')))
            return action('Web\TransactionController@destroy', $this->id);

        return null;
    }

}
