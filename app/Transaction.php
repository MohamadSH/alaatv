<?php

namespace App;

use Cache;
use App\Collection\TransactionCollection;

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
 * @property \Carbon\Carbon|null                                              $created_at
 * @property string|null                                                      $deadline_at               مهلت پرداخت
 * @property string|null                                                      $completed_at              تاریخ پرداخت
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $children
 * @property-read \App\Bankaccount                                            $destinationBankAccount
 * @property-read \App\Order|null                                             $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $parents
 * @property-read \App\Paymentmethod|null                                     $paymentmethod
 * @property-read \App\Bankaccount                                            $sourceBankAccount
 * @property-read \App\Transactiongateway|null                                $transactiongateway
 * @property-read \App\Transactionstatus|null                                 $transactionstatus
 * @property-read \App\Wallet|null                                            $wallet
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDeadlineAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDestinationBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereManagerComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction wherePaycheckNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction wherePaymentmethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereSourceBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereTraceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereTransactionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereTransactiongatewayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereTransactionstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereWalletId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction authority($authority)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction walletMethod()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property string|null                                                      $description               توضیح تراکنش
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDescription($value)
 * @property-read mixed                                                       $jalali_completed_at
 * @property-read mixed                                                       $jalali_deadline_at
 * @property-read mixed                                                       $transaction_gateway
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property mixed jalali_created_at
 * @property int|null $device_id آی دی دیوایس کاربر
 * @property-read int|null $children_count
 * @property-read mixed $edit_link
 * @property-read mixed $jalali_created_at
 * @property-read mixed $remove_link
 * @property-read int|null $parents_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDeviceId($value)
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
            $parentsArray  = array_add($parentsArray, $counter++, $myTransaction->parents->first());
            $myTransaction = $myTransaction->parents->first();
        }
        if (empty($parentsArray)) {
            return false;
        }
        else {
            return array_last($parentsArray);
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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string                                 $authority
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthority($query, string $authority)
    {
        return $query->where('authority', $authority);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
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
