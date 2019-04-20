<?php

namespace App;

/**
 * App\Locate
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Locate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Locate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Locate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
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
