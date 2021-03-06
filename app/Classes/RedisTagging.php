<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
use Mockery\Exception;

// https://github.com/smrchy/redis-tagging/blob/master/index.coffee

class RedisTagging
{
    public const CONST_TYPE_INTER = 'inter';

    public const CONST_ORDER_DESC = 'desc';

    protected $prefix = 'tagging';

    protected $redis;

    /**
     * RedisTagging constructor.
     */
    public function __construct()
    {
        $this->redis = Redis::connection('redisDB');
    }


    /**
     * Get all tags for an ID
     *
     * @param string   $bucket
     * @param string   $id
     * @param          $cb
     *
     * @return array
     */
    public function get($bucket, $id, $cb)
    {

        if (!$this->validation($bucket)) {
            return [
                'error' => '',
            ];
        }

        $ns       = $this->prefix . ':' . $bucket;
        $id_index = $ns . ':ID:' . $id;

        try {
            $tags = $this->redis->sMembers($id_index);
        } catch (Exception $e) {

            $cb($e, [
                'msg' => 'Error!',
            ]);
            return [
                'error' => '',
            ];
        }

        $cb(null, [
            'total_items' => count($tags),
            'id'          => $id,
            'bucket'      => $bucket,
            'tags'        => $tags,
        ]);
    }

    /**
     * @param $bucket
     *
     * @return bool
     */
    private function validation($bucket): bool
    {
        return true;
    }

    /**
     * Remove / Delete an item
     *
     * @param string   $bucket
     * @param string   $id
     * @param          $cb
     *
     * @return void Returns `true` even if that id did not exist.
     */
    public function remove($bucket, $id, $cb)
    {
        $this->set($bucket, $id, [], $cb);
    }

    /**
     * Set (insert or update) an item
     *
     * @param string   $bucket
     * @param string   $id
     * @param          $tags  (Array)
     * @param int      $score (Number) *optional* Default: 0
     * @param          $cb
     *
     * @return bool Returns `true` when the item was set.
     */
    public function set($bucket, $id, $tags, $cb, $score = 0)
    {

        if (!$this->validation($bucket)) {
            return false;
        }

        $ns       = $this->prefix . ':' . $bucket;
        $id_index = $ns . ':ID:' . $id;

        $this->delete($ns, $id);

        try {
            $pipeResult = $this->redis->pipeline(function ($pipe) use ($tags, $score, $id, $id_index, $ns) {
                foreach ($tags as $tag) {
                    $pipe->zincrby($ns . ':TagCount', 1, $tag);
                    $pipe->sAdd($id_index, $tag);
                    $pipe->zAdd($ns . ':TAGS:' . $tag, $score, $id);
                }
                if (count($tags) > 0) {
                    $pipe->sAdd($ns . ':IDs', $id);
                }
            });

        } catch (\Exception $e) {

            $cb($e, false);
        }

        $cb(null, true);
    }

    private function delete($ns, $id)
    {
        try {
            $id_index = $ns . ':ID:' . $id;
            $tags     = $this->redis->sMembers($id_index);

            $this->redis->pipeline(function ($pipe) use ($tags, $id, $id_index, $ns) {
                # This ID already has tags. We will delete them first
                foreach ($tags as $tag) {
                    $pipe->zincrby($ns . ':TagCount', -1, $tag);
                    $pipe->zRem($ns . ':TAGS:' . $tag, $id);
                }
                # Also delete the index for this ID
                $pipe->unlink($id_index);
                # Delete the id in the IDS list
                $pipe->sRem($ns . ':IDs', $id);
                # Clean up the TAGCOUNT
                $pipe->zremrangebyscore($ns . ':TagCount', 0, 0);
            });

        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * Return the IDs of an either a single tag or an intersection/union of two or more tags
     *
     * @param string   $bucket     (String)
     * @param          $tags_group (TagsGroupContracts) One or more group of tags
     * @param int      $limit      *optional* Default=100 (0 will return 0 items but will return the total_items!)
     * @param int      $offset     *optional* Default=0
     * @param int      $withScores *optional* Default=0 Set this to 1 to output the scores
     * @param string   $order      *optional* "inter", "union" Default: "inter"
     * @param string   $type       *optional* Default ="desc"
     * @param          $cb
     */
    public function tags($bucket, TagsGroupContracts $tags_group, $cb, $limit = 100, $offset = 0,
                         $withScores = 0, $order = 'desc', $type = 'inter'): void
    {

        $ns     = $this->prefix . ':' . $bucket;
        $prefix = $ns . ':TAGS:';
        # The last element to get
        $lastElement = $offset + $limit - 1;


        $cTags = $tags_group->getNumberOfTotalTags();
        if ($cTags === 0) {
            $cb(null, [
                'total_items_result' => 0,
                'total_items_db'     => 0,
                'items'              => [],
                'tags'               => $tags_group->getTagsArray(),
                'limit'              => $limit,
                'offset'             => $offset,
                'withScores'         => $withScores,
                'order'              => $order,
                'type'               => $type,
            ]);
            return;
        }
        $pipe      = $this->redis->pipeline();
        $tagGroups = $tags_group->getTagsGroup();

        $resultKeyForGroups = [];
        $shouldRemoveKeys   = [];
        foreach ($tagGroups as $tags) {
            $cTags = count($tags);
            if ($cTags > 1) {
                $randKey = $this->makeRandomKeyForRedis($ns);
                $keys    = [];
                foreach ($tags as $tag) {
                    $keys[] = $prefix . $tag;
                }
                try {
                    $pipe->zunionstore($randKey, $keys, null, 'min');
                } catch (Exception $e) {
                }
                $resultKeyForGroups[] = $randKey;
                $shouldRemoveKeys[]   = $randKey;
            } else if ($cTags === 1) {
                $resultKeyForGroups[] = $prefix . $tags[0];
            }
        }
        $cTags     = $tags_group->getNumberOfTotalTags();
        $resultkey = $this->makeRandomKeyForRedis($ns);
        try {
            $pipe->zinterstore($resultkey, $resultKeyForGroups, null, 'min');
            $pipe->zCount($resultkey, '-inf', '+inf');
            if (strcmp($order, self::CONST_ORDER_DESC) === 0) {
                $pipe->zRevRange($resultkey, $offset, $lastElement, ['withscores' => $withScores]);
            } else {
                $pipe->zRange($resultkey, $offset, $lastElement, ['withscores' => $withScores]);
            }
            $pipeLineResult = $this->redis->exec();
        } catch (Exception $e) {
            $this->redis->discard();

            $total_items_db = 0;
            $cb($e, [
                'msg' => 'Error!',
            ]);
            return;
        }
        $tagsresult     = end($pipeLineResult);
        $total_items_db = count($tagsresult);

        if ($cTags > 1) {
            $this->redis->pipeline(function ($pipe) use ($shouldRemoveKeys, $resultkey) {
                $pipe->unlink($resultkey);
                $pipe->unlink($shouldRemoveKeys);
            });
        }

        $result = [];

        if ($withScores) {
            foreach ($tagsresult as $id => $score) {
                $temp     = [
                    'bucket' => $bucket,
                    'id'     => $id,
                    'score'  => $score,
                ];
                $result[] = $temp;
            }
        } else {
            foreach ($tagsresult as $id) {
                $temp     = [
                    'bucket' => $bucket,
                    'id'     => $id,
                    'score'  => 0,
                ];
                $result[] = $temp;
            }
        }
        $cb(null, [
            'total_items_result' => count($tagsresult),
            'total_items_db'     => $total_items_db,
            'items'              => $result,
            'tags'               => $tags_group->getTagsArray(),
            'limit'              => $limit,
            'offset'             => $offset,
            'withScores'         => $withScores,
            'order'              => $order,
            'type'               => $type,
        ]);
    }

    /**
     * @param string $ns
     *
     * @return string
     */
    private function makeRandomKeyForRedis(string $ns): string
    {
        $randKey = $ns . str_random(10) . '_' . Carbon::now()->micro;
        return $randKey;
    }

    public function flushDB($cb)
    {
        abort(Response::HTTP_FORBIDDEN);
        $this->redis->command('FLUSHDB');

        $cb(null, true);
    }

    /**
     *  Get all IDs for a single bucket
     *
     * @param string $bucket
     *
     * @return array
     */
    private function allIds($bucket, $cb)
    {
        $ns = $this->prefix . ':' . $bucket;
        try {
            $ids = $this->redis->sMembers($ns . ':IDS');
        } catch (\Exception $e) {
            return [];
        }

        $cb(null, $ids);
    }

    /**
     * TopTags
     *
     * @param string $bucket
     * @param string $amount
     *
     * @return array
     */
    private function topTags($bucket, $amount, $cb)
    {
        if (!$this->validation($bucket)) {
            return ['error' => 'bucket should not Equal to " TAGS " '];
        }

        $ns       = $this->prefix . ':' . $bucket;
        $amount   = $amount - 1;
        $redisKey = $ns . ':TagCount';
        $num      = $redisKey->zCard($redisKey);
        $result   = $this->redis->zRevRange($redisKey, 0, $amount, true);

        $cb(null, [
            'total_items' => $num,
            'items'       => $result,
        ]);
    }

    /**
     *  Returns all buckets.
     *  Use with care: Uses redis.keys
     *
     * @return array Returns an array with all buckets
     */
    private function buckets()
    {
        return [];
    }

    /**
     * Remove a bucket and all its keys
     * Use with care: Uses redis.keys
     *
     * @param $bucket
     *
     * @return bool
     */
    private function removeBucket($bucket)
    {
        if (!$this->validation($bucket)) {
            return false;
        }
    }
}
