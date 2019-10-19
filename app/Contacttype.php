<?php

namespace App;

/**
 * App\Contacttype
 *
 * @property int                                                          $id
 * @property string|null                                                  $displayName نام قابل نمایش نوع
 * @property string|null                                                  $name        نام این نوع در سیستم
 * @property string|null                                                  $description توضیحات این نوع
 * @property int                                                          $isEnable    نوع دفترچه تلفن فعال است یا خیر
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[] $contacts
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Contacttype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype whereIsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contacttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Contacttype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contacttype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null $contacts_count
 */
class Contacttype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'isEnable',
    ];
    
    public function contacts()
    {
        return $this->hasMany('\App\Contact');
    }
}
