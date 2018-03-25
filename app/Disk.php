<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disk extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'disktype_id'
    ];

    public function disktype(){
        return $this->belongsTo("\App\Disktype");
    }

    public function files(){
        return $this->belongsToMany("\App\File")->withPivot("priority");
    }
}
