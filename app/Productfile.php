<?php

namespace App;

use Carbon\Carbon;

/**
 * App\Productfile
 *
 * @property int                            $id
 * @property int                            $product_id         آی دی مشخص کننده محصول این فایل
 * @property int|null                       $productfiletype_id توضیج درباره نوع رشته
 * @property string|null                    $file               اسم فایل
 * @property string|null                    $cloudFile          فایل آپلود شده در سرور خارجی
 * @property string|null                    $name               عنوان فایل
 * @property string|null                    $description        توضیح درباره فایل
 * @property int                            $order              ترتیب فایل
 * @property int                            $enable             فعال بودن یا غیرفعال بودن فایل
 * @property string|null                    $validSince         تاریخ شروع استفاده از فایل
 * @property \Carbon\Carbon|null            $created_at
 * @property \Carbon\Carbon|null            $updated_at
 * @property \Carbon\Carbon|null            $deleted_at
 * @property-read \App\Product              $product
 * @property-read \App\Productfiletype|null $productfiletype
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Productfile onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereCloudFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereProductfiletypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile whereValidSince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productfile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Productfile withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile enable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile valid()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 */
class Productfile extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'productfiletype_id',
        'file',
        'name',
        'description',
        'order',
        'enable',
        'validSince',
        'cloudFile',
    ];

    public function product()
    {
        return $this->belongsTo('\App\Product');
    }

    public function productfiletype()
    {
        return $this->belongsTo('\App\Productfiletype');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function validSince_Jalali()
    {
        $explodedDateTime = explode(" ", $this->validSince);
        $explodedTime = $explodedDateTime[1];
        return $this->convertDate($this->validSince, "toJalali") . " " . $explodedTime;
    }

    /**
     * Scope a query to only include enable(or disable) Products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }

    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->where('validSince', '<', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                                               ->timezone('Asia/Tehran'))
              ->orwhereNull('validSince');
        });
    }
}
