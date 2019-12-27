<?php

namespace App\Http\Controllers\Web;

use App\Content;
use App\Contentset;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\{Cache};
use Watson\Sitemap\Facades\Sitemap;

class SitemapController extends Controller
{
    public function index()
    {
        // You can use the route helpers too.
        Sitemap::addSitemap(action('Web\SitemapController@product'));
        Sitemap::addSitemap(action('Web\SitemapController@redirect'));


        $this->addContentsSiteMapUrl('video');
        $this->addSetsSiteMapUrl();
        $this->addContentsSiteMapUrl('pamphlet');
        $this->addContentsSiteMapUrl('article');

        // Return the sitemap to the client.
        return Sitemap::index();
    }

    private function addContentsSiteMapUrl($type): void
    {
        $paginate = $this->getContentByType($type);
        $lastPage = $paginate->lastPage();
        for ($i = 1; $i <= $lastPage; $i++) {
            if ($paginate->isNotEmpty()) {
                Sitemap::addSitemap(action([__CLASS__, $type], ['page' => $i]));
            }
        }
    }

    /**
     * @param $type
     * @param $page
     *
     * @return mixed
     */
    function getContentByType($type, $page = 1): LengthAwarePaginator
    {
        $key =
            'sitemap-contents/NotRedirected/' . $type . 'page/' . $this->getPageNameByContentType($type) . ':' . $page;
        return Cache::tags(['content'])
            ->remember($key, config('constants.CACHE_600'),
                function ()
                use ($type, $page) {
                    return Content::select()
                        ->free()
                        ->active()
                        ->$type()
                        ->notRedirected()
                        ->orderBy('id')
                        ->paginate(500, ['*'], $this->getPageNameByContentType($type), $page);
                });
    }

    /**
     * @param $type
     *
     * @return string
     */
    function getPageNameByContentType($type): string
    {
        return 'c-' . $type;
    }

    private function addSetsSiteMapUrl()
    {
        $paginate = $this->getSet();
        $lastPage = $paginate->lastPage();
        for ($i = 1; $i <= $lastPage; $i++) {
            if ($paginate->isNotEmpty()) {
                Sitemap::addSitemap(action([__CLASS__, 'set'], ['page' => $i]));
            }
        }
    }

    private function getSet(int $page = 1): LengthAwarePaginator
    {
        $key = 'sitemap-sets/NotRedirected/page/' . $page;
        return Cache::tags(['set'])
            ->remember($key, config('constants.CACHE_600'),
                function ()
                use ($page) {
                    return Contentset::select()
                        ->active()
                        ->notRedirected()
                        ->orderBy('id')
                        ->paginate(500, ['*'], 'set', $page);
                });
    }

    public function product()
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

    public function video($page = 1)
    {
        $contents = $this->getContentByType('video', $page);
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

    public function pamphlet($page = 1)
    {
        $contents = $this->getContentByType('pamphlet', $page);
        $this->addContentsTagLine($contents);
        return Sitemap::render();
    }

    public function article($page = 1)
    {
        $contents = $this->getContentByType('article', $page);
        $this->addContentsTagLine($contents);
        return Sitemap::render();
    }

    public function redirect()
    {
        $contents = Cache::tags(['content', 'product'])
            ->remember('sitemap-contents-redirected', config('constants.CACHE_600'), static
            function () {
                return Content::select()
                    ->free()
                    ->active()
                    ->redirected()
                    ->orderBy('created_at', 'desc')
                    ->get();
            });

        $this->addContentsTagLine($contents);

        return Sitemap::render();
    }

    public function set($page = 1)
    {
        $sets = $this->getSet($page);
        $this->addSetTagLine($sets);
        return Sitemap::render();
    }

    private function addSetTagLine(LengthAwarePaginator $sets): void
    {
        foreach ($sets as $set) {
            $caption = $set->metaTitle;
            $image   = $set->photo;
            $tag     = Sitemap::addTag(route('set.show', $set), $set->updated_at, 'daily', '0.9');
            if (isset($image)) {
                $tag->addImage($image, $caption);
            }
        }
    }
}
