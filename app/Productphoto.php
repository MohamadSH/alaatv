<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Storage;

/**
 * App\Productphoto
 *
 * @property int                 $id
 * @property int                 $product_id  آیدی مشخص کننده محصول عکس
 * @property string|null         $file        فایل عکس
 * @property string|null         $title       تایتل عکس
 * @property string              $description توضیح کوتاه یا تیتر دوم عکس
 * @property int                 $order       ترتیب عکس
 * @property int                 $enable      فعال/غیر فعال بودن عکس
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Product        $product
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Productphoto onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Productphoto whereCreatedAt($value)
 * @method static Builder|Productphoto whereDeletedAt($value)
 * @method static Builder|Productphoto whereDescription($value)
 * @method static Builder|Productphoto whereEnable($value)
 * @method static Builder|Productphoto whereFile($value)
 * @method static Builder|Productphoto whereId($value)
 * @method static Builder|Productphoto whereOrder($value)
 * @method static Builder|Productphoto whereProductId($value)
 * @method static Builder|Productphoto whereTitle($value)
 * @method static Builder|Productphoto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Productphoto withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Productphoto withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Productphoto enable()
 * @method static Builder|Productphoto newModelQuery()
 * @method static Builder|Productphoto newQuery()
 * @method static Builder|Productphoto query()
 * @property-read mixed          $url
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Productphoto extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'file',
        'product_id',
        'order',
    ];

    protected $hidden = [
        'id',
        'file',
        'order',
        'deleted_at',
        'created_at',
        'enable',
        'updated_at',
        'product_id',
    ];

    protected $appends = [
        'url',
    ];

    public function product()
    {
        return $this->belongsTo('\App\Product');
    }

    /**
     * Scope a query to only include enable(or disable) Products.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }

    public function getUrlAttribute($value): string
    {
        return $this->url('1400', '2000');
    }

    public function url($w, $h)
    {
        $diskAdapter = Storage::disk('alaaCdnSFTP')->getAdapter();
        $imageUrl    = $diskAdapter->getUrl($this->file);
        return isset($imageUrl) ? $imageUrl : '/acm/image/255x255.png';

//        return route('image', [
//            'category' => '4',
//            'w'        => $w,
//            'h'        => $h,
//            'filename' => $this->file,
//        ]);
    }
}
