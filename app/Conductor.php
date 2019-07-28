<?php

namespace App;

/**
 * @property mixed poster
 * @property mixed scheduled_finish_time
 */
class Conductor extends BaseModel
{
    protected $table = 'liveconductors';

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'poster',
        'date',
        'scheduled_start_time',
        'scheduled_finish_time',
        'start_time',
        'finish_time',
    ];
}
