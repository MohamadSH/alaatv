<?php


namespace App\Classes;


use App\Traits\APIRequestCommon;
use Illuminate\Http\Response;
use stdClass;

class RecommendedItemsFetcher
{
    use APIRequestCommon;

    const ITEM_TYPE_CONTENT = 'content';
    const ITEM_TYPE_PRODUCT = 'product';
    const ITEM_TYPE_SET = 'set';

    protected $tags;

    /**
     * RecommendedItemsGenerator constructor.
     *
     * @param $tags
     */
    public function __construct($tags)
    {
        $this->tags = $tags;
    }


    public function fetch(): array
    {
        $fetchedRecommendedItems = $this->getRecommendedItems($this->tags);
        $products                = $this->getRecommendedProducts($fetchedRecommendedItems);
        $sets                    = $this->getRecommendedSets($fetchedRecommendedItems);
        $videos                  = $this->getRecommendedVideos($fetchedRecommendedItems);

        $this->prepareRecommendedProducts($products);
        $this->prepareRecommendedSets($sets);
        $this->prepareRecommendedVideos($videos);

        return array_merge($products, $videos, $sets);
    }


    private function getRecommendedItems(array $tags): stdClass
    {
        $result = $this->sendRequest(route('api.v2.search'), 'GET', ['tags' => $tags], [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
        ]);

        if ($result['statusCode'] != Response::HTTP_OK) {
            return new stdClass();
        }

        return json_decode($result['result'])->data;
    }

    private function getRecommendedProducts($result): array
    {
        return optional(optional($result)->products)->data ?? [];
    }

    private function getRecommendedSets($result): array
    {
        return optional(optional($result)->sets)->data ?? [];
    }

    private function getRecommendedVideos($result): array
    {
        return optional(optional($result)->videos)->data ?? [];
    }

    private function prepareRecommendedProducts(array &$products): void
    {
        array_walk($products, function (&$val) {
            $val->item_type = self::ITEM_TYPE_PRODUCT;
        });
    }

    private function prepareRecommendedSets(array &$sets): void
    {
        array_walk($sets, function (&$val) {
            $val->item_type = self::ITEM_TYPE_SET;
        });
        if (count($sets) >= 2) {
            $sets = array_slice($sets, 0, 2);
        }
    }

    private function prepareRecommendedVideos(array &$videos): void
    {
        array_walk($videos, function (&$val) {
            $val->item_type = self::ITEM_TYPE_CONTENT;
        });
        if (count($videos) >= 2) {
            $videos = array_slice($videos, 0, 2);
        }
    }
}
