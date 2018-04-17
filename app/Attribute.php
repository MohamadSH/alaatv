<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'attributecontrol_id',
        'attributetype_id',
    ];

    public function attributegroups()
    {
        return $this->belongsToMany('App\Attributegroup')->withTimestamps();
    }

    public function attributecontrol()
    {
        return $this->belongsTo('App\Attributecontrol');
    }

    public function attributetype()
    {
        return $this->belongsTo('App\Attributetype');
    }

    public function attributevalues()
    {
        return $this->hasMany('App\Attributevalue');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $helper = new Helper();
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $helper = new Helper();
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->updated_at, "toJalali");
    }
}
