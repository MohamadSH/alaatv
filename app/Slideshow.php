<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Slideshow
 *
 * @property int $id
 * @property int|null $websitepage_id آی دی مشخص کننده صفحه محل نمایش اسلاید
 * @property string|null $title
 * @property string|null $shortDescription
 * @property string|null $photo
 * @property string|null $link
 * @property int $order
 * @property int $isEnable
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Websitepage|null $websitepage
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Slideshow onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereIsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow whereWebsitepageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Slideshow withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Slideshow withoutTrashed()
 * @mixin \Eloquent
 */
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
        if (isset($this->created_at)) {
            $explodedDateTime = explode(" ", $this->created_at);
            if (strcmp($explodedDateTime[0], "0000-00-00") != 0) {
                $explodedTime = $explodedDateTime[1];
                return $this->convertDate($explodedDateTime[0], 1) . " " . $explodedTime;
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
        if (isset($this->updated_at)) {
            $explodedDateTime = explode(" ", $this->updated_at);
            if (strcmp($explodedDateTime[0], "0000-00-00") != 0) {
                $explodedTime = $explodedDateTime[1];
                return $this->convertDate($explodedDateTime[0], 1) . " " . $explodedTime;
            }
        }
        return "نا مشخص";
    }
}
