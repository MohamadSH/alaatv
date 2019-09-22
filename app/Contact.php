<?php

namespace App;

/**
 * App\Contact
 *
 * @property int                                                        $id
 * @property int|null                                                   $user_id        آی دی مشخص کننده کاربر صاحب این
 *           رکورد دفترچه تلفن
 * @property int|null                                                   $contacttype_id آی دی مشخص کننده نوع این رکورد
 *           دفترچه تلفن
 * @property int|null                                                   $relative_id    آی دی مشخص کننده نسبت صاحب
 *           اطالاعات تماس با کاربر
 * @property string|null                                                $name           نام صاحب اطالاعات تماس
 * @property \Carbon\Carbon|null                                        $created_at
 * @property \Carbon\Carbon|null                                        $updated_at
 * @property \Carbon\Carbon|null                                        $deleted_at
 * @property-read \App\Contacttype|null                                 $contacttype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Phone[] $phones
 * @property-read \App\Relative|null                                    $relative
 * @property-read \App\User|null                                        $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Contact onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereContacttypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereRelativeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Contact withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contact withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null $phones_count
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
