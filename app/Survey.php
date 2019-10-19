<?php

namespace App;

/**
 * App\Survey
 *
 * @property int                                                                   $id
 * @property string|null                                                           $name        نام مصاحبه
 * @property string|null                                                           $description توضیح درباره مصاحبه
 * @property \Carbon\Carbon|null                                                   $created_at
 * @property \Carbon\Carbon|null                                                   $updated_at
 * @property \Carbon\Carbon|null                                                   $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Event[]            $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[]         $questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Usersurveyanswer[] $usersurveyanswer
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Survey onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Survey withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Survey withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                            $cache_cooldown_seconds
 * @property-read int|null $events_count
 * @property-read int|null $questions_count
 * @property-read int|null $usersurveyanswer_count
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
            ->withPivot("order", "enable", "description");;
    }
    
    public function events()
    {
        return $this->belongsToMany('\App\Event')
            ->withPivot("order", "enable", "description");;
    }
    
    public function usersurveyanswer()
    {
        return $this->hasMany('\App\Usersurveyanswer');
    }
}
