<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\City
 *
 * @property int                 $id
 * @property int|null            $province_id آی دی مشخص کننده استان این شهر
 * @property string|null         $name        نام شهر
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Province|null  $province
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|City onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereDeletedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereProvinceId($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|City withTrashed()
 * @method static \Illuminate\Database\Query\Builder|City withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed              $cache_cooldown_seconds
 */
class City extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'province_id',
        'name',
    ];

    public function province()
    {
        return $this->belongsTo('\App\Province');
    }
}
