<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Assignmentstatus
 *
 * @property int                                                        $id
 * @property string|null                                                $name        نام وضعیت
 * @property string|null                                                $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                $description توضیح درباره وضعیت
 * @property int                                                        $order       ترتیب نمایش وضعیت - در صورت
 *           نیاز به استفاده
 * @property Carbon|null                                        $created_at
 * @property Carbon|null                                        $updated_at
 * @property Carbon|null                                        $deleted_at
 * @property-read Collection|Assignment[] $assignments
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Assignmentstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Assignmentstatus whereCreatedAt($value)
 * @method static Builder|Assignmentstatus whereDeletedAt($value)
 * @method static Builder|Assignmentstatus whereDescription($value)
 * @method static Builder|Assignmentstatus whereDisplayName($value)
 * @method static Builder|Assignmentstatus whereId($value)
 * @method static Builder|Assignmentstatus whereName($value)
 * @method static Builder|Assignmentstatus whereOrder($value)
 * @method static Builder|Assignmentstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Assignmentstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Assignmentstatus withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Assignmentstatus newModelQuery()
 * @method static Builder|Assignmentstatus newQuery()
 * @method static Builder|Assignmentstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                      $cache_cooldown_seconds
 * @property-read int|null                                                   $assignments_count
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
