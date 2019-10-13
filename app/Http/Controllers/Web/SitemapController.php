<?php

namespace App\Http\Controllers\Web;

use App\Content;
use App\Product;
use Illuminate\Support\Facades\{Cache};
use Watson\Sitemap\Facades\Sitemap;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        // You can use the route helpers too.
        Sitemap::addSitemap(action('Web\SitemapController@products'));
    
        Sitemap::addSitemap(action('Web\SitemapController@contents'));
    
        Sitemap::addSitemap(action('Web\SitemapController@redirects'));
        
        // Return the sitemap to the client.
        return Sitemap::index();
    }
    
    public function products()
    {
        $products = Cache::tags(['product'])
            ->remember('sitemap-products-1', config('constants.CACHE_600'), static
            function () {
                return Product::getProducts(0, 1)
                    ->orderBy('order')
                    ->get();
            });
        
        foreach ($products as $product) {
            Sitemap::addTag(route('product.show', $product), $product->updated_at, 'monthly', '0.8');
        }
    
        $products = Cache::tags(['product'])
            ->remember('sitemap-products-2', config('constants.CACHE_600'), static
            function () {
                return Product::getProducts(1, 1)
                    ->orderBy('order')
                    ->get();
            });
        
        foreach ($products as $product) {
            Sitemap::addTag(route('product.show', $product), $product->updated_at, 'monthly', '0.8');
        }
        
        return Sitemap::render();
    }
    
    public function contents()
    {
    
        $contents = Cache::tags(['content'])
            ->remember('sitemap-contents', config('constants.CACHE_600'), static
            function () {
                return Content::select()
                    ->active()
                    ->redirected()
                    ->orderBy('created_at', 'desc')
                    ->get();
            });
    
        $this->addContentsTagLine($contents);
        
        return Sitemap::render();
    }
    
    public function redirects()
    {
        $contents = Cache::tags(['content', 'product'])
            ->remember('sitemap', config('constants.CACHE_600'), static
            function () {
                return Content::select()
                    ->active()
                    ->redirected(true)
                    ->orderBy('created_at', 'desc')
                    ->get();
            });
        
        $this->addContentsTagLine($contents);
        
        return Sitemap::render();
    }
    
    /**
     * @param $contents
     */
    private function addContentsTagLine($contents): void
    {
        foreach ($contents as $content) {
            $caption = $content->metaTitle;
            $image   = $content->thumbnail;
            $tag     = Sitemap::addTag(route('c.show', $content), $content->updated_at, 'monthly', '0.9');
            if (isset($image)) {
                $tag->addImage($image, $caption);
            }
        }
    }
}
