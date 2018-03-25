<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'control_id',
        'dataSourceUrl',
        'querySourceUrl',
        'statement',
        'description',
    ];

    public function control()
    {
        return $this->belongsTo('\App\Attributecontrol');
    }

    public function surveys(){
        return $this->belongsToMany('\App\Survey')->withPivot("order" , "enable" , "description");;
    }

    public function usersurveyasnwer(){
        return $this->hasMany('\App\Usersurveyanswer');
    }
}
