<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Event
 *
 * @property int                                $id
 * @property string|null                        $name        نام رخداد
 * @property string|null                        $displayName نام قابل نمایش
 * @property string|null                        $description توضیح درباره رخداد
 * @property string|null                        $startTime   زمان شروع
 * @property string|null                        $endTime     زمان پایان
 * @property int                                $enable      فعال یا غیر فعال بودن
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @property Carbon|null                $deleted_at
 * @property-read Collection|Eventresult[]      $eventresults
 * @property-read Collection|Survey[]           $surveys
 * @property-read Collection|Usersurveyanswer[] $usersurveyanswers
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Event onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDeletedAt($value)
 * @method static Builder|Event whereDescription($value)
 * @method static Builder|Event whereDisplayName($value)
 * @method static Builder|Event whereEnable($value)
 * @method static Builder|Event whereEndTime($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereName($value)
 * @method static Builder|Event whereStartTime($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Event withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                            $cache_cooldown_seconds
 * @method static Builder|Event name($value)
 * @property-read int|null                                                         $eventresults_count
 * @property-read int|null                                                         $surveys_count
 * @property-read int|null                                                         $usersurveyanswers_count
 */
class Event extends BaseModel
{
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

    public function scopeName($query, $value)
    {
        return $query->where('name', $value);
    }
}
