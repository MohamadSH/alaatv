<?php

namespace App\PaymentModule\Wallet\Models;

use App\BaseModel;

/**
 * App\Wallettype
 *
 * @property int                 $id
 * @property string              $name        نام
 * @property string|null         $displayName نام قابل نمایش
 * @property string|null         $description توضیح کوتاه
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null                                         $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Wallet[] $wallets
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Wallettype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Wallettype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Wallettype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallettype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                  $cache_cooldown_seconds
 * @property-read int|null $wallets_count
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
        return $this->hasMany(Wallet::class);
    }
}
