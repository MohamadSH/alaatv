<?php

namespace App;

use App\Adapter\AlaaSftpAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Storage;

/**
 * App\Slideshow
 *
 * @property int         $id
 * @property int|null    $websitepage_id آی دی مشخص کننده صفحه محل نمایش اسلاید
 * @property string|null $title
 * @property string|null $shortDescription
 * @property string|null $photo
 * @property string|null $link
 * @property int         $order
 * @property int         $isEnable
 * @property \Carbon\Carbon|null        $created_at
 * @property \Carbon\Carbon|null        $updated_at
 * @property \Carbon\Carbon|null        $deleted_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Slideshow query()
 * @property-read mixed                 $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed  $cache_cooldown_seconds
 * @property int in_new_tab
 */
class Slideshow extends BaseModel
{
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
        'isEnable',
        'in_new_tab',
    ];

    protected $appends = [
        'url',
    ];

    protected $hidden = [
        'websitepage_id',
        'photo',
        'isEnable',
        'deleted_at',
        'created_at',
    ];

    public static function getMainBanner(): Collection
    {
        return Cache::tags([
            'banner',
            'page',
        ])
            ->remember('getMainBanner', config('constants.CACHE_600'), function () {
                return Websitepage::where('url', "/home")
                    ->first()
                    ->slides()
                    ->where("isEnable", 1)
                    ->orderBy("order")
                    ->get();
            });
    }

    public static function getShopBanner()
    {
        return Cache::tags([
            'banner',
            'page',
        ])
            ->remember('getShopBanner', config('constants.CACHE_600'), function () {
                return Websitepage::where('url', "/shop")
                    ->first()
                    ->slides()
                    ->where("isEnable", 1)
                    ->orderBy("order")
                    ->get();
            });
    }

    public function getUrlAttribute($value): string
    {
        /** @var AlaaSftpAdapter $diskAdapter */
        $diskAdapter = Storage::disk('alaaCdnSFTP')->getAdapter();
        $imageUrl =  $diskAdapter->getUrl($this->photo);
        return isset($imageUrl)?$imageUrl.'?w=1280&h=500' :'/acm/image/255x255.png';

//        return route('image', ['category' => 9, 'w' => '1280', 'h' => '500', 'filename' => $this->photo]);
    }

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

                return $this->convertDate($explodedDateTime[0], 1)." ".$explodedTime;
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

                return $this->convertDate($explodedDateTime[0], 1)." ".$explodedTime;
            }
        }

        return "نا مشخص";
    }
}
