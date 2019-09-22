<?php

namespace App;

/**
 * App\Live
 *
 * @property mixed title
 * @property mixed description
 * @property mixed poster
 * @property mixed start_time
 * @property mixed finish_time
 * @property int $id
 * @property int|null $dayofweek_id آی دی مشخص کننده روز هفته
 * @property string|null $title عنوان لایو
 * @property string|null $description توضیح درباره لایو
 * @property string|null $poster پوستر لایو
 * @property string|null $start_time ساعت شروع لایو
 * @property string|null $finish_time ساع لایو
 * @property string|null $first_live تاریخ اولین رویداد
 * @property string|null $last_live تاریخ آخرین رویداد
 * @property int $enable فعال یا غیرفعال
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Dayofweek|null $dayOfWeek
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live enable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereDayofweekId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereFinishTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereFirstLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereLastLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Live whereUpdatedAt($value)
 * @mixin \Eloquent
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
        'dayofweek'
    ];

    public function dayOfWeek(){
        return $this->belongsTo(Dayofweek::Class , 'dayofweek_id' , 'id');
    }

    public function scopeEnable($query){
        return $query->where('enable' , 1);
    }
}
