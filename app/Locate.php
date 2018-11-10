<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Locate
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Locate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Locate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Locate query()
 */
class Locate extends Model
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
