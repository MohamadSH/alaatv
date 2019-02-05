<?php

namespace App;


/**
 * App\Article
 *
 * @property int                            $id
 * @property int|null                       $user_id            آی دی مشخص کننده فرد ایجاد کننده مقاله
 * @property int|null                       $articlecategory_id آی دی مشخص کننده دسته بندی مقاله
 * @property int                            $order              ترتیب مقاله
 * @property string|null                    $title              عنوان مقاله
 * @property string|null                    $keyword            کلمات کلیدی مقاله
 * @property string|null                    $brief              خلاصه مقاله
 * @property string|null                    $body               متن مقاله
 * @property string|null                    $image              تصویر مقاله
 * @property \Carbon\Carbon|null            $created_at
 * @property \Carbon\Carbon|null            $updated_at
 * @property \Carbon\Carbon|null            $deleted_at
 * @property-read \App\Articlecategory|null $articlecategory
 * @property-read \App\User|null            $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Article onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereArticlecategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereBrief($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Article withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
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
