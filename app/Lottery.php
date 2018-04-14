<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lottery extends Model
{
    use SoftDeletes;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'essentialPoints',
        'prizes',
    ];

    public function users()
    {
        return $this->belongsToMany("\App\User")->withPivot("rank", "prizes");
    }
}
