<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Article
 *
 * @property int                            $id
 * @property int|null                       $user_id            آی دی مشخص کننده فرد ایجاد کننده مقاله
 * @property int|null                  $articlecategory_id آی دی مشخص کننده دسته بندی مقاله
 * @property int                       $order              ترتیب مقاله
 * @property string|null               $title              عنوان مقاله
 * @property string|null               $keyword            کلمات کلیدی مقاله
 * @property string|null               $brief              خلاصه مقاله
 * @property string|null               $body               متن مقاله
 * @property string|null               $image              تصویر مقاله
 * @property Carbon|null       $created_at
 * @property Carbon|null       $updated_at
 * @property Carbon|null       $deleted_at
 * @property-read Articlecategory|null $articlecategory
 * @property-read User|null            $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Article onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Article whereArticlecategoryId($value)
 * @method static Builder|Article whereBody($value)
 * @method static Builder|Article whereBrief($value)
 * @method static Builder|Article whereCreatedAt($value)
 * @method static Builder|Article whereDeletedAt($value)
 * @method static Builder|Article whereId($value)
 * @method static Builder|Article whereImage($value)
 * @method static Builder|Article whereKeyword($value)
 * @method static Builder|Article whereOrder($value)
 * @method static Builder|Article whereTitle($value)
 * @method static Builder|Article whereUpdatedAt($value)
 * @method static Builder|Article whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Article withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Article newModelQuery()
 * @method static Builder|Article newQuery()
 * @method static Builder|Article query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                     $cache_cooldown_seconds
 */
class Article extends BaseModel
{
    //    use Searchable;

    protected $fillable = [
        'user_id',
        'articlecategory_id',
        'order',
        'title',
        'keyword',
        'brief',
        'body',
        'image',
    ];

    public static function recentArticles($number)
    {
        return Article::take($number)
            ->orderBy('created_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function articlecategory()
    {
        return $this->belongsTo('App\Articlecategory');
    }

    public function sameCategoryArticles($number)
    {
        return Article::where('articlecategory_id', $this->articlecategory_id)
            ->where('id', "<>", $this->id)
            ->orderBy('created_at', 'desc')
            ->take($number);
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'articles_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        unset($array['image']);

        return $array;
    }
}
