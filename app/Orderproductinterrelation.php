<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Orderproductinterrelation
 *
 * @property int                 $id
 * @property string|null         $name        نام
 * @property string|null         $displayName نام قابل نمایش
 * @property string|null         $description توضیح
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static Builder|Orderproductinterrelation whereCreatedAt($value)
 * @method static Builder|Orderproductinterrelation whereDeletedAt($value)
 * @method static Builder|Orderproductinterrelation whereDescription($value)
 * @method static Builder|Orderproductinterrelation whereDisplayName($value)
 * @method static Builder|Orderproductinterrelation whereId($value)
 * @method static Builder|Orderproductinterrelation whereName($value)
 * @method static Builder|Orderproductinterrelation whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Orderproductinterrelation newModelQuery()
 * @method static Builder|Orderproductinterrelation newQuery()
 * @method static Builder|Orderproductinterrelation query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Orderproductinterrelation extends BaseModel
{
    //
}
