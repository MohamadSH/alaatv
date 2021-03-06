<?php

namespace App\Http\Controllers\Api;

use App\Classes\RedisTagging;
use App\Classes\TagsGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

//https://github.com/smrchy/rest-tagging

class TagController extends Controller
{
    protected $redis;

    public function __construct()
    {
        $this->redis = app(RedisTagging::class);
    }

    /**
     * PUT /rt/id/:bucket/:id
     * Add or update an item. The URL contains the bucket (e.g. 'concerts') and the id for this item.
     *
     * Parameters (as query parameters):
     *
     * tags (String) A JSON string with an array of one or more tags (e.g. ["chicago","rock"])
     * score (Number) optional Default: 0 This is the sorting criteria for this item
     * Example:
     *
     * PUT /rt/id/concerts/571fc1ba4d?score=20130823&tags=["rock","stadium"]
     *
     * Returns:
     *
     * true
     *
     * @param Request|Request                      $request
     * @param                                      $bucket
     * @param                                      $id
     *
     * @return JsonResponse
     */
    public function add(Request $request, $bucket, $id)
    {

        $tags  = json_decode($request->tags, false, 512, JSON_THROW_ON_ERROR);
        $score = $request->score;

        if ($score === null) {
            $score = 0;
        }

        if ($tags === null) {
            return response()->json([
                'error' => 'tag is not set!',
            ], Response::HTTP_GONE);
        }

        $response = null;
        $this->redis->set($bucket, $id, $tags, function ($err, $result) use (& $response) {
            $this->callBack($err, $result, $response);
        }, $score);

        return $response;
    }

    private function callBack($err, $result, &$response)
    {
        if (isset($err)) {
            $response = response()->json([
                'error' => 'msg',
            ], Response::HTTP_GONE);
        }
        $header   = [
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset'      => 'utf-8',
        ];
        $response = response()->json([
            'data' => $result,
        ], Response::HTTP_OK, $header, JSON_UNESCAPED_UNICODE);
    }

    /**
     * GET /rt/id/:bucket/:id
     * Get all tags for an ID
     *
     * @param Request   $request
     * @param           $bucket
     * @param           $id
     *
     * @return null
     */

    public function get(Request $request, $bucket, $id)
    {
        $response = null;
        $this->redis->get($bucket, $id, function ($err, $result) use (& $response) {
            if (isset($err)) {
                $response = response()->json([
                    'error' => 'msg',
                ], Response::HTTP_GONE);
            }
            $header   = [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset'      => 'utf-8',
            ];
            $response = response()->json([
                'data' => $result,
            ], Response::HTTP_OK, $header, JSON_UNESCAPED_UNICODE);
        });

        return $response;
    }

    /**
     * DELETE /rt/id/:bucket/:id
     * Delete an item and all its tag associations.
     *
     * Example: DELETE /rt/id/concerts/12345
     *
     * Returns:
     *
     * true
     *
     * @param Request   $request
     * @param           $bucket
     * @param           $id
     *
     * @return JsonResponse
     */
    public function remove(Request $request, $bucket, $id)
    {
        $response = null;
        $this->redis->remove($bucket, $id, function ($err, $result) use (& $response) {
            $this->callBack($err, $result, $response);
        });

        return $response;
    }

    /**
     * GET /rt/tags/:bucket?queryparams
     * The main method. Return the IDs for one or more tags. When more than one tag is supplied the query can be an
     * intersection (default) or a union. type=inter (default) only those IDs will be returned where all tags match.
     * type=union all IDs where any tag matches will be returned.
     *
     * Parameters:
     *
     * tags (String) a JSON string of one or more tags.
     * type (String) optional Either inter (default) or union.
     * limit (Number) optional Default: 100.
     * offset (Number) optional Default: 0 The amount of items to skip. Useful for paging thru items.
     * withscores (Number) optional Default: 0 Set this to 1 to also return the scores for each item.
     * order (String) optional Either asc or desc (default).
     * Example:
     *
     * GET /rt/tags/concerts?tags=["Berlin","rock"]&limit=2&offset=4&type=inter
     *
     * Returns:
     *
     * {
     * "total_items":108,
     * "items":["8167","25652"],
     * "limit":2,
     * "offset":4
     * }
     * @param Request   $request
     * @param           $bucket
     *
     * @return null
     */
    public function index(Request $request, $bucket)
    {
        $tags = $request->tags;
        $tags = $this->normalizeTags($tags);
        $tags = str_replace('"', '', $tags);
        $tags = explode(',', mb_substr($tags, 1, -1));

        $type       = $request->type ?? 'inter';
        $limit      = $request->limit ?? 100;
        $offset     = $request->offset ?? 0;
        $withscores = $request->withscores ?? 0;
        $order      = $request->order ?? 'desc';

        $response = null;
        $error    = null;

        $this->redis->tags($bucket, new TagsGroup($tags),
            function ($err, $result) use (& $response, &$error) {
                if (isset($err)) {
                    $error = [
                        'error' => 'msg',
                    ];
                    return;
                }
                $this->convertToUtf8($result);
                $response = [
                    'data' => $result,
                ];
            }, $limit, $offset, $withscores, $order, $type);

        if (isset($error)) {
            return response()->json($error, Response::HTTP_GONE);
        }
        $header = [
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset'      => 'utf-8',
        ];
        return response()->json($response, Response::HTTP_OK, $header, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $tags
     *
     * @return string
     */
    private function normalizeTags($tags): string
    {
        $lastCharacter  = mb_substr($tags, -1);
        $firstCharacter = mb_substr($tags, 0, 1);
        if ($firstCharacter !== '[') {
            $tags = '[' . $tags;
        }
        if ($lastCharacter !== ']') {
            $tags .= ']';
        }
        return $tags;
    }

    /**
     * @param $result
     */
    private function convertToUtf8(&$result): void
    {
        if (is_string($result)) {
            mb_convert_encoding($result, 'UTF-8', 'UTF-8');
        }
    }

    public function flush(Request $request)
    {
        abort(Response::HTTP_NOT_FOUND);
        $this->redis->flushDB(static function ($err, $result) {
            return $result;
        });
    }
}
