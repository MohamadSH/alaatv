<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Employeeschedule
 *
 * @property int                                 $id
 * @property int                                 $user_id             آیدی مشخص
 *           کننده کارمند
 * @property string|null                         $day                 روز شیفت
 * @property string                              $beginTime           زمان شروع ساعت
 *           کاری
 * @property string|null                         $finishTime          زمان پایان
 *           ساعت کاری
 * @property int                                 $lunchBreakInSeconds مدت زمان مجاز
 *           برای استراحت ناهار
 * @property Carbon|null                         $created_at
 * @property Carbon|null                         $updated_at
 * @property Carbon|null                         $deleted_at
 * @property-read Collection|Employeetimesheet[] $employeetimesheets
 * @property-read string                         $begintime
 * @property-read string                         $finishtime
 * @property-read string                         $lunchbreakinseconds
 * @property-read User                           $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Employeeschedule onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Employeeschedule whereBeginTime($value)
 * @method static Builder|Employeeschedule whereCreatedAt($value)
 * @method static Builder|Employeeschedule whereDay($value)
 * @method static Builder|Employeeschedule whereDeletedAt($value)
 * @method static Builder|Employeeschedule whereFinishTime($value)
 * @method static Builder|Employeeschedule whereId($value)
 * @method static Builder|Employeeschedule whereLunchBreakInSeconds($value)
 * @method static Builder|Employeeschedule whereUpdatedAt($value)
 * @method static Builder|Employeeschedule whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Employeeschedule withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Employeeschedule withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Employeeschedule newModelQuery()
 * @method static Builder|Employeeschedule newQuery()
 * @method static Builder|Employeeschedule query()
 * @method static where(string $string, int $userId)
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                             $cache_cooldown_seconds
 * @property-read int|null                                                          $employeetimesheets_count
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
     * @param string $value
     *
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
     * @param string $value
     *
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
     * @param string $value
     *
     * @return string
     */
    public function getLunchbreakinsecondsAttribute($value)
    {
        return gmdate("H:i:s", $value);
    }
}
