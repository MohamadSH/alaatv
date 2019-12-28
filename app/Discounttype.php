<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Discounttype
 *
 * @property int                 $id
 * @property string|null         $name        نام
 * @property string|null         $displayName نام قابل نمایش
 * @property string|null         $description توضیح کوتاه
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static Builder|Discounttype whereCreatedAt($value)
 * @method static Builder|Discounttype whereDeletedAt($value)
 * @method static Builder|Discounttype whereDescription($value)
 * @method static Builder|Discounttype whereDisplayName($value)
 * @method static Builder|Discounttype whereId($value)
 * @method static Builder|Discounttype whereName($value)
 * @method static Builder|Discounttype whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Discounttype newModelQuery()
 * @method static Builder|Discounttype newQuery()
 * @method static Builder|Discounttype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Discounttype extends BaseModel
{
    //
}
