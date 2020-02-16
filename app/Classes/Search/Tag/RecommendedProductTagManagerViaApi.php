<?php


namespace App\Classes\Search\Tag;


use App\Classes\Search\RedisTagManagerViaApi;

class RecommendedProductTagManagerViaApi extends RedisTagManagerViaApi
{
    protected $bucket = "rp";

    /**
     * RedisTagViaApi constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->limit_PerPage    = 1000000;
        $this->limit_WithScores = 1;
        $this->limit_PageNum    = 1;
    }
}
