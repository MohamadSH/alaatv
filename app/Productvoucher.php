<?php

namespace App;

/**
 * App\Productvoucher
 *
 * @property int $id
 * @property int|null $product_id         آی دی محصول صاحب وچر
 * @property int|null $user_id            آی دی مشخص کننده کاربر که کد به اون تخصیص داده شده است
 * @property string|null $code               پین کد وچر
 * @property string|null $expirationdatetime زمان انقضای این پین کد
 * @property int $enable             فعال یا غیرفعال بودن پین
 * @property string|null $description        توضیح این پین کد
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Product $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Productvoucher onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereExpirationdatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productvoucher withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Productvoucher withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productvoucher query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed $cache_cooldown_seconds
 */
class Productvoucher extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'code',
        'expirationdatetime',
        'enable',
        'description',
    ];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
