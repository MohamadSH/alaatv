<?php

namespace App;

use App\Traits\DateTrait;
use App\Traits\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Userbon
 *
 * @property int $id
 * @property int $bon_id آی دی مشخص کننده بن تخصیص داده شده
 * @property int $user_id آی دی مشخص کننده کاربری که بن به او تخصیص داده شده
 * @property int $totalNumber تعداد بن اختصاص داده شده به کاربر
 * @property int $usedNumber تعداد بنی که کاربر استفاده کرده
 * @property int|null $userbonstatus_id آی دی مشخص کننده وضعیت این بن کاربر
 * @property string|null $validSince زمان شروع استفاده از کپن ، نال به معنای شروع از زمان ایجاد است
 * @property string|null $validUntil زمان پایان استفاده از کپن ، نال به معنای بدون محدودیت می باشد
 * @property int|null $orderproduct_id آی دی مشخص کننده آیتمی که به واسطه آن این بن به کاربر اختصاص داده شده
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Bon $bon
 * @property-read \App\Orderproduct|null $orderproduct
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[] $orderproducts
 * @property-read \App\User $user
 * @property-read \App\Userbonstatus|null $userbonstatus
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
 */
class Userbon extends Model
{
    use SoftDeletes;
    use Helper;
    use DateTrait;
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
        'userbonstatus_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function userbonstatus()
    {
        return $this->belongsTo('App\Userbonstatus');
    }

    public function bon()
    {
        return $this->belongsTo('\App\Bon');
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function orderproducts()
    {
        return $this->belongsToMany('\App\Orderproduct');
    }

    public function orderproduct()
    {
        return $this->belongsTo('\App\Orderproduct');
    }

    /**
     * Validates a bon
     *
     * @return \Illuminate\Http\Response
     */
    public function validateBon()
    {
        if ($this->totalNumber <= $this->usedNumber)
            return 0;
        elseif (isset($this->validSince) && Carbon::now() < $this->validSince)
            return 0;
        elseif (isset($this->validUntil) && Carbon::now() > $this->validUntil)
            return 0;
        else return $this->totalNumber - $this->usedNumber;
    }
}
