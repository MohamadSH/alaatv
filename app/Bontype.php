<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bontype extends Model
{
    use SoftDeletes;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];

    public function bons()
    {
        return $this->hasMany("\App\Bon");
    }
}
