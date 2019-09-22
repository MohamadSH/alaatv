<?php

namespace App;

/**
 * App\Dayofweek
 *
 * @property mixed id
 * @property int $id
 * @property string|null $name نام روز
 * @property string|null $display_name نام قابل نمایش روز
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Live[] $lives
 * @property-read int|null $lives_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dayofweek whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dayofweek extends BaseModel
{
    protected $table = 'dayofweek';

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'displayName',
    ];

    public function lives(){
        return $this->hasMany(Live::Class);
    }
}
