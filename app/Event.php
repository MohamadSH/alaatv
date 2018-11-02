<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Event
 *
 * @property int                                                                   $id
 * @property string|null                                                           $name        نام رخداد
 * @property string|null                                                           $displayName نام قابل نمایش
 * @property string|null                                                           $description توضیح درباره رخداد
 * @property string|null                                                           $startTime   زمان شروع
 * @property string|null                                                           $endTime     زمان پایان
 * @property int                                                                   $enable      فعال یا غیر فعال بودن
 * @property \Carbon\Carbon|null                                                   $created_at
 * @property \Carbon\Carbon|null                                                   $updated_at
 * @property \Carbon\Carbon|null                                                   $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Eventresult[]      $eventresults
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Survey[]           $surveys
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Usersurveyanswer[] $usersurveyanswers
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Event onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Event withoutTrashed()
 * @mixin \Eloquent
 */
class Event extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'startTime',
        'endTime',
        'enable',
    ];

    public function surveys()
    {
        return $this->belongsToMany('\App\Survey')
                    ->withPivot("order", "enable", "description");
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
