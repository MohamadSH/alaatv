<?php

namespace App;

/**
 * App\Lottery
 *
 * @property int                                                       $id
 * @property string|null                                               $name            نام قرعه کشی
 * @property string|null                                               $displayName     نام قابل نمایش قرعه کشی
 * @property string|null                                               $holdingDate     تاریخ برگزاری
 * @property int                                                       $essentialPoints تعداد امتیاز لازم برای شرکت در
 *           قرعه کشی
 * @property string|null                                               $prizes          جوایز قرعه کشی
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @property \Carbon\Carbon|null                                       $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Lottery onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery whereEssentialPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery whereHoldingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery wherePrizes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lottery withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Lottery withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lottery query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
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
