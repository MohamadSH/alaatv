<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Consultation
 *
 * @property int                                                        $id
 * @property string|null                                                $name                  نام مشاوره
 * @property string|null                                                $description           توضیح درباره مشاوره
 * @property string|null                                                $videoPageLink         لینک صفحه تماشای فیلم
 *           مشاوره
 * @property string|null                                                $textScriptLink        لینک صفحه حاوی متن
 *           مشاوره
 * @property int                     $order                 ترتیب مشاوره - در صورت
 *           نیاز به استفاده
 * @property int                     $enable                فعال بودن یا نبودن
 *           مشاوره
 * @property int                     $consultationstatus_id آیدی مشخص کننده وضعیت
 *           مشاوره
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 * @property Carbon|null     $deleted_at
 * @property string|null             $thumbnail             عکس مشاوره
 * @property-read Consultationstatus $consultationstatus
 * @property-read Collection|Major[] $majors
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Consultation onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Consultation whereConsultationstatusId($value)
 * @method static Builder|Consultation whereCreatedAt($value)
 * @method static Builder|Consultation whereDeletedAt($value)
 * @method static Builder|Consultation whereDescription($value)
 * @method static Builder|Consultation whereEnable($value)
 * @method static Builder|Consultation whereId($value)
 * @method static Builder|Consultation whereName($value)
 * @method static Builder|Consultation whereOrder($value)
 * @method static Builder|Consultation whereTextScriptLink($value)
 * @method static Builder|Consultation whereThumbnail($value)
 * @method static Builder|Consultation whereUpdatedAt($value)
 * @method static Builder|Consultation whereVideoPageLink($value)
 * @method static \Illuminate\Database\Query\Builder|Consultation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Consultation withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Consultation newModelQuery()
 * @method static Builder|Consultation newQuery()
 * @method static Builder|Consultation query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null                                              $majors_count
 */
class Consultation extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'videoPageLink',
        'textScriptLink',
        'order',
        'enable',
        'consultationstatus_id',
    ];

    public function consultationstatus()
    {
        return $this->belongsTo('App\Consultationstatus');
    }

    public function majors()
    {
        return $this->belongsToMany('App\Major')
            ->withTimestamps();
    }
}
