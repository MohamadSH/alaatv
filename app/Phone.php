<?php

namespace App;

use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Phone
 *
 * @property int $id
 * @property int|null $contact_id آی دی مشخص کننده رکورد دفترچه تلفن صاحب شماره
 * @property int|null $phonetype_id آی دی مشخص کننده نوع شماره
 * @property string|null $phoneNumber شماره تلفن
 * @property int $priority اولویت شماره ها در میان نوع خود مثلا یک شماره موبایل در بین موبایلهای صاحب شماره ، 0 به معنی بالاترین اولویت
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Contact|null $contact
 * @property-read \App\Phonetype|null $phonetype
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Phone onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone wherePhonetypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Phone withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Phone withoutTrashed()
 * @mixin \Eloquent
 */
class Phone extends Model
{
    use SoftDeletes;
    use Helper;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'phoneNumber',
        'priority',
        'contact_id',
        'phonetype_id'
    ];

    public function contact()
    {
        return $this->belongsTo('\App\Contact');
    }

    public function phonetype()
    {
        return $this->belongsTo('\App\Phonetype');
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
}
