<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contentset extends Model
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
        'tags'
    ];


    public function educationalcontents()
    {
        return $this->belongsToMany(
            "\App\Educationalcontent",
            "contentset_educationalcontent",
            "contentset_id",
            "edc_id")
            ->withPivot("order", "isDefault");
    }
    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

//    public function setTagsAttribute($value)
//    {
//        return json_encode($value);
//    }
}
