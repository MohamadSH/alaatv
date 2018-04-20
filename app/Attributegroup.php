<?php

namespace App;

use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attributegroup extends Model
{
    use SoftDeletes;
    use Helper;
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

    protected $fillable = [
        'name',
        'description',
        'attributeset_id'
    ];

    public function attributes()
    {
        return $this->belongsToMany('App\Attribute')
            ->withPivot('order', 'description')
            ->withTimestamps()
            ->orderBy('order');
    }

    public function attributeset()
    {
        return $this->belongsTo('App\Attributeset');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
        return $this->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->updated_at);
        return $this->convertDate($this->updated_at, "toJalali");
    }
}
