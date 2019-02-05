<?php

namespace App\Http\Controllers;

use App\Classes\SEO\SeoDummyTags;
use App\Product;
use App\Traits\MetaCommon;
use App\Websitesetting;
use Illuminate\Http\Request;

class SiteMapWebController extends Controller
{
    use MetaCommon;
    private $setting;

    public function __construct(Websitesetting $setting)
    {
        $this->setting = $setting->setting;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $url = $request->url();
        $title = 'آلاء|نقشه سایت';
        $this->generateSeoMetaTags(new SeoDummyTags($title, $this->setting->site->seo->homepage->metaDescription, $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));

        $products = Product::getProducts(0, 1)
                           ->orderBy("order")
                           ->get();
        //        $articlecategories = Articlecategory::where('enable', 1)->orderBy('order')->get();
        //        $articlesWithoutCategory = Article::where('articlecategory_id', null)->get();
        return view("pages.siteMap", compact('products', 'articlecategories', 'articlesWithoutCategory'));
    }
}
