<?php

namespace App\Http\Controllers\Web;

use App\Block;
use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use App\Http\Resources\Block as BlockResource;
use App\Slideshow;
use App\Traits\MetaCommon;
use App\Websitesetting;
use Illuminate\Http\Request;

class ShopPageController extends Controller
{
    use MetaCommon;

    protected $setting;

    public function __construct(Websitesetting $setting)
    {
        $this->setting = $setting->setting;
    }

    public function __invoke(Request $request)
    {

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags($this->setting->site->seo->homepage->metaTitle,
            $this->setting->site->seo->homepage->metaDescription, $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        if (request()->expectsJson()) {
            $slides         = Slideshow::getShopBanner();
            $blocks         = Block::getShopBlocksForApp();
            $numberOfBlocks = $blocks->count();
            return response()->json([
                'mainBanner' => $slides->isNotEmpty() ? $slides : null,
                'block'      => [
                    'current_page'   => 1,
                    'data'           => BlockResource::collection($blocks),
                    'first_page_url' => null,
                    'from'           => 1,
                    'last_page'      => 1,
                    'last_page_url'  => null,
                    'next_page_url'  => null,
                    'path'           => $url,
                    'per_page'       => $numberOfBlocks + 1,
                    'prev_page_url'  => null,
                    'to'             => $numberOfBlocks,
                    'total'          => $numberOfBlocks,
                ],
            ]);
        }

        $blocks = Block::getShopBlocks();
        $slideBlock          = $blocks[1];
        $banners             = $blocks[1]->banners->sortBy('order');
        $slideBlock->banners = $banners->values();
        $blocks->pull(1);
        $blocks = $blocks->values();

        $pageName = "shop";
        return view('pages.shop', compact('pageName', 'blocks', 'slideBlock'));
    }
}
