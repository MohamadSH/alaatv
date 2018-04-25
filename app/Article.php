<?php

namespace App;


use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use SoftDeletes;
    use Helper;
//    use Searchable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'user_id',
        'articlecategory_id',
        'order',
        'title',
        'keyword',
        'brief',
        'body',
        'image'
    ];

    public static function recentArticles($number)
    {
        return Article::take($number)->orderBy('created_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function articlecategory()
    {
        return $this->belongsTo('App\Articlecategory');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {

        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {

        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->updated_at, "toJalali");
    }

    public function sameCategoryArticles($number)
    {
        return Article::where('articlecategory_id', $this->articlecategory_id)->where('id', "<>", $this->id)->orderBy('created_at', 'desc')->take($number);
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
