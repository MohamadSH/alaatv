<?php

namespace App;

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
 * @property int                                                        $order                 ترتیب مشاوره - در صورت
 *           نیاز به استفاده
 * @property int                                                        $enable                فعال بودن یا نبودن
 *           مشاوره
 * @property int                                                        $consultationstatus_id آیدی مشخص کننده وضعیت
 *           مشاوره
 * @property \Carbon\Carbon|null                                        $created_at
 * @property \Carbon\Carbon|null                                        $updated_at
 * @property \Carbon\Carbon|null                                        $deleted_at
 * @property string|null                                                $thumbnail             عکس مشاوره
 * @property-read \App\Consultationstatus                               $consultationstatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Major[] $majors
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Consultation onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereConsultationstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereTextScriptLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereVideoPageLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Consultation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Consultation withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null $majors_count
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
