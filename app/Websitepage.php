<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Websitepage extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'url',
        'displayName',
        'description',
    ];

    public function userschecked()
    {//Users that have seen this site page
        return $this->belongsToMany('\App\User', 'userseensitepages', 'websitepage_id', 'user_id');
    }

}
