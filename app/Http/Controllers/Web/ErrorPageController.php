<?php

namespace App\Http\Controllers\Web;

use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use App\Traits\MetaCommon;
use App\Websitesetting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class ErrorPageController extends Controller
{
    use MetaCommon;

    private $setting;

    public function __construct(Websitesetting $setting)
    {
        $this->setting = $setting->setting;
    }

    /**
     * Show the not found page.
     *
     * @param Request $request
     *
     * @return void
     */
    public function error404(Request $request)
    {
        $url   = $request->url();
        $title = "آلاء|یافت نشد";
        $this->generateSeoMetaTags(new SeoDummyTags($title, 'صفحه یافت نشد', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));
        return abort(Response::HTTP_NOT_FOUND);
    }

    /**
     * Show forbidden page.
     *
     * @param Request $request
     *
     * @return void
     */
    public function error403(Request $request)
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
        return abort(Response::HTTP_FORBIDDEN);
    }

    /**
     * Show general error page.
     *
     * @param Request $request
     *
     * @return void
     */
    public function error500(Request $request)
    {
        $url   = $request->url();
        $title = "آلاء|دسترسی غیرمجاز";
        $this->generateSeoMetaTags(new SeoDummyTags($title, 'دسترسی غیر مجاز', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Show the general error page.
     *
     * @param string $message
     *
     * @return Factory|View
     */
    public function errorPage($message)
    {
        //        $message = $request->get("message");
        if (strlen($message) <= 0) {
            $message = '';
        }

        return view('errors.errorPage', compact('message'));
    }
}
