<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bon extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description' ,
        'order',
        'enable',
    ];

    public function products()
    {
        return $this->belongsToMany('\App\Product')->withPivot('discount' ,'bonPlus');
    }

    public function users()
    {
        return $this->belongsToMany('\App\User')->withPivot('number');
    }

    public function userbons(){
        return $this->hasMany('\App\Userbon');
    }

    public function bontype()
    {
        return $this->belongsTo("\App\BonType");
    }
}
