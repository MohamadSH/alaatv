<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Contact
 *
 * @property int                                                        $id
 * @property int|null                $user_id        آی دی مشخص کننده کاربر صاحب این
 *           رکورد دفترچه تلفن
 * @property int|null                $contacttype_id آی دی مشخص کننده نوع این رکورد
 *           دفترچه تلفن
 * @property int|null                $relative_id    آی دی مشخص کننده نسبت صاحب
 *           اطالاعات تماس با کاربر
 * @property string|null             $name           نام صاحب اطالاعات تماس
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 * @property Carbon|null     $deleted_at
 * @property-read Contacttype|null   $contacttype
 * @property-read Collection|Phone[] $phones
 * @property-read Relative|null      $relative
 * @property-read User|null          $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Contact onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Contact whereContacttypeId($value)
 * @method static Builder|Contact whereCreatedAt($value)
 * @method static Builder|Contact whereDeletedAt($value)
 * @method static Builder|Contact whereId($value)
 * @method static Builder|Contact whereName($value)
 * @method static Builder|Contact whereRelativeId($value)
 * @method static Builder|Contact whereUpdatedAt($value)
 * @method static Builder|Contact whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Contact withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contact withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Contact newModelQuery()
 * @method static Builder|Contact newQuery()
 * @method static Builder|Contact query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null                                              $phones_count
 */
class Contact extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'contacttype_id',
        'relative_id',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function relative()
    {
        return $this->belongsTo('\App\Relative');
    }

    public function contacttype()
    {
        return $this->belongsTo('\App\Contacttype');
    }

    public function phones()
    {
        return $this->hasMany('\App\Phone');
    }
}
