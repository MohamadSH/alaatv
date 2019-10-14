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
    
        Sitemap::addSitemap(action('Web\SitemapController@videos'));
        Sitemap::addSitemap(action('Web\SitemapController@articles'));
        Sitemap::addSitemap(action('Web\SitemapController@pamphlets'));
    
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
    
    public function videos()
    {
        $contents = $this->getContentByType('video');
        $this->addContentsTagLine($contents);
        return Sitemap::render();
    }
    
    public function pamphlets()
    {
        $contents = $this->getContentByType('pamphlet');
        $this->addContentsTagLine($contents);
        return Sitemap::render();
    }
    
    public function articles()
    {
        $contents = $this->getContentByType('article');
        $this->addContentsTagLine($contents);
        return Sitemap::render();
    }
    
    /**
     * @return mixed
     */
    function getContentByType($type)
    {
        return Cache::tags(['content'])
            ->remember('sitemap-contents/'.$type, config('constants.CACHE_600'), static function () use ($type) {
                return Content::select()
                    ->free()
                    ->active()
                    ->$type()
                    ->redirected()
                    ->orderBy('created_at', 'desc')
                    ->get();
            });
    }
    
    public function redirects()
    {
        $contents = Cache::tags(['content', 'product'])
            ->remember('sitemap-contents-redirected', config('constants.CACHE_600'), static
            function () {
                return Content::select()
                    ->free()
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
