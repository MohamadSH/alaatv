<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disk extends Model
{
    use SoftDeletes;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'disktype_id'
    ];

    public function disktype()
    {
        return $this->belongsTo("\App\Disktype");
    }

    public function files()
    {
        return $this->belongsToMany("\App\File")->withPivot("priority");
    }
}
