<?php

namespace App\Http\Controllers\Web;

use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use App\Traits\MetaCommon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FAQPageController extends Controller
{
    use MetaCommon;

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        $setting = alaaSetting();
        $url   = $request->url();
        $title = "آلاء|سؤالات متداول";
        $this->generateSeoMetaTags(new SeoDummyTags($title, 'سؤالات متداول دانش آموزان کنکوری آلاء', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $setting->setting->site->siteLogo,
            ]), '100', '100', null));
        $faqs = $setting->faq;
        return view('pages.faq', compact('faqs'));
    }
}
