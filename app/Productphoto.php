<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Productphoto
 *
 * @property int                 $id
 * @property int                 $product_id  آیدی مشخص کننده محصول عکس
 * @property string|null         $file        فایل عکس
 * @property string|null         $title       تایتل عکس
 * @property string              $description توضیح کوتاه یا تیتر دوم عکس
 * @property int                 $order       ترتیب عکس
 * @property int                 $enable      فعال/غیر فعال بودن عکس
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Product   $product
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Productphoto onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productphoto withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Productphoto withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto enable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productphoto query()
 */
class Productphoto extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'file',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo('\App\Product');
    }

    /**
     * Scope a query to only include enable(or disable) Products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }
}
