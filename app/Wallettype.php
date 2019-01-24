<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Wallettype
 *
 * @property int                                                         $id
 * @property string                                                      $name        نام
 * @property string|null                                                 $displayName نام قابل نمایش
 * @property string|null                                                 $description توضیح کوتاه
 * @property \Carbon\Carbon|null                                         $created_at
 * @property \Carbon\Carbon|null                                         $updated_at
 * @property \Carbon\Carbon|null                                         $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Wallet[] $wallets
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Wallettype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Wallettype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Wallettype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallettype query()
 */
class Wallettype extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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
