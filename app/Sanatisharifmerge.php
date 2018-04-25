<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sanatisharifmerge extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'videoid',
        'videoTransferred',
        'videoname',
        'videodescrip',
        'videosession',
        'keywords',
        'videolink',
        'videolinkhq',
        'videolink240p',
        'videolinktakhtesefid',
        'videoEnable',
        'thumbnail',
        'pamphletid',
        'pamphletTransferred',
        'pamphletname',
        'pamphletaddress',
        'pamphletdescrip',
        'pamphletsession',
        'isexercise',
        'lessonid',
        'lessonTransferred',
        'lessonname',
        'lessonEnable',
        'depid',
        'departmentTransferred',
        'depname',
        'depyear',
        'departmentlessonid',
        'departmentlessonTransferred',
        'departmentlessonEnable',
        'teacherfirstname',
        'teacherlastname',
        'pageOldAddress',
        'pageNewAddress',
        'educationalcontent_id',
    ];
}
