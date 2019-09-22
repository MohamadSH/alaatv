<?php

namespace App;

/**
 * App\Bankaccount
 *
 * @property int                                                              $id
 * @property int|null                                                         $user_id       آی دی مشخص کننده کاربر
 *           صاحب حساب
 * @property int|null                                                         $bank_id       آی دی مشخص کننده بانک حساب
 * @property string|null                                                      $accountNumber شاره حساب
 * @property string|null                                                      $cardNumber    شماره کارت اعتباری حساب
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \App\Bank|null                                              $bank
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @property-read \App\User|null                                              $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Bankaccount onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bankaccount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Bankaccount withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bankaccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null $transactions_count
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
