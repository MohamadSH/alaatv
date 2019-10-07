<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\ProductSet
 *
 * @property int                             $contentset_id
 * @property int                             $product_id
 * @property int                             $order ترتیب
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ProductSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet whereContentsetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductSet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ProductSet withoutTrashed()
 * @mixin \Eloquent
 */
class ProductSet extends Pivot
{
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    
    protected $table = 'contentset_product';
    //$p->sets()->updateExistingPivot($s,['order'=>4])
}
