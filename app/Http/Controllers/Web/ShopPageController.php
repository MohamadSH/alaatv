<?php

namespace App\Http\Controllers\Web;
use App\Block;
use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use App\Slideshow;
use App\Traits\MetaCommon;
use App\Websitesetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShopPageController extends Controller
{
    use MetaCommon;
    protected $response;

    /**
     * PHP 5 allows developers to declare constructor methods for classes.
     * Classes which have a constructor method call this method on each newly-created object,
     * so it is suitable for any initialization that the object may need before it is used.
     *
     * Note: Parent constructors are not called implicitly if the child class defines a constructor.
     * In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.
     *
     * param [ mixed $args [, $... ]]
     * @link https://php.net/manual/en/language.oop5.decon.php
     * @param Response $response
     * @param Websitesetting $setting
     */
    public function __construct(Response $response, Websitesetting $setting)
    {
        $this->setting = $setting->setting;
        $this->response = $response;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $blocks = Block::getShopBlocks();
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags($this->setting->site->seo->homepage->metaTitle, $this->setting->site->seo->homepage->metaDescription, $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));

        //$slides = collect();
        $slides = Slideshow::getShopBanner();
        if (request()->expectsJson()) {
            return $this->response
                ->setStatusCode(Response::HTTP_OK)
                ->setContent([
                    'mainBanner' => $slides ,
                    'block'   => [
                        'current_page'   => 1,
                        'data'           => $blocks,
                        'first_page_url' => null,
                        'from'           => 1,
                        'last_page'      => 1,
                        'last_page_url'  => null,
                        'next_page_url'  => null,
                        'path'           => $url,
                        'per_page'       => $blocks->count() + 1,
                        'prev_page_url'  => null,
                        'to'             => $blocks->count(),
                        'total'          => $blocks->count(),
                    ]
                ]);
        }
        $pageName = "shop";
//        dd($blocks,$slides);
//        dd($blocks->first()->products);
        return view('pages.shop', compact(
            'pageName',
            'blocks',
            'slides'
        ));
    }
}
