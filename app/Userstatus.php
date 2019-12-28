<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Userstatus
 *
 * @property int                                                  $id
 * @property string|null                                          $name        نام وضعیت
 * @property string|null                                          $displayName نام قابل نمایش این وضعیت
 * @property string|null                                          $description توضیح درباره وضعیت
 * @property int                                                  $order       ترتیب نمایش وضعیت - در صورت نیاز به
 *           استفاده
 * @property Carbon|null                                  $created_at
 * @property Carbon|null                                  $updated_at
 * @property Carbon|null                                  $deleted_at
 * @property-read Collection|User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Userstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Userstatus whereCreatedAt($value)
 * @method static Builder|Userstatus whereDeletedAt($value)
 * @method static Builder|Userstatus whereDescription($value)
 * @method static Builder|Userstatus whereDisplayName($value)
 * @method static Builder|Userstatus whereId($value)
 * @method static Builder|Userstatus whereName($value)
 * @method static Builder|Userstatus whereOrder($value)
 * @method static Builder|Userstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Userstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Userstatus withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Userstatus newModelQuery()
 * @method static Builder|Userstatus newQuery()
 * @method static Builder|Userstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null                                             $users_count
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
