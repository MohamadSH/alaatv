<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Productvoucher
 *
 * @property int                 $id
 * @property int|null            $product_id         آی دی محصول صاحب وچر
 * @property int|null            $user_id            آی دی مشخص کننده کاربر که کد به اون تخصیص داده شده است
 * @property string|null         $code               پین کد وچر
 * @property string|null         $expirationdatetime زمان انقضای این پین کد
 * @property int                 $enable             فعال یا غیرفعال بودن پین
 * @property string|null         $description        توضیح این پین کد
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Product        $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Productvoucher onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Productvoucher whereCode($value)
 * @method static Builder|Productvoucher whereCreatedAt($value)
 * @method static Builder|Productvoucher whereDeletedAt($value)
 * @method static Builder|Productvoucher whereDescription($value)
 * @method static Builder|Productvoucher whereEnable($value)
 * @method static Builder|Productvoucher whereExpirationdatetime($value)
 * @method static Builder|Productvoucher whereId($value)
 * @method static Builder|Productvoucher whereProductId($value)
 * @method static Builder|Productvoucher whereUpdatedAt($value)
 * @method static Builder|Productvoucher whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Productvoucher withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Productvoucher withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Productvoucher newModelQuery()
 * @method static Builder|Productvoucher newQuery()
 * @method static Builder|Productvoucher query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Productvoucher extends BaseModel
{
    const CONTRANCTOR_ASIATECH = 1;
    const CONTRANCTOR_HEKMAT = 2;

    /**
     * @var array
     */
    protected $fillable = [
        'contractor_id',
        'product_id',
        'products',
        'user_id',
        'used_at',
        'code',
        'expirationdatetime',
        'enable',
        'description',
    ];

    public function products()
    {
        return Product::whereIn('id', [294, 387, 379, 357]);
        return $this->belongsTo('App\Product');
    }

    public function isValid()
    {
        return $this->isEnable() && !$this->hasExpired();
    }

    public function isEnable()
    {
        return $this->enable;
    }

    public function hasBeenUsed()
    {
        return !is_null($this->user_id);
    }

    public function markVoucherAsUsed(int $userId, int $contractor_id)
    {
        return $this->update([
            'user_id'       => $userId,
            'used_at'       => Carbon::now('Asia/Tehran'),
            'contractor_id' => $contractor_id,
        ]);
    }

    private function hasExpired()
    {
        return $this->expirationdatetime < Carbon::now('Asia/Tehran');
    }
}
