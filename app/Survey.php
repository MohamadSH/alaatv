<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function questions()
    {
        return $this->belongsToMany('\App\Question')->withPivot("order", "enable", "description");;
    }

    public function events()
    {
        return $this->belongsToMany('\App\Event')->withPivot("order", "enable", "description");;
    }

    public function usersurveyanswer()
    {
        return $this->hasMany('\App\Usersurveyanswer');
    }
}
