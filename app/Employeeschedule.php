<?php

namespace App;

use Carbon\Carbon;

/**
 * App\Employeeschedule
 *
 * @property int                                                                    $id
 * @property int                                                                    $user_id             آیدی مشخص
 *           کننده کارمند
 * @property string|null                                                            $day                 روز شیفت
 * @property string                                                                 $beginTime           زمان شروع ساعت
 *           کاری
 * @property string|null                                                            $finishTime          زمان پایان
 *           ساعت کاری
 * @property int                                                                    $lunchBreakInSeconds مدت زمان مجاز
 *           برای استراحت ناهار
 * @property \Carbon\Carbon|null                                                    $created_at
 * @property \Carbon\Carbon|null                                                    $updated_at
 * @property \Carbon\Carbon|null                                                    $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employeetimesheet[] $employeetimesheets
 * @property-read string                                                            $begintime
 * @property-read string                                                            $finishtime
 * @property-read string                                                            $lunchbreakinseconds
 * @property-read \App\User                                                         $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Employeeschedule onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereBeginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereFinishTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereLunchBreakInSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employeeschedule withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Employeeschedule withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeschedule query()
 * @method static where(string $string, int $userId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                             $cache_cooldown_seconds
 * @property-read int|null $employeetimesheets_count
 */
class Employeeschedule extends BaseModel
{
    protected $fillable = [
        'user_id',
        'day',
        'beginTime',
        'finishTime',
        'lunchBreakInSeconds',
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
     * @param  string  $value
     *
     * @return string
     */
    public function getBegintimeAttribute($value)
    {
        $time = new Carbon($value);
        $time = $time->format("H:i");
        
        return $time." ".$this->day;
    }
    
    /**
     * Get the Employeeschedule's finishTime.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getFinishtimeAttribute($value)
    {
        $time = new Carbon($value);
        $time = $time->format("H:i");
        
        return $time." ".$this->day;
    }
    
    /**
     * Get the Employeeschedule's lunchBreakInSeconds.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getLunchbreakinsecondsAttribute($value)
    {
        return gmdate("H:i:s", $value);
    }
}
