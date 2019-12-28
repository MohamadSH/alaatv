<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Attributetype
 *
 * @property int                 $id
 * @property string|null         $name        نام این نوع
 * @property string|null         $description توضیح درباره این نوع
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Attributetype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Attributetype whereCreatedAt($value)
 * @method static Builder|Attributetype whereDeletedAt($value)
 * @method static Builder|Attributetype whereDescription($value)
 * @method static Builder|Attributetype whereId($value)
 * @method static Builder|Attributetype whereName($value)
 * @method static Builder|Attributetype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Attributetype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attributetype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Attributetype newModelQuery()
 * @method static Builder|Attributetype newQuery()
 * @method static Builder|Attributetype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Attributetype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];
}
