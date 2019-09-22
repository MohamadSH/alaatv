<?php

namespace App;

/**
 * App\Bontype
 *
 * @property int                                                      $id
 * @property string                                                   $name        نام نوع بن
 * @property string|null                                              $displayName نام قابل نمایش نوع بن
 * @property string|null                                              $description توضیح درباره نوع بن
 * @property \Carbon\Carbon|null                                      $created_at
 * @property \Carbon\Carbon|null                                      $updated_at
 * @property \Carbon\Carbon|null                                      $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bon[] $bons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Bontype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bontype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Bontype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bontype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                               $cache_cooldown_seconds
 * @property-read int|null $bons_count
 */
class Bontype extends BaseModel
{
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];
    
    public function bons()
    {
        return $this->hasMany("\App\Bon");
    }
}
