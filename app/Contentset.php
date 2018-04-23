<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contentset extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'tags'
    ];


    public function educationalcontents(){
        return $this->belongsToMany("\App\Educationalcontent" , "contentset_educationalcontent","contentset_id","edc_id")->withPivot("order" , "isDefault");
    }
}
