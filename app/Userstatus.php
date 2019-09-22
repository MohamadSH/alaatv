<?php

namespace App;

/**
 * App\Userstatus
 *
 * @property int                                                       $id
 * @property string|null                                               $name        نام وضعیت
 * @property string|null                                               $displayName نام قابل نمایش این وضعیت
 * @property string|null                                               $description توضیح درباره وضعیت
 * @property int                                                       $order       ترتیب نمایش وضعیت - در صورت نیاز به
 *           استفاده
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @property \Carbon\Carbon|null                                       $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Userstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Userstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Userstatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null $users_count
 */
class Userstatus extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];
    
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
