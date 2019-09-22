<?php

namespace App;

/**
 * App\Attribute
 *
 * @property int                                                                 $id
 * @property int|null                                                            $attributecontrol_id آی دی مشخص کننده
 *           کنترل قابل استفاده برای صفت
 * @property string|null                                                         $name                نام صفت
 * @property string|null                                                         $displayName         نام قابل نمایش
 * @property string|null                                                         $description         توضیح درباره صفت
 * @property \Carbon\Carbon|null                                                 $created_at
 * @property \Carbon\Carbon|null                                                 $updated_at
 * @property \Carbon\Carbon|null                                                 $deleted_at
 * @property int|null                                                            $attributetype_id    آی دی مشخص کننده
 *           نوع صفت مورد نظر
 * @property-read \App\Attributecontrol|null                                     $attributecontrol
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attributegroup[] $attributegroups
 * @property-read \App\Attributetype|null                                        $attributetype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attributevalue[] $attributevalues
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Attribute onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereAttributecontrolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereAttributetypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Attribute withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attribute withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                          $cache_cooldown_seconds
 * @property-read int|null $attributegroups_count
 * @property-read int|null $attributevalues_count
 */
class Attribute extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'attributecontrol_id',
        'attributetype_id',
    ];
    
    public function attributegroups()
    {
        return $this->belongsToMany('App\Attributegroup')
            ->withTimestamps();
    }
    
    public function attributecontrol()
    {
        return $this->belongsTo('App\Attributecontrol');
    }
    
    public function attributetype()
    {
        return $this->belongsTo('App\Attributetype');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Attributevalue
     */
    public function attributevalues()
    {
        return $this->hasMany('App\Attributevalue');
    }
}
