<?php

namespace App;

use App\Traits\DateTrait;
use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

/**
 * App\Mbtianswer
 *
 * @property int                 $id
 * @property int                 $user_id آی دی مشخص کننده کاربری که آزمون داده است
 * @property string|null         $answers آرایه ی مشخص کننده گزینه های انتخاب شده
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\User      $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Mbtianswer onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mbtianswer whereAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mbtianswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mbtianswer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mbtianswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mbtianswer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mbtianswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mbtianswer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Mbtianswer withoutTrashed()
 * @mixin \Eloquent
 */
class Mbtianswer extends Model
{
    use SoftDeletes;
    use Helper;
    use DateTrait;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
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
                                 ->whereIn("orderstatus_id", [Config::get("constants.ORDER_STATUS_CLOSED")])
                                 ->get();

        switch ($output) {
            case "productName":
                if ($ordooOrder->isEmpty())
                    return "";
                else return $ordooOrder->first()->orderproducts->first()->product->name;
                break;
            case "orderStatus":
                if ($ordooOrder->isEmpty())
                    return "";
                else return $ordooOrder->first()->orderstatus->displayName;
                break;
            default:
                break;
        }

    }
}
