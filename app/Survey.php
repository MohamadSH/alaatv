<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Survey
 *
 * @property int                                $id
 * @property string|null                        $name        نام مصاحبه
 * @property string|null                        $description توضیح درباره مصاحبه
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @property Carbon|null                $deleted_at
 * @property-read Collection|Event[]            $events
 * @property-read Collection|Question[]         $questions
 * @property-read Collection|Usersurveyanswer[] $usersurveyanswer
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Survey onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Survey whereCreatedAt($value)
 * @method static Builder|Survey whereDeletedAt($value)
 * @method static Builder|Survey whereDescription($value)
 * @method static Builder|Survey whereId($value)
 * @method static Builder|Survey whereName($value)
 * @method static Builder|Survey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Survey withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Survey withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Survey newModelQuery()
 * @method static Builder|Survey newQuery()
 * @method static Builder|Survey query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                            $cache_cooldown_seconds
 * @property-read int|null                                                         $events_count
 * @property-read int|null                                                         $questions_count
 * @property-read int|null                                                         $usersurveyanswer_count
 */
class Survey extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function questions()
    {
        return $this->belongsToMany('\App\Question')
            ->withPivot("order", "enable", "description");
    }

    public function events()
    {
        return $this->belongsToMany('\App\Event')
            ->withPivot("order", "enable", "description");
    }

    public function usersurveyanswer()
    {
        return $this->hasMany('\App\Usersurveyanswer');
    }
}
