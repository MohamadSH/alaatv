<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
 * @property string|null             $analysisVideoLink   لینک صفحه تماشای فیلم
 *           تجزیه و تحلیل تمرین
 * @property int                     $order               ترتیب تمرین - در صورت نیاز
 *           به استفاده
 * @property int                     $enable              فعال بودن یا نبودن تمرین
 * @property int                     $assignmentstatus_id آیدی مشخص کننده وضعیت
 *           تمرین
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 * @property Carbon|null     $deleted_at
 * @property-read Assignmentstatus   $assignmentstatus
 * @property-read Collection|Major[] $majors
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Assignment onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Assignment whereAnalysisVideoLink($value)
 * @method static Builder|Assignment whereAssignmentstatusId($value)
 * @method static Builder|Assignment whereCreatedAt($value)
 * @method static Builder|Assignment whereDeletedAt($value)
 * @method static Builder|Assignment whereDescription($value)
 * @method static Builder|Assignment whereEnable($value)
 * @method static Builder|Assignment whereId($value)
 * @method static Builder|Assignment whereName($value)
 * @method static Builder|Assignment whereNumberOfQuestions($value)
 * @method static Builder|Assignment whereOrder($value)
 * @method static Builder|Assignment whereQuestionFile($value)
 * @method static Builder|Assignment whereRecommendedTime($value)
 * @method static Builder|Assignment whereSolutionFile($value)
 * @method static Builder|Assignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Assignment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Assignment withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Assignment newModelQuery()
 * @method static Builder|Assignment newQuery()
 * @method static Builder|Assignment query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null                                              $majors_count
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
