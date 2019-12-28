<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Checkoutstatus
 *
 * @property int                 $id
 * @property string|null         $name        نام این وضعیت
 * @property string|null         $displayName نام قابل نمایش این وضعیت
 * @property string|null         $description توضیح این وضعیت
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static Builder|Checkoutstatus whereCreatedAt($value)
 * @method static Builder|Checkoutstatus whereDeletedAt($value)
 * @method static Builder|Checkoutstatus whereDescription($value)
 * @method static Builder|Checkoutstatus whereDisplayName($value)
 * @method static Builder|Checkoutstatus whereId($value)
 * @method static Builder|Checkoutstatus whereName($value)
 * @method static Builder|Checkoutstatus whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Checkoutstatus newModelQuery()
 * @method static Builder|Checkoutstatus newQuery()
 * @method static Builder|Checkoutstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Checkoutstatus extends BaseModel
{
    //
}
