<?php

namespace App;

use App\Traits\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    use Helper;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'enable',
        'description',
        'code',
        'discount',
        'maxCost',
        'usageLimit',
        'usageNumber',
        'validSince',
        'validUntil',
        'coupontype_id',
        'discounttype_id'
    ];

    public function marketers()
    {
        return $this->belongsToMany('App\User');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    public function coupontype()
    {
        return $this->belongsTo('App\Coupontype');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function discounttype()
    {
        return $this->belongsTo("\App\Discounttype");
    }

    /**
     * Validates a coupon
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCoupon()
    {
        if (!$this->enable)
            return "کپن وارد شده غیر فعال می باشد";
        elseif (isset($this->usageLimit) && $this->usageNumber >= $this->usageLimit)
            return "تعداد مجاز استفاده از کپن به پایان رسیده است";
        elseif (isset($this->validSince) && Carbon::now() < $this->validSince)
            return "تاریخ استفاده از کپن آغاز نشده است";
        elseif (isset($this->validUntil) && Carbon::now() > $this->validUntil)
            return "تاریخ استفاده از کپن به پایان رسیده است";
        else return "";
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->updated_at, "toJalali");
    }

    /**
     * @return string
     * Converting validSince field to jalali
     */
    public function ValidSince_Jalali()
    {
        $explodedDateTime = explode(" ", $this->validSince);
        $explodedTime = $explodedDateTime[1];
        $explodedDate = $this->convertDate($this->validSince, "toJalali");
        return ($explodedDate . " " . $explodedTime);
    }

    /**
     * @return string
     * Converting validUntil field to jalali
     */
    public function ValidUntil_Jalali()
    {
        $explodedDateTime = explode(" ", $this->validUntil);
        $explodedTime = $explodedDateTime[1];
        $explodedDate = $this->convertDate($this->validUntil, "toJalali");
        return ($explodedDate . " " . $explodedTime);
    }
}
