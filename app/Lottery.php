<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Lottery
 *
 * @property int                                                  $id
 * @property string|null                                          $name            نام قرعه کشی
 * @property string|null                                          $displayName     نام قابل نمایش قرعه کشی
 * @property string|null                                          $holdingDate     تاریخ برگزاری
 * @property int                                                  $essentialPoints تعداد امتیاز لازم برای شرکت در
 *           قرعه کشی
 * @property string|null                                          $prizes          جوایز قرعه کشی
 * @property Carbon|null                                  $created_at
 * @property Carbon|null                                  $updated_at
 * @property Carbon|null                                  $deleted_at
 * @property-read Collection|User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Lottery onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Lottery whereCreatedAt($value)
 * @method static Builder|Lottery whereDeletedAt($value)
 * @method static Builder|Lottery whereDisplayName($value)
 * @method static Builder|Lottery whereEssentialPoints($value)
 * @method static Builder|Lottery whereHoldingDate($value)
 * @method static Builder|Lottery whereId($value)
 * @method static Builder|Lottery whereName($value)
 * @method static Builder|Lottery wherePrizes($value)
 * @method static Builder|Lottery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Lottery withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Lottery withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Lottery newModelQuery()
 * @method static Builder|Lottery newQuery()
 * @method static Builder|Lottery query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null                                             $users_count
 */
class Lottery extends BaseModel
{
    protected $fillable = [
        'name',
        'displayName',
        'holdingDate',
        'essentialPoints',
        'prizes',
    ];

    public function users()
    {
        return $this->belongsToMany("\App\User")
            ->withPivot("rank", "prizes");
    }

    public function prizes($rank)
    {
        $prizeName = "";
        $amount    = 0;
        $memorial  = "";
        if ($this->id == 7) {
            if ($rank == 1) {//nafare aval
                $prizeName = "یک دستگاه موبایل سامسونگ A50";
            }
            //            else
            //            {
            //                $memorial = "کد تخفیف ayft با 70 درصد تخفیف";
            //            }

            //            elseif($rank > 13 && $rank <= 123 )
            //            {
            //                $amount = 60000 ;
            //                $prizeName = "مبلغ ".number_format($amount). " تومان اعتبار هدیه";
            //            }
        }

        return [
            $prizeName,
            $amount,
            $memorial,
        ];
    }
}
