<?php

namespace App;

/**
 * App\Assignment
 *
 * @property int                                                        $id
 * @property string|null                                                $name                نام تمرین
 * @property string|null                                                $description         توضیح درباره تمرین
 * @property string|null                                                $numberOfQuestions   تعداد سؤالات تمرین
 * @property string|null                                                $recommendedTime     وقت پیشنهادی برای حل
 *           سؤالات تمرین
 * @property string|null                                                $questionFile        فایل سوالات تمرین
 * @property string|null                                                $solutionFile        فایل پاسخنامه(حل) تمرین
 * @property string|null                                                $analysisVideoLink   لینک صفحه تماشای فیلم
 *           تجزیه و تحلیل تمرین
 * @property int                                                        $order               ترتیب تمرین - در صورت نیاز
 *           به استفاده
 * @property int                                                        $enable              فعال بودن یا نبودن تمرین
 * @property int                                                        $assignmentstatus_id آیدی مشخص کننده وضعیت
 *           تمرین
 * @property \Carbon\Carbon|null                                        $created_at
 * @property \Carbon\Carbon|null                                        $updated_at
 * @property \Carbon\Carbon|null                                        $deleted_at
 * @property-read \App\Assignmentstatus                                 $assignmentstatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Major[] $majors
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereAnalysisVideoLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereAssignmentstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereNumberOfQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereQuestionFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereRecommendedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereSolutionFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null $majors_count
 */
class Assignment extends BaseModel
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'numberOfQuestions',
        'recommendedTime',
        'questionFile',
        'solutionFile',
        'analysisVideoLink',
        'order',
        'enable',
        'assignmentstatus_id',
    ];
    
    public function assignmentstatus()
    {
        return $this->belongsTo('App\Assignmentstatus');
    }
    
    public function majors()
    {
        return $this->belongsToMany('App\Major')
            ->withTimestamps();
    }
}
