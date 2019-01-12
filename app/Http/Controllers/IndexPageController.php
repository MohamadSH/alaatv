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

class IndexPageController extends Controller
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
        return Block::getBlocks();
        $sections = (new webBlockCollectionFormatter(new webSetCollectionFormatter()))->format(Block::getBlocks());
dd($sections);
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags($this->setting->site->seo->homepage->metaTitle, $this->setting->site->seo->homepage->metaDescription, $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));


        $slides = Slideshow::getMainBanner();
        $slideCounter = 1;
        $slideDisk = 9;

        $pageName = "dashboard";
        return view('pages.dashboard1', compact(
            'pageName',
            'slides',
            'slideCounter',
            'slideDisk'
        ));
    }
}
