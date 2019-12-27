<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
 * @property string|null                    $validSince       زمان شروع استفاده از
 *           کپن ، نال به معنای شروع از زمان ایجاد است
 * @property string|null                    $validUntil       زمان پایان استفاده از
 *           کپن ، نال به معنای بدون محدودیت می باشد
 * @property int|null                       $orderproduct_id  آی دی مشخص کننده آیتمی
 *           که به واسطه آن این بن به کاربر اختصاص داده شده
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property string|null                    $deleted_at
 * @property-read Bon                       $bon
 * @property-read Orderproduct|null         $orderproduct
 * @property-read Collection|Orderproduct[] $orderproducts
 * @property-read User                      $user
 * @property-read Userbonstatus|null        $userbonstatus
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Userbon onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Userbon whereBonId($value)
 * @method static Builder|Userbon whereCreatedAt($value)
 * @method static Builder|Userbon whereDeletedAt($value)
 * @method static Builder|Userbon whereId($value)
 * @method static Builder|Userbon whereOrderproductId($value)
 * @method static Builder|Userbon whereTotalNumber($value)
 * @method static Builder|Userbon whereUpdatedAt($value)
 * @method static Builder|Userbon whereUsedNumber($value)
 * @method static Builder|Userbon whereUserId($value)
 * @method static Builder|Userbon whereUserbonstatusId($value)
 * @method static Builder|Userbon whereValidSince($value)
 * @method static Builder|Userbon whereValidUntil($value)
 * @method static \Illuminate\Database\Query\Builder|Userbon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Userbon withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Userbon newModelQuery()
 * @method static Builder|Userbon newQuery()
 * @method static Builder|Userbon query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                        $cache_cooldown_seconds
 * @property-read int|null                                                     $orderproducts_count
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
