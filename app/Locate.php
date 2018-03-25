<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'published'
    ];
}
