<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Bloodtype
 *
 * @property int                 $id
 * @property string              $name        نام
 * @property string|null         $displayName نام قابل نمایش
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Bloodtype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Bloodtype whereCreatedAt($value)
 * @method static Builder|Bloodtype whereDeletedAt($value)
 * @method static Builder|Bloodtype whereDisplayName($value)
 * @method static Builder|Bloodtype whereId($value)
 * @method static Builder|Bloodtype whereName($value)
 * @method static Builder|Bloodtype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Bloodtype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bloodtype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Bloodtype newModelQuery()
 * @method static Builder|Bloodtype newQuery()
 * @method static Builder|Bloodtype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Bloodtype extends BaseModel
{
    protected $fillable = [
        'name',
        'displayName',
    ];
}
