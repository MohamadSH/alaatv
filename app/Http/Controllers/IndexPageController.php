<?php

namespace App\Http\Controllers;

use App\Block;
use App\Classes\Format\webBlockCollectionFormatter;
use App\Classes\Format\webSetCollectionFormatter;
use App\Classes\SEO\SeoDummyTags;
use App\Slideshow;
use App\Traits\MetaCommon;
use App\Websitesetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexPageController extends Controller
{

    use MetaCommon;
    private $setting;
    protected $response;

    public function __construct(Response $response, Websitesetting $setting)
    {
        $this->setting = $setting->setting;
        $this->response = $response;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $blocks = Block::getMainBlocks();
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags($this->setting->site->seo->homepage->metaTitle, $this->setting->site->seo->homepage->metaDescription, $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));

        $slides = Slideshow::getMainBanner();

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
        $sections = (new webBlockCollectionFormatter(new webSetCollectionFormatter()))->format($blocks);
        $pageName = "dashboard";
        return view('pages.dashboard1', compact(
            'pageName',
            'sections',
            'slides'
        ));
    }
}
