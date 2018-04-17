<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slideshow extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'websitepage_id',
        'title',
        'shortDescription',
        'photo',
        'link',
        'order',
        'isEnable'
    ];

    public function websitepage()
    {
        return $this->belongsTo('\App\Websitepage');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function slideshowCreatedAtJalali()
    {
        $helper = new Helper();
        if (isset($this->created_at)) {
            $explodedDateTime = explode(" ", $this->created_at);
            if (strcmp($explodedDateTime[0], "0000-00-00") != 0) {
                $explodedTime = $explodedDateTime[1];
                return $helper->convertDate($explodedDateTime[0], 1) . " " . $explodedTime;
            }
        }
        return "نا مشخص";
    }


    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function slideshowUpdatedAtJalali()
    {
        $helper = new Helper();
        if (isset($this->updated_at)) {
            $explodedDateTime = explode(" ", $this->updated_at);
            if (strcmp($explodedDateTime[0], "0000-00-00") != 0) {
                $explodedTime = $explodedDateTime[1];
                return $helper->convertDate($explodedDateTime[0], 1) . " " . $explodedTime;
            }
        }
        return "نا مشخص";
    }
}
