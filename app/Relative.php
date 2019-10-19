<?php

namespace App;

/**
 * App\Relative
 *
 * @property int                                                          $id
 * @property string|null                                                  $name        نام رکورد
 * @property string|null                                                  $displayName نام قابل نمایش رکورد
 * @property string|null                                                  $description توضیح رکورد
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[] $contact
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Relative onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Relative withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Relative withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null $contact_count
 */
class Relative extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];
    
    public function contact()
    {
        return $this->hasMany('\App\Contact');
    }
}
