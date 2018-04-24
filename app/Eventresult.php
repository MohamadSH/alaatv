<?php

namespace App;

use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eventresult extends Model
{
    use SoftDeletes;
    use Helper;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'rank',
        'participationCode',
        'participationCodeHash',
        'enableReportPublish',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function event()
    {
        return $this->belongsTo('\App\Event');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->created_at, "toJalali");
    }
}
