<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Mbtianswer
 *
 * @property int                 $id
 * @property int                 $user_id آی دی مشخص کننده کاربری که آزمون داده است
 * @property string|null         $answers آرایه ی مشخص کننده گزینه های انتخاب شده
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User           $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Mbtianswer onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Mbtianswer whereAnswers($value)
 * @method static Builder|Mbtianswer whereCreatedAt($value)
 * @method static Builder|Mbtianswer whereDeletedAt($value)
 * @method static Builder|Mbtianswer whereId($value)
 * @method static Builder|Mbtianswer whereUpdatedAt($value)
 * @method static Builder|Mbtianswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Mbtianswer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Mbtianswer withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Mbtianswer newModelQuery()
 * @method static Builder|Mbtianswer newQuery()
 * @method static Builder|Mbtianswer query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Mbtianswer extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'answers',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function getUserOrderInfo($output)
    {
        $ordooOrder = $this->user->orders()
            ->whereHas('orderproducts', function ($q) {
                $q->whereIn("product_id", Product::whereHas('parents', function ($q) {
                    $q->whereIn("parent_id", [
                        1,
                        13,
                    ]);
                })
                    ->pluck("id"));
            })
            ->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED")])
            ->get();

        switch ($output) {
            case "productName":
                if ($ordooOrder->isEmpty()) {
                    return "";
                } else {
                    return $ordooOrder->first()->orderproducts->first()->product->name;
                }
                break;
            case "orderStatus":
                if ($ordooOrder->isEmpty()) {
                    return "";
                } else {
                    return $ordooOrder->first()->orderstatus->displayName;
                }
                break;
            default:
                break;
        }
    }
}
