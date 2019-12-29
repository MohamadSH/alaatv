<?php

namespace App\Http\Controllers\Web;

use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use App\Traits\MetaCommon;
use App\Websitesetting;
use Illuminate\Http\Request;

class ContactUsController extends Controller
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
        $title = "آلاء|تماس با ما";
        $this->generateSeoMetaTags(new SeoDummyTags($title, $this->setting->site->seo->homepage->metaDescription, $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        $emergencyContacts = collect();
        foreach ($this->setting->branches->main->emergencyContacts as $emergencyContact) {
            $number = "";
            if (isset($emergencyContact->number) && strlen($emergencyContact->number) > 0) {
                $number = $emergencyContact->number;
            }

            $description = "";
            if (isset($emergencyContact->description) && strlen($emergencyContact->description) > 0) {
                $description = $emergencyContact->description;
            }

            if (strlen($number) > 0 || strlen($description) > 0) {
                $emergencyContacts->push([
                    "number"      => $number,
                    "description" => $description,
                ]);
            }
        }

        return view("pages.contactUs", compact("emergencyContacts"));
    }
}
