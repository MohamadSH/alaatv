<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Usersurveyanswer
 *
 * @property int                 $id
 * @property int                 $user_id     آی دی مشخص کننده کاربر پاسخ دهنده
 * @property int                 $question_id آی دی مشخص کننده پرسش مربرط به پاسخ
 * @property int                 $survey_id   آی دی مشخص کننده مصاحبه مربوط به پاسخ
 * @property int                 $event_id    آی دی مشخص کننده رخداد مربرط به پاسخ
 * @property string|null         $answer      پاسخ کاربر
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Event          $event
 * @property-read Question       $question
 * @property-read Survey         $survey
 * @property-read User           $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Usersurveyanswer onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Usersurveyanswer whereAnswer($value)
 * @method static Builder|Usersurveyanswer whereCreatedAt($value)
 * @method static Builder|Usersurveyanswer whereDeletedAt($value)
 * @method static Builder|Usersurveyanswer whereEventId($value)
 * @method static Builder|Usersurveyanswer whereId($value)
 * @method static Builder|Usersurveyanswer whereQuestionId($value)
 * @method static Builder|Usersurveyanswer whereSurveyId($value)
 * @method static Builder|Usersurveyanswer whereUpdatedAt($value)
 * @method static Builder|Usersurveyanswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Usersurveyanswer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Usersurveyanswer withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Usersurveyanswer newModelQuery()
 * @method static Builder|Usersurveyanswer newQuery()
 * @method static Builder|Usersurveyanswer query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Usersurveyanswer extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'survey_id',
        'event_id',
        'answer',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function question()
    {
        return $this->belongsTo('\App\Question');
    }

    public function survey()
    {
        return $this->belongsTo('\App\Survey');
    }

    public function event()
    {
        return $this->belongsTo('\App\Event');
    }
}
