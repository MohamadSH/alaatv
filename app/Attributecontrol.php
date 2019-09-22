<?php

namespace App;

/**
 * App\Attributecontrol
 *
 * @property int                                                            $id
 * @property string|null                                                    $name        نام کنترل صفت
 * @property string|null                                                    $description توضیح درباره کنترل
 * @property \Carbon\Carbon|null                                            $created_at
 * @property \Carbon\Carbon|null                                            $updated_at
 * @property \Carbon\Carbon|null                                            $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attribute[] $attributes
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributecontrol onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Attributecontrol withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributecontrol withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributecontrol query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                     $cache_cooldown_seconds
 * @property-read int|null $attributes_count
 */
class Attributecontrol extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];
    
    public function attributes()
    {
        return $this->hasMany('App\Attribute');
    }
}
