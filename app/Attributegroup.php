<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Attributegroup
 *
 * @property int                                                       $id
 * @property string|null                                               $name            نام گروه
 * @property string|null                                               $description     توضیح گروه
 * @property int|null                                                  $attributeset_id آی دی مشخص کننده دسته صفت
 *           مربوطه
 * @property int                                                       $order           ترتیب گروه صفت
 * @property Carbon|null                                       $created_at
 * @property Carbon|null                                       $updated_at
 * @property Carbon|null                                       $deleted_at
 * @property-read Collection|Attribute[] $attributes
 * @property-read Attributeset|null                                    $attributeset
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Attributegroup onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Attributegroup whereAttributesetId($value)
 * @method static Builder|Attributegroup whereCreatedAt($value)
 * @method static Builder|Attributegroup whereDeletedAt($value)
 * @method static Builder|Attributegroup whereDescription($value)
 * @method static Builder|Attributegroup whereId($value)
 * @method static Builder|Attributegroup whereName($value)
 * @method static Builder|Attributegroup whereOrder($value)
 * @method static Builder|Attributegroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Attributegroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attributegroup withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Attributegroup newModelQuery()
 * @method static Builder|Attributegroup newQuery()
 * @method static Builder|Attributegroup query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                     $cache_cooldown_seconds
 * @property-read int|null                                                  $attributes_count
 */
class Attributegroup extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'attributeset_id',
    ];

    public function attributes()
    {
        return $this->belongsToMany('App\Attribute')
            ->withPivot('order', 'description')
            ->withTimestamps()
            ->orderBy('order');
    }

    public function attributeset()
    {
        return $this->belongsTo('App\Attributeset');
    }
}
