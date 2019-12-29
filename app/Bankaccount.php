<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Bankaccount
 *
 * @property int                           $id
 * @property int|null                      $user_id       آی دی مشخص کننده کاربر
 *           صاحب حساب
 * @property int|null                      $bank_id       آی دی مشخص کننده بانک حساب
 * @property string|null                   $accountNumber شاره حساب
 * @property string|null                   $cardNumber    شماره کارت اعتباری حساب
 * @property Carbon|null           $created_at
 * @property Carbon|null           $updated_at
 * @property Carbon|null           $deleted_at
 * @property-read Bank|null                $bank
 * @property-read Collection|Transaction[] $transactions
 * @property-read User|null                $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Bankaccount onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Bankaccount whereAccountNumber($value)
 * @method static Builder|Bankaccount whereBankId($value)
 * @method static Builder|Bankaccount whereCardNumber($value)
 * @method static Builder|Bankaccount whereCreatedAt($value)
 * @method static Builder|Bankaccount whereDeletedAt($value)
 * @method static Builder|Bankaccount whereId($value)
 * @method static Builder|Bankaccount whereUpdatedAt($value)
 * @method static Builder|Bankaccount whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Bankaccount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bankaccount withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Bankaccount newModelQuery()
 * @method static Builder|Bankaccount newQuery()
 * @method static Builder|Bankaccount query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null                                                    $transactions_count
 */
class Bankaccount extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'bank_id',
        'accountNumber',
        'cardNumber',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function bank()
    {
        return $this->belongsTo('\App\Bank');
    }

    public function transactions()
    {
        return $this->hasMany('\App\Transaction');
    }
}
