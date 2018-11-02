<?php

namespace App;


use App\Traits\DateTrait;
use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Articlecategory
 *
 * @property int                                                          $id
 * @property string|null                                                  $name        نام دسته بندی
 * @property string|null                                                  $description توضیح دسته بندی مقالات
 * @property int                                                          $enable      فعال بودن یا نبودن دسته
 * @property int                                                          $order       ترتیب دسته
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Article[] $articles
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Articlecategory onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Articlecategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Articlecategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Articlecategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Articlecategory whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Articlecategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Articlecategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Articlecategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Articlecategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Articlecategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Articlecategory withoutTrashed()
 * @mixin \Eloquent
 */
class Articlecategory extends Model
{
    use SoftDeletes;
    use Helper;
    use DateTrait;
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

    protected $fillable = [
        'name',
        'description',
        'enable',
        'order',
    ];

    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
