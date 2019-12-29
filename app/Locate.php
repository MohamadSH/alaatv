<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Locate
 *
 * @mixin Eloquent
 * @method static Builder|Locate newModelQuery()
 * @method static Builder|Locate newQuery()
 * @method static Builder|Locate query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed $cache_cooldown_seconds
 */
class Locate extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'globalCode',
        'lft',
        'rgt',
        'lvl',
        'parent_id',
        'published',
    ];
}
