<?php

namespace App;

/**
 * App\Useruploadstatus
 *
 * @property int                                                             $id
 * @property string|null                                                     $name        نام این وضعیت
 * @property string|null                                                     $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                     $description توضیحات این وضعیت
 * @property int                                                             $order       ترتیب وضعیت
 * @property \Carbon\Carbon|null                                             $created_at
 * @property \Carbon\Carbon|null                                             $updated_at
 * @property \Carbon\Carbon|null                                             $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Userupload[] $useruploads
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Useruploadstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Useruploadstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Useruploadstatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Useruploadstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                      $cache_cooldown_seconds
 * @property-read int|null $useruploads_count
 */
class Useruploadstatus extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'displayName',
        'order',
    ];
    
    public function useruploads()
    {
        return $this->hasMany('App\Userupload');
    }
}
