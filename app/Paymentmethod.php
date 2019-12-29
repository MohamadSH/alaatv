<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Paymentmethod
 *
 * @property int                                                         $id
 * @property string|null                                                 $name        نام این روش
 * @property string|null                                                 $displayName نام قابل نمایش روش
 * @property string|null                                                 $description توضیح این روش
 * @property Carbon|null                                         $created_at
 * @property Carbon|null                                         $updated_at
 * @property Carbon|null                                         $deleted_at
 * @property-read Collection|Transaction[] $transactions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Paymentmethod onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Paymentmethod whereCreatedAt($value)
 * @method static Builder|Paymentmethod whereDeletedAt($value)
 * @method static Builder|Paymentmethod whereDescription($value)
 * @method static Builder|Paymentmethod whereDisplayName($value)
 * @method static Builder|Paymentmethod whereId($value)
 * @method static Builder|Paymentmethod whereName($value)
 * @method static Builder|Paymentmethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Paymentmethod withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Paymentmethod withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Paymentmethod newModelQuery()
 * @method static Builder|Paymentmethod newQuery()
 * @method static Builder|Paymentmethod query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null                                                    $transactions_count
 */
class Paymentmethod extends BaseModel
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
        return $this->hasMany('\App\Transaction');
    }
}
