<?php

namespace App\Classes;

use App\Classes\Singleton;
use Redis;

class RedisTagging extends Singleton
{
    protected $prefix = "tagging";

    /**
     * @param $bucket
     * @return bool
     */
    private function validation($bucket) :bool {
        if(strcmp($bucket,"TAGS") === 0 )
            return false;
        return true;
    }
    /**
     * Get all tags for an ID
     * @param string $bucket
     * @param string $id
     * @return array
     */
    private function get($bucket, $id)
    {
        if(!$this->validation($bucket)) return [ "error" => "bucket should not Equal to \" TAGS \" "];
        $redisKey = $this->prefix .":" .$bucket . ":" . $id ;
        $tags = Redis::sMembers($redisKey);
        return $tags;
    }

    /**
     * Set (insert or update) an item
     * @param string $bucket
     * @param string $id
     * @param $tags (Array)
     * @param int $score (Number) *optional* Default: 0
     * @return bool Returns `true` when the item was set.
     */

    private function add($bucket, $id, $tags, $score = 0){
        if(!$this->validation($bucket)) return false;

        $redisKeyBucket = $this->prefix .":" .$bucket . ":" . "-" ;
        $redisKeyTag = $this->prefix .":" .$bucket . ":" . $id ;
        try {
            Redis::pipeline(
                function ($pipe) use ($tags, $redisKeyTag, $score,$redisKeyBucket,$id) {
                    $pipe->zAdd($redisKeyBucket, $score, $id);
                    foreach ($tags as $tag) {

                        $pipe->zAdd($redisKeyTag, $score, $tag);
                    }
                });
        } catch (\Exception $e){
            return false;
        }

        return true;
    }

    /**
     * Set (insert or update) an item
     * @param string $bucket
     * @param string $id
     * @param $tags (Array)
     * @param int $score (Number) *optional* Default: 0
     * @return bool Returns `true` when the item was set.
     */
    private function set($bucket, $id, $tags, $score = 0)
    {
        if(!$this->validation($bucket)) return false;

        $this->remove($bucket,$id);
        $this->add($bucket, $id, $tags, $score);
    }

    /**
     * Remove / Delete an item
     * @param string $bucket
     * @param string $id
     * @return bool Returns `true` even if that id did not exist.
     */
    private function remove($bucket, $id)
    {
        if(!$this->validation($bucket)) return false;

        $redisKeyBucket = $this->prefix .":" .$bucket . ":" . "-" ;
        $redisKeyTag = $this->prefix .":" .$bucket . ":" . $id ;
        try{
            Redis::zRem($redisKeyBucket,$id);
            Redis::delete($redisKeyTag);
        }catch (\Exception $e ){
            return false;
        }
        return true;
    }

    /**
     *  Get all IDs for a single bucket
     * @param string $bucket
     * @return array Returns an array of item ids
     */
    private function allIds($bucket)
    {
        if(!$this->validation($bucket)) return [ "error" => "bucket should not Equal to \" TAGS \" "];

        $redisKeyBucket = $this->prefix .":" .$bucket . ":" . "-" ;
        $result = Redis::sMembers($redisKeyBucket);
        return $result;
    }

    /**
     * Return the IDs of an either a single tag or an intersection/union of two or more tags
     *
     * @param string $bucket (String)
     * @param $tags (Array) One or more tags
     * @param int $limit *optional* Default=100 (0 will return 0 items but will return the total_items!)
     * @param int $offset *optional* Default=0
     * @param int $withScores *optional* Default=0 Set this to 1 to output the scores
     * @param string $type *optional* Default ="desc"
     * @param $order *optional* "inter", "union" Default: "inter"
     * @return array
     */
    private function tags($bucket, $tags, $limit = 100, $offset = 0, $withScores = 0, $order = "desc", $type = "inter")
    {
        if(!$this->validation($bucket)) return [ "error" => "bucket should not Equal to \" TAGS \" "];

        $res = Redis::multi();

        return $res;
    }

    /**
     * TopTags
     * @param string $bucket
     * @param string $amount
     * @return array
     */
    private function topTags($bucket, $amount)
    {
        if(!$this->validation($bucket)) return [ "error" => "bucket should not Equal to \" TAGS \" "];

        return [];
    }

    /**
     *  Returns all buckets.
     *  Use with care: Uses redis.keys
     * @return array Returns an array with all buckets
     */
    private function buckets()
    {
        return [];
    }

    /**
     * Remove a bucket and all its keys
     * Use with care: Uses redis.keys
     * @param $bucket
     * @return bool
     */
    private function removeBucket($bucket)
    {
        if(!$this->validation($bucket)) return false;

    }
}