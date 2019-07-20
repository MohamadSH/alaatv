<?php

namespace App;

class Dayofweek extends BaseModel
{
    protected $table = 'dayofweek';

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'displayName',
    ];

    public function lives(){
        return $this->hasMany(Live::Class);
    }
}
