<?php

namespace App;

/**
 * @property mixed title
 * @property mixed description
 * @property mixed poster
 * @property mixed start_time
 * @property mixed finish_time
 */
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

    protected $hidden = [
        'dayofweek'
    ];

    public function dayOfWeek(){
        return $this->belongsTo(Dayofweek::Class , 'dayofweek_id' , 'id');
    }
}
