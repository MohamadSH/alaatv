<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int user_id
 */
class Firebasetoken extends Model
{
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'token',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
