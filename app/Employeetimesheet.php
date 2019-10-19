<?php

namespace App;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent as EloquentAlias;

/**
 * App\Employeetimesheet
 *
 * @property int                        $id
 * @property int                        $user_id                آیدی مشخص کننده کارمند
 * @property string                     $date                   تاریخ ساعت کاری
 * @property string|null                $userBeginTime          ساعت شروع شیفت کارمند
 * @property string|null                $userFinishTime         ساعت پایان شیفت کارمند
 * @property int|null                   $allowedLunchBreakInSec مدت زمان مجاز برای استراحت ناهار
 * @property string|null                $clockIn                زمان ورود به محل کار
 * @property string|null                $beginLunchBreak        زمان خروج برای استراحت ناهار
 * @property string|null                $finishLunchBreak       زمان پایان استراحت ناهار
 * @property string|null                $clockOut               زمان خروج از مجل کار
 * @property int                        $breakDurationInSeconds زمان استراحت و کسری ساعت کاری بر حسب ثانیه
 * @property int                        $timeSheetLock          قفل بودن ساعت کاری
 * @property int|null                   $workdaytype_id         نوع روز کاری
 * @property int                        $isPaid                 مشخص کننده تسویه یا تسویه ساعت کاری
 * @property string|null                $managerComment         توضیحات مدیر
 * @property string|null                $employeeComment        توضیح کارمند
 * @property int|null                   $modifier_id            آیدی مشخص کننده کاربری که آخرین بار رکورد را اصلاح کرده است
 * @property string                     $created_at
 * @property string                     $updated_at
 * @property \Carbon\Carbon|null        $deleted_at
 * @property string                     $allowedlunchbreakinsec
 * @property string                     $beginlunchbreak
 * @property string                     $breakdurationinseconds
 * @property string                     $clockin
 * @property string                     $clockout
 * @property string                     $finishlunchbreak
 * @property-read string                $ispaid
 * @property-read string                $timesheetlock
 * @property string                     $userbegintime
 * @property string                     $userfinishtime
 * @property-read \App\User|null        $modifier
 * @property-write mixed                $employeecomment
 * @property-write mixed                $managercomment
 * @property-read \App\User             $user
 * @property-read \App\Workdaytype|null $workdaytype
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Employeetimesheet onlyTrashed()
 * @method static bool|null restore()
 * @method static EloquentAlias\Builder|Employeetimesheet whereAllowedLunchBreakInSec($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereBeginLunchBreak($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereBreakDurationInSeconds($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereClockIn($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereClockOut($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereCreatedAt($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereDate($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereDeletedAt($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereEmployeeComment($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereFinishLunchBreak($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereId($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereIsPaid($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereManagerComment($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereModifierId($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereTimeSheetLock($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereUpdatedAt($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereUserBeginTime($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereUserFinishTime($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereUserId($value)
 * @method static EloquentAlias\Builder|Employeetimesheet whereWorkdaytypeId($value)
 * @method static \Illuminate\Database\Query\Builder|Employeetimesheet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Employeetimesheet withoutTrashed()
 * @method static where(string $string, \static $today)
 * @method count()
 * @method isNotEmpty()
 * @method first()
 * @method static orderBy(string $string, string $string1)
 * @method whereIn(string $string, $usersId)
 * @method whereBetween(string $string, array $array)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                 $obtain_work_and_shift_diff_in_hour
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeetimesheet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeetimesheet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeetimesheet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeetimesheet whereOvertimeConfirmation($value)
 * @property-read mixed                 $cache_cooldown_seconds
 * @property int|null $overtime_status_id وضعیت اضافه کاری
 * @property-read \App\Employeeovertimestatus $overtimestatus
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeetimesheet whereOvertimeStatusId($value)
 */
class Employeetimesheet extends BaseModel
{
    protected $fillable = [
        'user_id',
        'date',
        'userBeginTime',
        'userFinishTime',
        'allowedLunchBreakInSec',
        'clockIn',
        'beginLunchBreak',
        'finishLunchBreak',
        'clockOut',
        'breakDurationInSeconds',
        'workdaytype_id',
        'isPaid',
        'managerComment',
        'employeeComment',
        'modifier_id',
        'overtime_status_id',
        'timeSheetLock',
    ];

    /**
     * Set the employeeTimeSheet's clockIn.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setClockinAttribute($value)
    {
        if (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $value = explode(":", $value);

            $hour = $value[0];
            if (strlen($hour) == 0) {
                $hour = "00";
            }

            $minute = $value[1];
            if (strlen($minute) == 0) {
                $minute = "00";
            }

            $this->attributes['clockIn'] = $hour.":".$minute;
        }
    }

    /**
     * Set the employeeTimeSheet's clockIn.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setBeginlunchbreakAttribute($value)
    {
        if (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $value = explode(":", $value);

            $hour = $value[0];
            if (strlen($hour) == 0) {
                $hour = "00";
            }

            $minute = $value[1];
            if (strlen($minute) == 0) {
                $minute = "00";
            }

            $this->attributes['beginLunchBreak'] = $hour.":".$minute;
        }
    }

    /**
     * Set the employeeTimeSheet's clockIn.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setFinishlunchbreakAttribute($value)
    {
        if (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $value = explode(":", $value);

            $hour = $value[0];
            if (strlen($hour) == 0) {
                $hour = "00";
            }

            $minute = $value[1];
            if (strlen($minute) == 0) {
                $minute = "00";
            }

            $this->attributes['finishLunchBreak'] = $hour.":".$minute;
        }
    }

    /**
     * Set the employeeTimeSheet's clockIn.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setClockoutAttribute($value)
    {
        if (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $value = explode(":", $value);

            $hour = $value[0];
            if (strlen($hour) == 0) {
                $hour = "00";
            }

            $minute = $value[1];
            if (strlen($minute) == 0) {
                $minute = "00";
            }

            $this->attributes['clockOut'] = $hour.":".$minute;
        }
    }

    /**
     * Set the employeeTimeSheet's userBeginTime.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setUserbegintimeAttribute($value)
    {
        if (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $value = explode(":", $value);

            $hour = $value[0];
            if (strlen($hour) == 0) {
                $hour = "00";
            }

            $minute = $value[1];
            if (strlen($minute) == 0) {
                $minute = "00";
            }

            $this->attributes['userBeginTime'] = $hour.":".$minute;
        }
    }

    /**
     * Set the employeeTimeSheet's userFinishTime.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setUserfinishtimeAttribute($value)
    {
        if (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $value = explode(":", $value);

            $hour = $value[0];
            if (strlen($hour) == 0) {
                $hour = "00";
            }

            $minute = $value[1];
            if (strlen($minute) == 0) {
                $minute = "00";
            }

            $this->attributes['userFinishTime'] = $hour.":".$minute;
        }
    }

    /**
     * Set the employeeTimeSheet's breakDurationInSeconds.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setBreakdurationinsecondsAttribute($value)
    {
        if (strcmp(gettype($value), "integer") == 0) {
            $this->attributes['breakDurationInSeconds'] = $value;
        }
        elseif (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $breakTime                                  = explode(":", $value);
            $this->attributes['breakDurationInSeconds'] = $breakTime[0] * 3600 + $breakTime[1] * 60;
        }
    }

    /**
     * Set the employeeTimeSheet's managerComment.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setManagercommentAttribute($value)
    {
        if (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $this->attributes['managerComment'] = $value;
        }
        else {
            $this->attributes['managerComment'] = null;
        }
    }

    /**
     * Set the employeeTimeSheet's employeeComment.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setEmployeecommentAttribute($value)
    {
        if (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $this->attributes['employeeComment'] = $value;
        }
        else {
            $this->attributes['managerComment'] = null;
        }
    }

    /**
     * Set the employeeTimeSheet's date.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)
            ->format('Y-m-d');
    }

    /**
     * Set the employeeTimeSheet's breakDurationInSeconds.
     *
     * @param  string  $value
     *
     * @return void
     */
    public function setAllowedlunchbreakinsecAttribute($value)
    {
        if (strcmp(gettype($value), "integer") == 0) {
            $this->attributes['allowedLunchBreakInSec'] = $value;
        }
        elseif (strlen(preg_replace('/\s+/', '', $value)) != 0) {
            $breakTime                                  = explode(":", $value);
            $this->attributes['allowedLunchBreakInSec'] = $breakTime[0] * 3600 + $breakTime[1] * 60;
        }
    }

    /**
     * Get the Employeeschedule's userBeginTime.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getUserbegintimeAttribute($value)
    {
        if (!isset($value)) {
            return "00:00:00";
        }
        else {
            return $value;
        }
    }

    /**
     * Get the Employeeschedule's usrFinishTime.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getUserfinishtimeAttribute($value)
    {
        if (!isset($value)) {
            return "00:00:00";
        }
        else {
            return $value;
        }
    }

    /**
     * Get the Employeeschedule's clockIn.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getClockinAttribute($value)
    {
        if (!isset($value)) {
            return "00:00:00";
        }
        else {
            return $value;
        }
    }

    /**
     * Get the Employeeschedule's date.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getBeginlunchbreakAttribute($value)
    {

        if (!isset($value)) {
            return "00:00:00";
        }
        else {
            return $value;
        }
    }

    /**
     * Get the Employeeschedule's beginLunchBreak.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getFinishlunchbreakAttribute($value)
    {
        if (!isset($value)) {
            return "00:00:00";
        }
        else {
            return $value;
        }
    }

    /**
     * Get the Employeeschedule's clockOut.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getClockoutAttribute($value)
    {
        if (!isset($value)) {
            return "00:00:00";
        }
        else {
            return $value;
        }
    }

    /**
     * Get the employeeTimeSheet's breakDurationInSeconds.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getAllowedlunchbreakinsecAttribute($value)
    {
        if (isset($value)) {
            return gmdate("H:i:s", $value);
        }
        else {
            return null;
        }
    }

    /**
     * Get the Employeeschedule's lunchBreakInSeconds.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getBreakdurationinsecondsAttribute($value)
    {
        return gmdate("H:i:s", $value);
    }

    /**
     * Get the Employeeschedule's timeSheetLock.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getTimesheetlockAttribute($value)
    {
        if ($value) {
            return "بله";
        }
        else {
            return "خیر";
        }
    }

    /**
     * Get the Employeeschedule's isPaid.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getIspaidAttribute($value)
    {
        if ($value) {
            return "بله";
        }
        else {
            return "خیر";
        }
    }

    /**
     * Get the Employeeschedule's updated_at.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        /*$explodedDateTime = explode(" ", $value);*/
        /*$explodedTime = $explodedDateTime[1] ;*/
        return $this->convertDate($value, "toJalali");
    }

    /**
     * Get the Employeeschedule's created_at.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        /*$explodedDateTime = explode(" ", $value);*/
        /*$explodedTime = $explodedDateTime[1] ;*/
        return $this->convertDate($value, "toJalali");
    }

    /**
     * Get the Employeeschedule's date.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getDateAttribute($value)
    {
        return $this->convertDate($value, "toJalali");
    }

    /**
     * Get the Employeeschedule's date.
     *
     * @param $mode
     *
     * @return string
     */
    public function getDate($mode)
    {
        switch ($mode) {
            case "WEEK_DAY":
                return $this->convertToJalaliDay(Carbon::parse($this->getOriginal("date"))
                    ->format('l'));
            default:
                return null;
        }
    }

    public function getEmployeeFullName()
    {
        $fullName = "";
        if (isset($this->user->id) && isset($this->user->firstName[0])) {
            $fullName .= $this->user->firstName;
        }
        if (isset($this->user->id) && isset($this->user->lastName[0])) {
            if (strlen($fullName) > 0) {
                $fullName .= " ".$this->user->lastName;
            }
            else {
                $fullName .= $this->user->lastName;
            }
        }

        return $fullName;
    }

    public function getModifierFullName()
    {
        return $this->modifier->firstName." ".$this->modifier->lastName;
    }

    public function user()
    {
        return $this->belongsTo("\App\User");
    }

    public function modifier()
    {
        return $this->belongsTo("\App\User");
    }

    public function workdaytype()
    {
        return $this->belongsTo("\App\Workdaytype");
    }

    public function overtimestatus(){
        return $this->belongsTo(Employeeovertimestatus::Class , 'id' , 'overtime_status_id');
    }

    public function getObtainWorkAndShiftDiffInHourAttribute()
    {
        return $this->obtainWorkAndShiftDiff('HOUR_FORMAT');
    }

    /**
     * Obtain the employeeTimeSheet workAndShiftDiff
     *
     * @param  string  $mode
     *
     * @return bool|false|int|string
     */
    public function obtainWorkAndShiftDiff($mode = "IN_SECONDS")
    {
        switch ($mode) {
            case "IN_SECONDS" :
                if ($this->obtainRealWorkTime("HOUR_FORMAT") !== false && $this->obtainShiftTime() !== false) {
                    $beginTime        = Carbon::parse($this->obtainRealWorkTime("HOUR_FORMAT"));
                    $finishTime       = Carbon::parse($this->obtainShiftTime());
                    $workAndShiftDiff = $finishTime->diffInSeconds($beginTime, false);

                    return $workAndShiftDiff;
                }
                else {
                    return false;
                }
                break;
            case "HOUR_FORMAT":
                if ($this->obtainRealWorkTime("HOUR_FORMAT") !== false && $this->obtainShiftTime() !== false) {
                    $beginTime        = Carbon::parse($this->obtainRealWorkTime("HOUR_FORMAT"));
                    $finishTime       = Carbon::parse($this->obtainShiftTime());
                    $workAndShiftDiff = $finishTime->diffInSeconds($beginTime, false);
                    if ($workAndShiftDiff < 0) {
                        return gmdate("H:i", abs($workAndShiftDiff))." منفی";
                    }
                    else {
                        return gmdate("H:i", abs($workAndShiftDiff));
                    }
                }
                else {
                    return false;
                }
                break;
            case "PERSIAN_FORMAT":
                if ($this->obtainRealWorkTime("HOUR_FORMAT") !== false && $this->obtainShiftTime() !== false) {
                    $beginTime             = Carbon::parse($this->obtainRealWorkTime("HOUR_FORMAT"));
                    $finishTime            = Carbon::parse($this->obtainShiftTime());
                    $workAndShiftDiffInSec = $finishTime->diffInSeconds($beginTime, false);
                    $workAndShiftDiff      = gmdate("H:i:s", abs($workAndShiftDiffInSec));
                    $shiftTime             = explode(":", $workAndShiftDiff);
                    $hour                  = $shiftTime[0];
                    $minute                = $shiftTime[1];
                    $second                = $shiftTime[2];
                    $persianTime           = "";
                    if ($hour > 0) {
                        $persianTime .= $hour." ساعت ";
                    }
                    if ($minute > 0) {
                        $persianTime .= $minute." دقیقه ";
                    }
                    if ($second > 0) {
                        $persianTime .= $second." ثانیه ";
                    }

                    if ($workAndShiftDiffInSec < 0) {
                        $persianTime .= " کم کاری";
                    }
                    else {
                        $persianTime .= " اضافه کاری";
                    }

                    return $persianTime;
                }
                else {
                    return false;
                }
            default:
                return false;
        }
    }

    /**
     * Obtain the employeeTimeSheet realWorkTime
     *
     * @param  string  $mode
     *
     * @return bool|int|string
     */
    public function obtainRealWorkTime($mode = "IN_SECONDS")
    {
        switch ($mode) {
            case "IN_SECONDS":
                if (isset($this->allowedLunchBreakInSec) && $this->obtainWorkTime() !== false && $this->obtainTotalBreakTime() !== false) {
                    $beginTime    = Carbon::parse($this->obtainWorkTime());
                    $finishTime   = Carbon::parse($this->obtainTotalBreakTime());
                    $realWorkTime = $finishTime->diffInSeconds($beginTime);

                    return $realWorkTime;
                }
                else {
                    return false;
                }
                break;
            case "HOUR_FORMAT":
                if (isset($this->allowedLunchBreakInSec) && $this->obtainWorkTime() !== false && $this->obtainTotalBreakTime() !== false) {
                    $beginTime    = Carbon::parse($this->obtainWorkTime());
                    $finishTime   = Carbon::parse($this->obtainTotalBreakTime());
                    $realWorkTime = $finishTime->diff($beginTime)
                        ->format('%H:%I:%S');

                    return $realWorkTime;
                }
                else {
                    return false;
                }
                break;
            default:
                return false;
        }
    }

    /**
     * Obtain the employeeTimeSheet workTime
     */
    public function obtainWorkTime()
    {
        if (isset($this->clockIn) && isset($this->clockOut)) {
            $beginTime  = Carbon::parse($this->clockIn);
            $finishTime = Carbon::parse($this->clockOut);
            $workTime   = $finishTime->diff($beginTime)
                ->format('%H:%I:%S');

            return $workTime;
        }
        else {
            return false;
        }
    }

    /**
     * Obtain the employeeTimeSheet totalBreakTime
     */
    public function obtainTotalBreakTime()
    {
        $lunchOverTime = $this->obtainLunchOverTimeInSec();
        if ($lunchOverTime !== false) {
            if ($lunchOverTime < 0) {
                $totalBreak = $this->getOriginal("breakDurationInSeconds") + abs($lunchOverTime);
            }
            else {
                $totalBreak = $this->getOriginal("breakDurationInSeconds");
            }

            return gmdate("H:i:s", $totalBreak);
        }
        else {
            return false;
        }
    }

    /**
     * Obtain the employeeTimeSheet lunchOverTimeInSeconds
     */
    public function obtainLunchOverTimeInSec()
    {
        if (isset($this->allowedLunchBreakInSec) && $this->obtainLunchTime() !== false) {
            $beginTime  = Carbon::parse($this->allowedLunchBreakInSec);
            $finishTime = Carbon::parse($this->obtainLunchTime());

            return $finishTime->diffInSeconds($beginTime, false);
        }
        else {
            return false;
        }
    }

    /**
     * Obtain the employeeTimeSheet lunchTime
     */
    public function obtainLunchTime()
    {
        if (isset($this->beginLunchBreak) && isset($this->finishLunchBreak)) {
            $beginTime  = Carbon::parse($this->beginLunchBreak);
            $finishTime = Carbon::parse($this->finishLunchBreak);
            $lunchTime  = $finishTime->diff($beginTime)
                ->format('%H:%I:%S');

            return $lunchTime;
        }
        else {
            return false;
        }
    }

    /**
     * Obtain the employeeTimeSheet shiftTime
     *
     * @param  string  $mode
     *
     * @return array|bool|int|string
     */
    public function obtainShiftTime($mode = "HOUR_FORMAT")
    {
        switch ($mode) {
            case "IN_SECONDS":
                if (isset($this->userBeginTime) && isset($this->userFinishTime)) {
                    $beginTime  = Carbon::parse($this->userBeginTime);
                    $finishTime = Carbon::parse($this->userFinishTime);
                    $shiftTime  = $finishTime->diffInSeconds($beginTime, false);

                    return $shiftTime;
                }
                else {
                    return false;
                }
                break;
            case "HOUR_FORMAT":
                if (isset($this->userBeginTime) && isset($this->userFinishTime)) {
                    $beginTime  = Carbon::parse($this->userBeginTime);
                    $finishTime = Carbon::parse($this->userFinishTime);
                    $shiftTime  = $finishTime->diff($beginTime)
                        ->format('%H:%I:%S');

                    return $shiftTime;
                }
                else {
                    return false;
                }
                break;
            case "PERSIAN_FORMAT":
                if (isset($this->userBeginTime) && isset($this->userFinishTime)) {
                    $beginTime  = Carbon::parse($this->userBeginTime);
                    $finishTime = Carbon::parse($this->userFinishTime);
                    $shiftTime  = $finishTime->diff($beginTime)
                        ->format('%H:%I:%S');
                    if (strcmp($shiftTime, "00:00:00") == 0) {
                        $persianShiftTime = 0;
                    }
                    else {
                        $shiftTime        = explode(":", $shiftTime);
                        $hour             = $shiftTime[0];
                        $minute           = $shiftTime[1];
                        $second           = $shiftTime[2];
                        $persianShiftTime = "";
                        if ($hour > 0) {
                            $persianShiftTime .= $hour." ساعت ";
                        }
                        if ($minute > 0) {
                            $persianShiftTime .= $minute." دقیقه ";
                        }
                        if ($second > 0) {
                            $persianShiftTime .= $second." ثانیه ";
                        }
                    }

                    return $persianShiftTime;
                }
                else {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
    }
}
