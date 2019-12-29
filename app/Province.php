<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Province
 *
 * @property int                                                  $id
 * @property string|null                                          $name نام استان
 * @property Carbon|null                                  $created_at
 * @property Carbon|null                                  $updated_at
 * @property Carbon|null                                  $deleted_at
 * @property-read Collection|City[] $cities
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Province onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Province whereCreatedAt($value)
 * @method static Builder|Province whereDeletedAt($value)
 * @method static Builder|Province whereId($value)
 * @method static Builder|Province whereName($value)
 * @method static Builder|Province whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Province withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Province withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Province newModelQuery()
 * @method static Builder|Province newQuery()
 * @method static Builder|Province query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null                                             $cities_count
 */
class Province extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'province_id',
        'name',
    ];

    public function cities()
    {
        return $this->hasMany('\App\City');
    }
}
