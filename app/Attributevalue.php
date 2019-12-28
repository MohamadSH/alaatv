<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Attributevalue
 *
 * @property int                            $id
 * @property int                            $attribute_id
 * @property string|null                    $name        نام مقدار نسبت داده شده
 * @property string|null                    $description توضیح درباره این مفدار
 * @property int|null                       $isDefault   مقدار پیش فرض - در صورت وجود
 * @property int                            $order       ترتیب مقدار
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property Carbon|null            $deleted_at
 * @property-read Attribute                 $attribute
 * @property-read Collection|Orderproduct[] $orderproducts
 * @property-read Collection|Product[]      $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Attributevalue onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Attributevalue whereAttributeId($value)
 * @method static Builder|Attributevalue whereCreatedAt($value)
 * @method static Builder|Attributevalue whereDeletedAt($value)
 * @method static Builder|Attributevalue whereDescription($value)
 * @method static Builder|Attributevalue whereId($value)
 * @method static Builder|Attributevalue whereIsDefault($value)
 * @method static Builder|Attributevalue whereName($value)
 * @method static Builder|Attributevalue whereOrder($value)
 * @method static Builder|Attributevalue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Attributevalue withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attributevalue withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Attributevalue newModelQuery()
 * @method static Builder|Attributevalue newQuery()
 * @method static Builder|Attributevalue query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                        $cache_cooldown_seconds
 * @property-read int|null                                                     $orderproducts_count
 * @property-read int|null                                                     $products_count
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
