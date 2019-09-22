<?php

namespace App;

/**
 * App\Userbonstatus
 *
 * @property int                                                          $id
 * @property string|null                                                  $name        نام وضعیت
 * @property string|null                                                  $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                  $description توضیح درباره وضعیت
 * @property int                                                          $order       ترتیب نمایش وضعیت - در صورت نیاز
 *           به استفاده
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property string|null                                                  $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Userbon[] $userbons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Userbonstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Userbonstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Userbonstatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null $userbons_count
 */
class Userbonstatus extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];
    
    public function userbons()
    {
        return $this->hasMany('App\Userbon');
    }
}
