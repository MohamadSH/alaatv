<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Useruploadstatus
 *
 * @property int                                                        $id
 * @property string|null                                                $name        نام این وضعیت
 * @property string|null                                                $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                $description توضیحات این وضعیت
 * @property int                                                        $order       ترتیب وضعیت
 * @property Carbon|null                                        $created_at
 * @property Carbon|null                                        $updated_at
 * @property Carbon|null                                        $deleted_at
 * @property-read Collection|Userupload[] $useruploads
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Useruploadstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Useruploadstatus whereCreatedAt($value)
 * @method static Builder|Useruploadstatus whereDeletedAt($value)
 * @method static Builder|Useruploadstatus whereDescription($value)
 * @method static Builder|Useruploadstatus whereDisplayName($value)
 * @method static Builder|Useruploadstatus whereId($value)
 * @method static Builder|Useruploadstatus whereName($value)
 * @method static Builder|Useruploadstatus whereOrder($value)
 * @method static Builder|Useruploadstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Useruploadstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Useruploadstatus withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Useruploadstatus newModelQuery()
 * @method static Builder|Useruploadstatus newQuery()
 * @method static Builder|Useruploadstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                      $cache_cooldown_seconds
 * @property-read int|null                                                   $useruploads_count
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
