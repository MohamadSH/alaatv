<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Workdaytype
 *
 * @property int                 $id
 * @property string|null         $displayName نام نوع
 * @property string|null         $description توضیح درباره این نوع
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static Builder|Workdaytype whereCreatedAt($value)
 * @method static Builder|Workdaytype whereDeletedAt($value)
 * @method static Builder|Workdaytype whereDescription($value)
 * @method static Builder|Workdaytype whereDisplayName($value)
 * @method static Builder|Workdaytype whereId($value)
 * @method static Builder|Workdaytype whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Workdaytype newModelQuery()
 * @method static Builder|Workdaytype newQuery()
 * @method static Builder|Workdaytype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Workdaytype extends BaseModel
{
    //
}
