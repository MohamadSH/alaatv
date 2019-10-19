<?php

namespace App;

/**
 * App\Assignmentstatus
 *
 * @property int                                                             $id
 * @property string|null                                                     $name        نام وضعیت
 * @property string|null                                                     $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                     $description توضیح درباره وضعیت
 * @property int                                                             $order       ترتیب نمایش وضعیت - در صورت
 *           نیاز به استفاده
 * @property \Carbon\Carbon|null                                             $created_at
 * @property \Carbon\Carbon|null                                             $updated_at
 * @property \Carbon\Carbon|null                                             $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Assignment[] $assignments
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignmentstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Assignmentstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignmentstatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignmentstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                      $cache_cooldown_seconds
 * @property-read int|null $assignments_count
 */
class Assignmentstatus extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];
    
    public function assignments()
    {
        return $this->hasMany('App\Assignment');
    }
}
