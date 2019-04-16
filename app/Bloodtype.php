<?php

namespace App;

/**
 * App\Bloodtype
 *
 * @property int $id
 * @property string $name        نام
 * @property string|null $displayName نام قابل نمایش
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Bloodtype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bloodtype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Bloodtype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bloodtype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 */
class Bloodtype extends BaseModel
{
    protected $fillable = [
        'name',
        'displayName',
    ];
}
