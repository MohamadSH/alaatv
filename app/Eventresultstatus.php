<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Eventresultstatus
 *
 * @property int                 $id
 * @property string|null         $name        نام این وضعیت
 * @property string|null         $displayName نام قابل نمایش این وضعیت
 * @property string|null         $description توضیح این وضعیت
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static Builder|Eventresultstatus whereCreatedAt($value)
 * @method static Builder|Eventresultstatus whereDeletedAt($value)
 * @method static Builder|Eventresultstatus whereDescription($value)
 * @method static Builder|Eventresultstatus whereDisplayName($value)
 * @method static Builder|Eventresultstatus whereId($value)
 * @method static Builder|Eventresultstatus whereName($value)
 * @method static Builder|Eventresultstatus whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Eventresultstatus newModelQuery()
 * @method static Builder|Eventresultstatus newQuery()
 * @method static Builder|Eventresultstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Eventresultstatus extends BaseModel
{
    //
}
