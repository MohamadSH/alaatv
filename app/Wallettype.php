<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Wallettype
 *
 * @property int                                                    $id
 * @property string                                                 $name        نام
 * @property string|null                                            $displayName نام قابل نمایش
 * @property string|null                                            $description توضیح کوتاه
 * @property Carbon|null                                    $created_at
 * @property Carbon|null                                    $updated_at
 * @property Carbon|null                                    $deleted_at
 * @property-read Collection|Wallet[] $wallets
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Wallettype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Wallettype whereCreatedAt($value)
 * @method static Builder|Wallettype whereDeletedAt($value)
 * @method static Builder|Wallettype whereDescription($value)
 * @method static Builder|Wallettype whereDisplayName($value)
 * @method static Builder|Wallettype whereId($value)
 * @method static Builder|Wallettype whereName($value)
 * @method static Builder|Wallettype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Wallettype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Wallettype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Wallettype newModelQuery()
 * @method static Builder|Wallettype newQuery()
 * @method static Builder|Wallettype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                  $cache_cooldown_seconds
 * @property-read int|null                                               $wallets_count
 */
class Wallettype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];

    public function wallets()
    {
        return $this->hasMany("\App\Wallet");
    }
}
