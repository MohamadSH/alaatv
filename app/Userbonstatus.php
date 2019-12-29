<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Userbonstatus
 *
 * @property int                                                     $id
 * @property string|null                                             $name        نام وضعیت
 * @property string|null                                             $displayName نام قابل نمایش این وضعیت
 * @property string|null                                             $description توضیح درباره وضعیت
 * @property int                                                     $order       ترتیب نمایش وضعیت - در صورت نیاز
 *           به استفاده
 * @property Carbon|null                                     $created_at
 * @property Carbon|null                                     $updated_at
 * @property string|null                                             $deleted_at
 * @property-read Collection|Userbon[] $userbons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Userbonstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Userbonstatus whereCreatedAt($value)
 * @method static Builder|Userbonstatus whereDeletedAt($value)
 * @method static Builder|Userbonstatus whereDescription($value)
 * @method static Builder|Userbonstatus whereDisplayName($value)
 * @method static Builder|Userbonstatus whereId($value)
 * @method static Builder|Userbonstatus whereName($value)
 * @method static Builder|Userbonstatus whereOrder($value)
 * @method static Builder|Userbonstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Userbonstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Userbonstatus withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Userbonstatus newModelQuery()
 * @method static Builder|Userbonstatus newQuery()
 * @method static Builder|Userbonstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null                                                $userbons_count
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
