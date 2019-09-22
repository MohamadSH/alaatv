<?php

namespace App;

/**
 * App\Attributegroup
 *
 * @property int                                                            $id
 * @property string|null                                                    $name            نام گروه
 * @property string|null                                                    $description     توضیح گروه
 * @property int|null                                                       $attributeset_id آی دی مشخص کننده دسته صفت
 *           مربوطه
 * @property int                                                            $order           ترتیب گروه صفت
 * @property \Carbon\Carbon|null                                            $created_at
 * @property \Carbon\Carbon|null                                            $updated_at
 * @property \Carbon\Carbon|null                                            $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attribute[] $attributes
 * @property-read \App\Attributeset|null                                    $attributeset
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributegroup onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup whereAttributesetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Attributegroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributegroup withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributegroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                     $cache_cooldown_seconds
 * @property-read int|null $attributes_count
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
