<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\ProductSet
 *
 * @property int         $contentset_id
 * @property int         $product_id
 * @property int         $order ترتیب
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet newQuery()
 * @method static Builder|ProductSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet whereContentsetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSet whereUpdatedAt($value)
 * @method static Builder|ProductSet withTrashed()
 * @method static Builder|ProductSet withoutTrashed()
 * @mixin Eloquent
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
