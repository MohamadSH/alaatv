<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Useruploadstatus extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description' ,
        'displayName',
        'order',
    ];

    public function useruploads(){
        return $this->hasMany('App\Useruploads');
    }
}
