<?php

namespace App\Http\Controllers;

use App\Content;
use App\Product;
use Watson\Sitemap\Facades\Sitemap;

class SitemapController extends Controller
{
    public function index()
    {
        // You can use the route helpers too.
        Sitemap::addSitemap(action('SitemapController@products'));

        Sitemap::addSitemap(action('SitemapController@eContents'));

        // Return the sitemap to the client.
        return Sitemap::index();
    }

    public function products()
    {
        $products = Product::getProducts(0, 1)->orderBy("order")->get();
        foreach ($products as $product) {
            Sitemap::addTag(route('product.show', $product), $product->updated_at, 'monthly', '0.8');
        }
        $products = Product::getProducts(1, 1)->orderBy("order")->get();
        foreach ($products as $product) {
            Sitemap::addTag(route('product.show', $product), $product->updated_at, 'monthly', '0.8');
        }
        return Sitemap::render();
    }

    public function eContents()
    {
        $contents = Content::select()
            ->active()
            ->orderBy("created_at", "desc")
            ->get();
        $contents->load('files');
        foreach ($contents as $content) {
            $caption = $content->display_name;
            $image = $content->files->where("pivot.label", "thumbnail")->first();
            $tag = Sitemap::addTag(route('c.show', $content), $content->updated_at, 'monthly', '0.9');
            if (isset($image)) {
                $tag->addImage($image->name, $caption);
            }
        }

        return Sitemap::render();
    }
}
