<?php

namespace App;

class Live extends BaseModel
{
    protected $table = 'liveschedules';

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'dayofweek_id',
        'title',
        'description',
        'poster',
        'start_time',
        'finish_time',
        'first_live',
        'last_live',
        'enable',
    ];

    public function dayOfWeek(){
        return $this->belongsTo(Dayofweek::Class);
    }
}
