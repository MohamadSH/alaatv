<?php

namespace App\Http\Controllers\Web;

use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use App\Traits\MetaCommon;
use App\Websitesetting;
use Illuminate\Http\Request;

class RulesPageController extends Controller
{
    use MetaCommon;

    private $setting;

    public function __construct(Websitesetting $setting)
    {
        $this->setting = $setting->setting;
    }

    public function __invoke(Request $request)
    {
        $url   = $request->url();
        $title = "آلاء|قوانین";
        $this->generateSeoMetaTags(new SeoDummyTags($title, 'قوانین سایت آلاء', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        return view("pages.rules");
    }
}
