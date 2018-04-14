<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usersurveyanswer extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
