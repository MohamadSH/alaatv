<?php

namespace App;

use Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use SoftDeletes;
//    use Searchable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'articlecategory_id',
        'order' ,
        'title',
        'keyword',
        'brief',
        'body',
        'image'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function articlecategory(){
        return $this->belongsTo('App\Articlecategory');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->created_at , "toJalali" );
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->updated_at , "toJalali" );
    }

    public function sameCategoryArticles($number)
    {
        return   Article::where('articlecategory_id', $this->articlecategory_id)->where('id', "<>", $this->id)->orderBy('created_at','desc')->take($number);
    }

    public static function recentArticles($number)
    {
        return Article::take($number)->orderBy('created_at','desc');
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
