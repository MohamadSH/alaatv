<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Producttype
 *
 * @property int                                                          $id
 * @property string|null                                                  $displayName نام قابل نمایش این نوع
 * @property string|null                                                  $name        نام این نوع در سیستم
 * @property string|null                                                  $description توضیحات این نوع
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Producttype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Producttype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Producttype query()
 */
class Producttype extends Model
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
        'name',
        'displayName',
        'description',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
