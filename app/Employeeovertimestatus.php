<?php

namespace App;

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
 * @property string $name نام وضعیت
 * @property string|null $display_name نام قابل نمایش وضعیت
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employeetimesheet[] $employeetimesheet
 * @property-read int|null $employeetimesheet_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeovertimestatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employeeovertimestatus whereName($value)
 */
class Employeeovertimestatus extends BaseModel
{
    protected $table = 'employeeovertimestatus';
    protected $fillable = [
        'name',
        'display_name',
    ];

    public function employeetimesheet()
    {
        return $this->hasMany(Employeetimesheet::Class , 'overtime_status_id' , 'id');
    }
}
