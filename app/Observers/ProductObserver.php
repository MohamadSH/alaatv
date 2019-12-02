<?php

namespace App\Observers;

use App\Classes\Search\TaggingInterface;
use App\Product;
use App\Traits\APIRequestCommon;
use App\Traits\TaggableTrait;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    private $tagging;

    use TaggableTrait;
    use APIRequestCommon;

    public function __construct(TaggingInterface $tagging)
    {
        $this->tagging = $tagging;
    }

    /**
     * Handle the product "created" event.
     *
     * @param  Product  $product
     *
     * @return void
     */
    public function created(Product $product)
    {

    }

    /**
     * Handle the product "updated" event.
     *
     * @param  Product  $product
     *
     * @return void
     */
    public function updated(Product $product)
    {
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  Product  $product
     *
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  Product  $product
     *
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  Product  $product
     *
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }

    /**
     * When issuing a mass update via Eloquent,
     * the saved and updated model events will not be fired for the updated models.
     * This is because the models are never actually retrieved when issuing a mass update.
     *
     * @param  Product  $product
     */
    public function saving(Product $product)
    {


    }

    public function saved(Product $product)
    {
        //todo
//        self::shiftProductOrders($product->order);

        $this->sendTagsOfTaggableToApi($product, $this->tagging);
        Cache::tags([
            'product_'.$product->id ,
            'product_search' ,
            'relatedProduct_search' ,
            'productCollection'])->flush();

        $this->setRelatedContentsTags($product , isset(optional($product->sample_contents)->tags)?optional($product->sample_contents)->tags:[] , Product::SAMPLE_CONTENTS_BUCKET);
        $this->setRelatedContentsTags($product , isset(optional($product->recommender_contents)->tags)?optional($product->recommender_contents)->tags:[], Product::RECOMMENDER_CONTENTS_BUCKET);
    }

    /**
     *
     *
     * @param  int  $order
     *
     * @return void
     */
    public static function shiftProductOrders($order): void
    {
        $productsWithSameOrder = Product::getProducts(0, 0)
            ->where("order", $order)
            ->get();
        foreach ($productsWithSameOrder as $productWithSameOrder) {
            $productWithSameOrder->order = $productWithSameOrder->order + 1;
            $productWithSameOrder->update();
        }
    }



    private function setRelatedContentsTags(Product $product , array $contentIds, string $bucket):bool
    {
        $itemTagsArray = [];
        foreach ($contentIds as $id) {
            $itemTagsArray[] = 'c-'.$id;
        }
        $params = [
            'tags' => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
        ];

        $response = $this->sendRequest(config('constants.TAG_API_URL')."id/$bucket/".$product->id, 'PUT', $params);
        return true;
    }
}
