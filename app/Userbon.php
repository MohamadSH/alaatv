<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

/**
 * App\Userbon
 *
 * @property int                                                               $id
 * @property int                                                               $bon_id           آی دی مشخص کننده بن
 *           تخصیص داده شده
 * @property int                                                               $user_id          آی دی مشخص کننده
 *           کاربری که بن به او تخصیص داده شده
 * @property int                                                               $totalNumber      تعداد بن اختصاص داده
 *           شده به کاربر
 * @property int                                                               $usedNumber       تعداد بنی که کاربر
 *           استفاده کرده
 * @property int|null                                                          $userbonstatus_id آی دی مشخص کننده وضعیت
 *           این بن کاربر
 * @property string|null                                                       $validSince       زمان شروع استفاده از
 *           کپن ، نال به معنای شروع از زمان ایجاد است
 * @property string|null                                                       $validUntil       زمان پایان استفاده از
 *           کپن ، نال به معنای بدون محدودیت می باشد
 * @property int|null                                                          $orderproduct_id  آی دی مشخص کننده آیتمی
 *           که به واسطه آن این بن به کاربر اختصاص داده شده
 * @property \Carbon\Carbon|null                                               $created_at
 * @property \Carbon\Carbon|null                                               $updated_at
 * @property string|null                                                       $deleted_at
 * @property-read \App\Bon                                                     $bon
 * @property-read \App\Orderproduct|null                                       $orderproduct
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[] $orderproducts
 * @property-read \App\User                                                    $user
 * @property-read \App\Userbonstatus|null                                      $userbonstatus
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Userbon onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereBonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereOrderproductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereTotalNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereUsedNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereUserbonstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereValidSince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon whereValidUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Userbon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Userbon withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                        $cache_cooldown_seconds
 * @property-read int|null $orderproducts_count
 */
class Userbon extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'bon_id',
        'user_id',
        'totalNumber',
        'usedNumber',
        'validSince',
        'validUntil',
        'orderproduct_id',
        'userbonstatus_id',
    ];

    public function userbonstatus()
    {
        return $this->belongsTo('App\Userbonstatus');
    }

    public function bon()
    {
        return $this->belongsTo(Bon::Class);
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function orderproducts()
    {
        return $this->belongsToMany(Orderproduct::Class);
    }

    public function orderproduct()
    {
        return $this->belongsTo(Orderproduct::Class);
    }

    public function void()
    {
        $remainBonNumber        = $this->totalNumber - $this->usedNumber;
        $this->usedNumber       = $this->totalNumber;
        $this->userbonstatus_id = config("constants.USERBON_STATUS_USED");
        $this->update();

        return $remainBonNumber;
    }
}
