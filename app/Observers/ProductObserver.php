<?php

namespace App\Observers;

use App\Classes\Search\TaggingInterface;
use App\Product;
use App\Traits\TaggableTrait;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    private $tagging;

    use TaggableTrait;

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
            'relatedProduct_search' ])->flush();
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


}
