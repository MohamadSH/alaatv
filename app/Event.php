<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'startTime',
        'endTime',
        'enable',
    ];

    public function surveys()
    {
        return $this->belongsToMany('\App\Survey')->withPivot("order", "enable", "description");
    }

    public function usersurveyanswers()
    {
        return $this->hasMany('\App\Usersurveyanswer');
    }

    public function eventresults()
    {
        return $this->hasMany('\App\Eventresult');
    }
}
