<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Conductor
 *
 * @property mixed                           poster
 * @property mixed                           scheduled_finish_time
 * @property int                             $id
 * @property string|null                     $title                 عنوان برنامه
 * @property string|null                     $description           توضیح درباره برنامه
 * @property string|null                     $poster                پوستر برنامه
 * @property string|null                     $date                  تاریخ لایو
 * @property string|null                     $scheduled_start_time  زمان شروع برنامه در جدول برنامه ها
 * @property string|null                     $scheduled_finish_time زمان شروع برنامه در جدول برنامه ها
 * @property string|null                     $start_time            زمان شروع برنامه
 * @property string|null                     $finish_time           زمان پایان برنامه
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Conductor newModelQuery()
 * @method static Builder|Conductor newQuery()
 * @method static Builder|Conductor query()
 * @method static Builder|Conductor whereCreatedAt($value)
 * @method static Builder|Conductor whereDate($value)
 * @method static Builder|Conductor whereDeletedAt($value)
 * @method static Builder|Conductor whereDescription($value)
 * @method static Builder|Conductor whereFinishTime($value)
 * @method static Builder|Conductor whereId($value)
 * @method static Builder|Conductor wherePoster($value)
 * @method static Builder|Conductor whereScheduledFinishTime($value)
 * @method static Builder|Conductor whereScheduledStartTime($value)
 * @method static Builder|Conductor whereStartTime($value)
 * @method static Builder|Conductor whereTitle($value)
 * @method static Builder|Conductor whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Conductor extends BaseModel
{
    protected $table = 'liveconductors';

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'poster',
        'date',
        'scheduled_start_time',
        'scheduled_finish_time',
        'start_time',
        'finish_time',
    ];
}
