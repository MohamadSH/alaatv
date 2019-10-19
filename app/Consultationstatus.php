<?php

namespace App;

/**
 * App\Consultationstatus
 *
 * @property int                                                               $id
 * @property string|null                                                       $name        نام وضعیت
 * @property string|null                                                       $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                       $description توضیح درباره وضعیت
 * @property int                                                               $order       ترتیب نمایش وضعیت - در صورت
 *           نیاز به استفاده
 * @property \Carbon\Carbon|null                                               $created_at
 * @property \Carbon\Carbon|null                                               $updated_at
 * @property \Carbon\Carbon|null                                               $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Consultation[] $consultations
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Consultationstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Consultationstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Consultationstatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                        $cache_cooldown_seconds
 * @property-read int|null $consultations_count
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
