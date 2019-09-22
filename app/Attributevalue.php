<?php

namespace App;

/**
 * App\Attributevalue
 *
 * @property int                                                               $id
 * @property int                                                               $attribute_id
 * @property string|null                                                       $name        نام مقدار نسبت داده شده
 * @property string|null                                                       $description توضیح درباره این مفدار
 * @property int|null                                                          $isDefault   مقدار پیش فرض - در صورت وجود
 * @property int                                                               $order       ترتیب مقدار
 * @property \Carbon\Carbon|null                                               $created_at
 * @property \Carbon\Carbon|null                                               $updated_at
 * @property \Carbon\Carbon|null                                               $deleted_at
 * @property-read \App\Attribute                                               $attribute
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[] $orderproducts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[]      $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributevalue onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Attributevalue withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributevalue withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributevalue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                        $cache_cooldown_seconds
 * @property-read int|null $orderproducts_count
 * @property-read int|null $products_count
 */
class Attributevalue extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'attribute_id',
        'name',
        'description',
        'isDefault',
    ];
    
    public function attribute()
    {
        return $this->belongsTo('App\Attribute');
    }
    
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
    
    public function orderproducts()
    {
        return $this->belongsToMany('App\Orderproduct', 'attributevalue_orderproduct', 'value_id', 'orderproduct_id');
    }
}
