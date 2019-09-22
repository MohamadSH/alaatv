<?php

namespace App;

/**
 * App\Conductor
 *
 * @property mixed poster
 * @property mixed scheduled_finish_time
 * @property int $id
 * @property string|null $title عنوان برنامه
 * @property string|null $description توضیح درباره برنامه
 * @property string|null $poster پوستر برنامه
 * @property string|null $date تاریخ لایو
 * @property string|null $scheduled_start_time زمان شروع برنامه در جدول برنامه ها
 * @property string|null $scheduled_finish_time زمان شروع برنامه در جدول برنامه ها
 * @property string|null $start_time زمان شروع برنامه
 * @property string|null $finish_time زمان پایان برنامه
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereFinishTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereScheduledFinishTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereScheduledStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conductor whereUpdatedAt($value)
 * @mixin \Eloquent
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
