<?php

namespace App;

use App\Traits\DateCommon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employeeschedule extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'day',
        'beginTime',
        'finishTime',
        'lunchBreakInSeconds'
    ];

    public function user()
    {
        return $this->belongsTo("\App\User");
    }

    public function employeetimesheets()
    {
        return $this->hasMany("\App\Employeetimesheet");
    }

    /**
     * Get the Employeeschedule's beginTime.
     *
     * @param  string $value
     * @return string
     */
    public function getBegintimeAttribute($value)
    {
        $time = new Carbon($value);
        $time = $time->format("H:i");
        return $time . " " . $this->day;
    }

    /**
     * Get the Employeeschedule's finishTime.
     *
     * @param  string $value
     * @return string
     */
    public function getFinishtimeAttribute($value)
    {
        $time = new Carbon($value);
        $time = $time->format("H:i");
        return $time . " " . $this->day;
    }

    /**
     * Get the Employeeschedule's lunchBreakInSeconds.
     *
     * @param  string $value
     * @return string
     */
    public function getLunchbreakinsecondsAttribute($value)
    {
        return gmdate("H:i:s", $value);
    }

}
