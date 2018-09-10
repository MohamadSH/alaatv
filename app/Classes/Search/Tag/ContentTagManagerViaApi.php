<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-10
 * Time: 16:08
 */

namespace App\Classes\Search\Tag;


use App\Classes\Search\RedisTagManagerViaApi;


class ContentTagManagerViaApi extends RedisTagManagerViaApi
{
    protected $bucket = "content";

    /**
     * RedisTagViaApi constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->apiUrl = config("constants.TAG_API_URL");
        $this->limit_PerPage = 100000;
        $this->limit_WithScores = 1;
        $this->limit_PageNum = 1;
    }

    public function getVideos(array $tags){
        return $this->getTaggable(array_merge($tags,['فیلم']));
    }

    public function getPamphlets(array $tags){
        return $this->getTaggable(array_merge($tags,['جزوه']));
    }

    public function getArticles(array $tags){
        return $this->getTaggable(array_merge($tags,['مقاله']));
    }
}