<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Usersurveyanswer
 *
 * @property int                 $id
 * @property int                 $user_id     آی دی مشخص کننده کاربر پاسخ دهنده
 * @property int                 $question_id آی دی مشخص کننده پرسش مربرط به پاسخ
 * @property int                 $survey_id   آی دی مشخص کننده مصاحبه مربوط به پاسخ
 * @property int                 $event_id    آی دی مشخص کننده رخداد مربرط به پاسخ
 * @property string|null         $answer      پاسخ کاربر
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Event     $event
 * @property-read \App\Question  $question
 * @property-read \App\Survey    $survey
 * @property-read \App\User      $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Usersurveyanswer onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Usersurveyanswer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Usersurveyanswer withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Usersurveyanswer query()
 */
class Usersurveyanswer extends Model
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
