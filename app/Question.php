<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Question
 *
 * @property int                                                                   $id
 * @property int|null                                                              $control_id     آی دی مشخص کننده نوع
 *           کنترل این پرسش
 * @property string|null                        $dataSourceUrl  لینک منبع داده کنترل
 *           این پرسش
 * @property string|null                        $querySourceUrl لینک منبع کوئری برای
 *           این پرسش
 * @property string|null                        $statement      صورت پرسش
 * @property string|null                        $title          یک عنوان برای پرسش
 * @property string|null                        $description    توضیح درباره پرسش
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @property Carbon|null                $deleted_at
 * @property-read Attributecontrol|null         $control
 * @property-read Collection|Survey[]           $surveys
 * @property-read Collection|Usersurveyanswer[] $usersurveyasnwer
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Question onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Question whereControlId($value)
 * @method static Builder|Question whereCreatedAt($value)
 * @method static Builder|Question whereDataSourceUrl($value)
 * @method static Builder|Question whereDeletedAt($value)
 * @method static Builder|Question whereDescription($value)
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereQuerySourceUrl($value)
 * @method static Builder|Question whereStatement($value)
 * @method static Builder|Question whereTitle($value)
 * @method static Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Question withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                            $cache_cooldown_seconds
 * @property-read int|null                                                         $surveys_count
 * @property-read int|null                                                         $usersurveyasnwer_count
 */
class Question extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'control_id',
        'dataSourceUrl',
        'querySourceUrl',
        'statement',
        'description',
    ];

    public function control()
    {
        return $this->belongsTo('\App\Attributecontrol');
    }

    public function surveys()
    {
        return $this->belongsToMany('\App\Survey')
            ->withPivot("order", "enable", "description");
    }

    public function usersurveyasnwer()
    {
        return $this->hasMany('\App\Usersurveyanswer');
    }
}
