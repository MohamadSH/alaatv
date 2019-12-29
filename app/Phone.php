<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Phone
 *
 * @property int                 $id
 * @property int|null            $contact_id   آی دی مشخص کننده رکورد دفترچه تلفن صاحب شماره
 * @property int|null            $phonetype_id آی دی مشخص کننده نوع شماره
 * @property string|null         $phoneNumber  شماره تلفن
 * @property int                 $priority     اولویت شماره ها در میان نوع خود مثلا یک شماره موبایل در بین
 *           موبایلهای صاحب شماره ، 0 به معنی بالاترین اولویت
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Contact|null   $contact
 * @property-read Phonetype|null $phonetype
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Phone onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Phone whereContactId($value)
 * @method static Builder|Phone whereCreatedAt($value)
 * @method static Builder|Phone whereDeletedAt($value)
 * @method static Builder|Phone whereId($value)
 * @method static Builder|Phone wherePhoneNumber($value)
 * @method static Builder|Phone wherePhonetypeId($value)
 * @method static Builder|Phone wherePriority($value)
 * @method static Builder|Phone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Phone withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Phone withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Phone newModelQuery()
 * @method static Builder|Phone newQuery()
 * @method static Builder|Phone query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed               $cache_cooldown_seconds
 */
class Phone extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'phoneNumber',
        'priority',
        'contact_id',
        'phonetype_id',
    ];

    public function contact()
    {
        return $this->belongsTo('\App\Contact');
    }

    public function phonetype()
    {
        return $this->belongsTo('\App\Phonetype');
    }
}
