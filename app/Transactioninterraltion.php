<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Transactioninterraltion
 *
 * @property int                 $id
 * @property string|null         $name        نام
 * @property string|null         $displayName نام قابل نمایش
 * @property string|null         $description توضیح
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static Builder|Transactioninterraltion whereCreatedAt($value)
 * @method static Builder|Transactioninterraltion whereDeletedAt($value)
 * @method static Builder|Transactioninterraltion whereDescription($value)
 * @method static Builder|Transactioninterraltion whereDisplayName($value)
 * @method static Builder|Transactioninterraltion whereId($value)
 * @method static Builder|Transactioninterraltion whereName($value)
 * @method static Builder|Transactioninterraltion whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Transactioninterraltion newModelQuery()
 * @method static Builder|Transactioninterraltion newQuery()
 * @method static Builder|Transactioninterraltion query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Transactioninterraltion extends BaseModel
{
    //
}
