<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Attribute
 *
 * @property int                                                                 $id
 * @property int|null                         $attributecontrol_id آی دی مشخص کننده
 *           کنترل قابل استفاده برای صفت
 * @property string|null                      $name                نام صفت
 * @property string|null                      $displayName         نام قابل نمایش
 * @property string|null                      $description         توضیح درباره صفت
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @property Carbon|null              $deleted_at
 * @property int|null                         $attributetype_id    آی دی مشخص کننده
 *           نوع صفت مورد نظر
 * @property-read Attributecontrol|null       $attributecontrol
 * @property-read Collection|Attributegroup[] $attributegroups
 * @property-read Attributetype|null          $attributetype
 * @property-read Collection|Attributevalue[] $attributevalues
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Attribute onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Attribute whereAttributecontrolId($value)
 * @method static Builder|Attribute whereAttributetypeId($value)
 * @method static Builder|Attribute whereCreatedAt($value)
 * @method static Builder|Attribute whereDeletedAt($value)
 * @method static Builder|Attribute whereDescription($value)
 * @method static Builder|Attribute whereDisplayName($value)
 * @method static Builder|Attribute whereId($value)
 * @method static Builder|Attribute whereName($value)
 * @method static Builder|Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Attribute withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attribute withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Attribute newModelQuery()
 * @method static Builder|Attribute newQuery()
 * @method static Builder|Attribute query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                          $cache_cooldown_seconds
 * @property-read int|null                                                       $attributegroups_count
 * @property-read int|null                                                       $attributevalues_count
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
     * @return HasMany|Attributevalue
     */
    public function attributevalues()
    {
        return $this->hasMany('App\Attributevalue');
    }
}
