<?php

namespace App;

use Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attributegroup extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'attributeset_id'
    ];

    public function attributes(){
        return $this->belongsToMany('App\Attribute')->withPivot('order','attributetype_id' , 'description')->orderBy('order')->withTimestamps();
    }

    public function attributeset(){
        return $this->belongsTo('App\Attributeset');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->created_at);
        return $helper->convertDate($this->created_at , "toJalali" );
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->updated_at);
        return $helper->convertDate($this->updated_at , "toJalali" );
    }
}
