<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Live
 *
 * @property mixed                           title
 * @property mixed                           description
 * @property mixed                           poster
 * @property mixed                           start_time
 * @property mixed                           finish_time
 * @property int                             $id
 * @property int|null                        $dayofweek_id آی دی مشخص کننده روز هفته
 * @property string|null                     $title        عنوان لایو
 * @property string|null                     $description  توضیح درباره لایو
 * @property string|null                     $poster       پوستر لایو
 * @property string|null                     $start_time   ساعت شروع لایو
 * @property string|null                     $finish_time  ساع لایو
 * @property string|null                     $first_live   تاریخ اولین رویداد
 * @property string|null                     $last_live    تاریخ آخرین رویداد
 * @property int                             $enable       فعال یا غیرفعال
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Dayofweek|null             $dayOfWeek
 * @method static Builder|Live enable()
 * @method static Builder|Live newModelQuery()
 * @method static Builder|Live newQuery()
 * @method static Builder|Live query()
 * @method static Builder|Live whereCreatedAt($value)
 * @method static Builder|Live whereDayofweekId($value)
 * @method static Builder|Live whereDeletedAt($value)
 * @method static Builder|Live whereDescription($value)
 * @method static Builder|Live whereEnable($value)
 * @method static Builder|Live whereFinishTime($value)
 * @method static Builder|Live whereFirstLive($value)
 * @method static Builder|Live whereId($value)
 * @method static Builder|Live whereLastLive($value)
 * @method static Builder|Live wherePoster($value)
 * @method static Builder|Live whereStartTime($value)
 * @method static Builder|Live whereTitle($value)
 * @method static Builder|Live whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Live extends BaseModel
{
    protected $table = 'liveschedules';

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'dayofweek_id',
        'title',
        'description',
        'poster',
        'start_time',
        'finish_time',
        'first_live',
        'last_live',
        'enable',
    ];

    protected $hidden = [
        'dayofweek',
    ];

    public function dayOfWeek()
    {
        return $this->belongsTo(Dayofweek::Class, 'dayofweek_id', 'id');
    }

    public function scopeEnable($query)
    {
        return $query->where('enable', 1);
    }
}
