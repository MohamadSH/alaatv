<?php

namespace App;

/**
 * App\Belonging
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Belonging onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Belonging withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Belonging withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Belonging newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Belonging newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Belonging query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 */
class Belonging extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'file',
    ];

    public function users()
    {
        return $this->belongsToMany('\App\User');
    }
}
