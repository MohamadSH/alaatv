<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'displayName',
        'description' ,
    ];

    public function educationalcontents(){
        return $this->belongsToMany('App\Educationalcontent');
    }
}
