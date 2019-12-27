<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Producttype
 *
 * @property int                                                     $id
 * @property string|null                                             $displayName نام قابل نمایش این نوع
 * @property string|null                                             $name        نام این نوع در سیستم
 * @property string|null                                             $description توضیحات این نوع
 * @property Carbon|null                                     $created_at
 * @property Carbon|null                                     $updated_at
 * @property Carbon|null                                     $deleted_at
 * @property-read Collection|Product[] $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Producttype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Producttype whereCreatedAt($value)
 * @method static Builder|Producttype whereDeletedAt($value)
 * @method static Builder|Producttype whereDescription($value)
 * @method static Builder|Producttype whereDisplayName($value)
 * @method static Builder|Producttype whereId($value)
 * @method static Builder|Producttype whereName($value)
 * @method static Builder|Producttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Producttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Producttype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Producttype newModelQuery()
 * @method static Builder|Producttype newQuery()
 * @method static Builder|Producttype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null                                                $products_count
 */
class Producttype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
