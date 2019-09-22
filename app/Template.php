<?php

namespace App;

/**
 * App\Template
 *
 * @property int                                                          $id
 * @property string|null                                                  $name نام
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Template onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Template withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null $contents_count
 */
class Template extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    
    public function contents()
    {
        return $this->hasMany('\App\Content');
    }
}
