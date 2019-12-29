<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Articlecategory
 *
 * @property int                                                     $id
 * @property string|null                                             $name        نام دسته بندی
 * @property string|null                                             $description توضیح دسته بندی مقالات
 * @property int                                                     $enable      فعال بودن یا نبودن دسته
 * @property int                                                     $order       ترتیب دسته
 * @property Carbon|null                                     $created_at
 * @property Carbon|null                                     $updated_at
 * @property Carbon|null                                     $deleted_at
 * @property-read Collection|Article[] $articles
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Articlecategory onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Articlecategory whereCreatedAt($value)
 * @method static Builder|Articlecategory whereDeletedAt($value)
 * @method static Builder|Articlecategory whereDescription($value)
 * @method static Builder|Articlecategory whereEnable($value)
 * @method static Builder|Articlecategory whereId($value)
 * @method static Builder|Articlecategory whereName($value)
 * @method static Builder|Articlecategory whereOrder($value)
 * @method static Builder|Articlecategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Articlecategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Articlecategory withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Articlecategory newModelQuery()
 * @method static Builder|Articlecategory newQuery()
 * @method static Builder|Articlecategory query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null                                                $articles_count
 */
class Articlecategory extends BaseModel
{
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
