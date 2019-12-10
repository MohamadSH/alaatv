<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Transactionstatus
 *
 * @property int                                                              $id
 * @property string|null                                                      $name        نام وضعیت
 * @property string|null                                                      $displayName نام قابل نمایش این وضعیت
 * @property int                                                              $order       ترتیب
 * @property string|null                                                      $description توضیح درباره وضعیت
 * @property Carbon|null                                              $created_at
 * @property Carbon|null                                              $updated_at
 * @property Carbon|null                                              $deleted_at
 * @property-read Collection|Transaction[] $transactions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Transactionstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Transactionstatus whereCreatedAt($value)
 * @method static Builder|Transactionstatus whereDeletedAt($value)
 * @method static Builder|Transactionstatus whereDescription($value)
 * @method static Builder|Transactionstatus whereDisplayName($value)
 * @method static Builder|Transactionstatus whereId($value)
 * @method static Builder|Transactionstatus whereName($value)
 * @method static Builder|Transactionstatus whereOrder($value)
 * @method static Builder|Transactionstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Transactionstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Transactionstatus withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Transactionstatus newModelQuery()
 * @method static Builder|Transactionstatus newQuery()
 * @method static Builder|Transactionstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null $transactions_count
 */
class Transactionstatus extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
