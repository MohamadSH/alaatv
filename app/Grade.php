<?php

namespace App;

/**
 * App\Grade
 *
 * @property int                                                          $id
 * @property string|null                                                  $name        نام
 * @property string|null                                                  $displayName نام قابل نمایش
 * @property string|null                                                  $description توضیح
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Grade onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grade withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Grade withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null $contents_count
 */
class Grade extends BaseModel
{
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];
    
    public function contents()
    {
        return $this->belongsToMany('App\Content');
    }
}
