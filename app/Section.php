<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'order',
        'enable',
    ];

    public function contents()
    {
        return $this->hasMany(Content::Class);
    }

    public function scopeEnable($query)
    {
        return $query->where('enable' , 1);
    }
}
