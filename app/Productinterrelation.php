<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Productinterrelation
 *
 * @property int                 $id
 * @property string|null         $name        نام
 * @property string|null         $displayName نام قابل نمایش
 * @property string|null         $description توضیح
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static Builder|Productinterrelation whereCreatedAt($value)
 * @method static Builder|Productinterrelation whereDeletedAt($value)
 * @method static Builder|Productinterrelation whereDescription($value)
 * @method static Builder|Productinterrelation whereDisplayName($value)
 * @method static Builder|Productinterrelation whereId($value)
 * @method static Builder|Productinterrelation whereName($value)
 * @method static Builder|Productinterrelation whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Productinterrelation newModelQuery()
 * @method static Builder|Productinterrelation newQuery()
 * @method static Builder|Productinterrelation query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Productinterrelation extends BaseModel
{
    //
}
