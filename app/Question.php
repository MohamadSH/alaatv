<?php

namespace App;

/**
 * App\Question
 *
 * @property int                                                                   $id
 * @property int|null                                                              $control_id     آی دی مشخص کننده نوع
 *           کنترل این پرسش
 * @property string|null                                                           $dataSourceUrl  لینک منبع داده کنترل
 *           این پرسش
 * @property string|null                                                           $querySourceUrl لینک منبع کوئری برای
 *           این پرسش
 * @property string|null                                                           $statement      صورت پرسش
 * @property string|null                                                           $title          یک عنوان برای پرسش
 * @property string|null                                                           $description    توضیح درباره پرسش
 * @property \Carbon\Carbon|null                                                   $created_at
 * @property \Carbon\Carbon|null                                                   $updated_at
 * @property \Carbon\Carbon|null                                                   $deleted_at
 * @property-read \App\Attributecontrol|null                                       $control
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Survey[]           $surveys
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Usersurveyanswer[] $usersurveyasnwer
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Question onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDataSourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereQuerySourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereStatement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Question withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                            $cache_cooldown_seconds
 * @property-read int|null $surveys_count
 * @property-read int|null $usersurveyasnwer_count
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
            ->withPivot("order", "enable", "description");;
    }
    
    public function usersurveyasnwer()
    {
        return $this->hasMany('\App\Usersurveyanswer');
    }
}
