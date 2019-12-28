<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Consultationstatus
 *
 * @property int                                                          $id
 * @property string|null                                                  $name        نام وضعیت
 * @property string|null                                                  $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                  $description توضیح درباره وضعیت
 * @property int                                                          $order       ترتیب نمایش وضعیت - در صورت
 *           نیاز به استفاده
 * @property Carbon|null                                          $created_at
 * @property Carbon|null                                          $updated_at
 * @property Carbon|null                                          $deleted_at
 * @property-read Collection|Consultation[] $consultations
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Consultationstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Consultationstatus whereCreatedAt($value)
 * @method static Builder|Consultationstatus whereDeletedAt($value)
 * @method static Builder|Consultationstatus whereDescription($value)
 * @method static Builder|Consultationstatus whereDisplayName($value)
 * @method static Builder|Consultationstatus whereId($value)
 * @method static Builder|Consultationstatus whereName($value)
 * @method static Builder|Consultationstatus whereOrder($value)
 * @method static Builder|Consultationstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Consultationstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Consultationstatus withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Consultationstatus newModelQuery()
 * @method static Builder|Consultationstatus newQuery()
 * @method static Builder|Consultationstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                        $cache_cooldown_seconds
 * @property-read int|null                                                     $consultations_count
 */
class Consultationstatus extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public function consultations()
    {
        return $this->hasMany('App\Consultation');
    }
}
