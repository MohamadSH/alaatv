<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * App\Dayofweek
 *
 * @property int                    $id
 * @property string|null            $name         نام روز
 * @property string|null            $display_name نام قابل نمایش روز
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property Carbon|null            $deleted_at
 * @property-read Collection|Live[] $lives
 * @property-read int|null          $lives_count
 * @method static Builder|Dayofweek newModelQuery()
 * @method static Builder|Dayofweek newQuery()
 * @method static Builder|Dayofweek query()
 * @method static Builder|Dayofweek whereCreatedAt($value)
 * @method static Builder|Dayofweek whereDeletedAt($value)
 * @method static Builder|Dayofweek whereDisplayName($value)
 * @method static Builder|Dayofweek whereId($value)
 * @method static Builder|Dayofweek whereName($value)
 * @method static Builder|Dayofweek whereUpdatedAt($value)
 * @mixin Eloquent
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

    public function lives()
    {
        return $this->hasMany(Live::Class);
    }
}
