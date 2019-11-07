<?php

namespace App;

use App\Adapter\AlaaSftpAdapter;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Storage;

/**
 * App\Slideshow
 *
 * @property int                   $id
 * @property int|null              $websitepage_id آی دی مشخص کننده صفحه محل نمایش اسلاید
 * @property string|null           $title
 * @property string|null           $shortDescription
 * @property string|null           $photo
 * @property string|null           $link
 * @property int                   $order
 * @property int                   $isEnable
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property Carbon|null   $deleted_at
 * @property-read Websitepage|null $websitepage
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Slideshow onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Slideshow whereCreatedAt($value)
 * @method static Builder|Slideshow whereDeletedAt($value)
 * @method static Builder|Slideshow whereId($value)
 * @method static Builder|Slideshow whereIsEnable($value)
 * @method static Builder|Slideshow whereLink($value)
 * @method static Builder|Slideshow whereOrder($value)
 * @method static Builder|Slideshow wherePhoto($value)
 * @method static Builder|Slideshow whereShortDescription($value)
 * @method static Builder|Slideshow whereTitle($value)
 * @method static Builder|Slideshow whereUpdatedAt($value)
 * @method static Builder|Slideshow whereWebsitepageId($value)
 * @method static \Illuminate\Database\Query\Builder|Slideshow withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Slideshow withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Slideshow newModelQuery()
 * @method static Builder|Slideshow newQuery()
 * @method static Builder|Slideshow query()
 * @property-read mixed                 $url
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
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
            'home',
            'banner',
            'page',
        ])->remember('getMainBanner', config('constants.CACHE_600'), function () {

                $page = Websitepage::where('url', "/home")
                    ->first();

                return !isset($page) ? collect() : $page
                        ->slides()
                        ->where("isEnable", 1)
                        ->orderBy("order")
                        ->get() ?? collect();
            });
    }

    public static function getShopBanner()
    {
        return Cache::tags([
            'shop',
            'banner',
            'page',
        ])->remember('getShopBanner', config('constants.CACHE_600'), function () {

                $page = Websitepage::where('url', "/shop")
                    ->first();
                return !isset($page) ? collect() : $page
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
