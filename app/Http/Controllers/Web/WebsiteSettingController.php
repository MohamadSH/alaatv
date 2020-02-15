<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditWebsiteFaqRequest;
use App\Traits\RequestCommon;
use App\Websitesetting;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    use RequestCommon;

    function __construct()
    {
        $this->middleware('permission:' . config('constants.LIST_SITE_CONFIG_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_SITE_CONFIG_ACCESS'), [
            'only' => [
                'create',
                'store',
            ],
        ]);
        $this->middleware('permission:' . config('constants.REMOVE_SITE_CONFIG_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.EDIT_SITE_CONFIG_ACCESS'), [
            'only' => [
                'edit',
                'update',
            ],
        ]);
        $this->middleware('permission:' . config('constants.SHOW_SITE_CONFIG_ACCESS'), ['only' => 'show']);
        $this->middleware('permission:' . config('constants.SHOW_SITE_FAQ_ACCESS'), ['only' => 'showFaq']);
        $this->middleware('permission:' . config('constants.EDIT_SITE_FAQ_ACCESS'), ['only' => 'editFaq', 'updateFaq', 'destroyFaq']);
    }

    public function show(Websitesetting $setting)
    {
        return view('admin.siteConfiguration.websiteSetting');
    }

    public function showFaq(Websitesetting $setting)
    {
        $faqs = $setting->faq;

        return view('admin.siteConfiguration.FAQ.faq', compact('faqs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request        $request
     * @param Websitesetting $setting
     *
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function update(Request $request, Websitesetting $setting)
    {
        $wSetting = json_decode($setting)->setting;

        $wSetting->site->name                           = $request->get("siteName");
        $wSetting->site->titleBar                       = $request->get("titleBar");
        $wSetting->site->companyName                    = $request->get("siteCompanyName");
        $wSetting->site->footer                         = $request->get("siteFooter");
        $wSetting->site->rules                          = $request->get("siteRules");
        $wSetting->site->seo->homepage->metaTitle       = $request->get("homeMetaTitle");
        $wSetting->site->seo->homepage->metaKeywords    = $request->get("homeMetaKeywords");
        $wSetting->site->seo->homepage->metaDescription = $request->get("homeMetaDescription");

        $wSetting->branches->main->displayName              = $request->get("branchesName");
        $wSetting->branches->main->address->city            = $request->get("addressCity");
        $wSetting->branches->main->address->street          = $request->get("addressStreet");
        $wSetting->branches->main->address->avenue          = $request->get("addressAvenue");
        $wSetting->branches->main->address->extra           = $request->get("addressExtra");
        $wSetting->branches->main->address->plateNumber     = $request->get("addressPlateNumber");
        $wSetting->branches->main->contacts[0]->number      = $request->get("branchesContactsNumber")[0];
        $wSetting->branches->main->contacts[0]->description = $request->get("branchesContactsDescription")[0];
        $wSetting->branches->main->contacts[1]->number               = $request->get("branchesContactsNumber")[1];
        $wSetting->branches->main->contacts[1]->description          = $request->get("branchesContactsDescription")[1];
        $wSetting->branches->main->emergencyContacts[0]->number      =
            $request->get("branchesEmergencyContactsNumber")[0];
        $wSetting->branches->main->emergencyContacts[0]->description =
            $request->get("branchesEmergencyContactsDescription")[0];
        $wSetting->branches->main->emails[0]->address                = $request->get("branchesEmails");

        //        $wSetting->socialNetwork->telegram[0]->name = $request->get("telegramName");
        $wSetting->socialNetwork->telegram->channel->link  = $request->get("telegramLink");
        $wSetting->socialNetwork->telegram->channel->admin = $request->get("telegramAdmin");
        //        $wSetting->socialNetwork->instagram[0]->link = $request->get("instagramLink");
        //        $wSetting->socialNetwork->facebook[0]->link = $request->get("facebookLink");
        //        $wSetting->socialNetwork->twitter[0]->link = $request->get("twitterLink");
        //        $wSetting->socialNetwork->googleplus[0]->link = $request->get("googleplusLink");
        //        $wSetting->socialNetwork->telegram[0]->enable = 1;

        if ($request->hasFile("favicon")) {
            $oldLogo   = $wSetting->site->favicon;
            $file      = $request->file('favicon');
            $extension = $file->getClientOriginalExtension();
            $fileName  =
                basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(config('constants.DISK11'))
                ->put($fileName, File::get($file))) {
                Storage::disk(config('constants.DISK11'))
                    ->delete($oldLogo);
                $wSetting->site->favicon = $fileName;
            }
        }
        if ($request->hasFile("siteLogo")) {
            $oldLogo   = $wSetting->site->siteLogo;
            $file      = $request->file('siteLogo');
            $extension = $file->getClientOriginalExtension();
            $fileName  =
                basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(config('constants.DISK11'))
                ->put($fileName, File::get($file))) {
                Storage::disk(config('constants.DISK11'))
                    ->delete($oldLogo);
                $wSetting->site->siteLogo = $fileName;
            }
        }
        $setting->setting                                            = json_encode($wSetting, JSON_UNESCAPED_UNICODE);
        if ($setting->update()) {
            session()->put("success", "تنظیمات سایت با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect()->back();
    }

    public function editFaq(Request $request, Websitesetting $setting, $settingId, $faqId)
    {
        $faqs   = $setting->faq;
        $faqKey = array_search($faqId, array_column($faqs, 'id'));
        if ($faqKey === false) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $faq = $faqs[$faqKey];
        return view('admin.siteConfiguration.FAQ.edit', compact('faq'));
    }

    public function updateFaq(EditWebsiteFaqRequest $request, Websitesetting $setting)
    {
        $photo = $this->storeFAQPhoto($request);

        $faqs = $setting->faq;
        $faqId = $request->get('faq_id');
        if (isset($faqId)) {
            [$faqKey, $faq] = $setting->findFAQ($faqId);
            $faq           = Websitesetting::fillFAQ($faq, [
                'title' => $request->get('title'),
                'body'  => $request->get('body'),
                'photo' => isset($photo) ? $photo : $faq->photo,
                'video' => $request->get('video'),
                'order' => $request->get('order', 0),
            ]);
            $faqs[$faqKey] = $faq;
        } else {
            $faq = Websitesetting::createFAQ([
                'id'    => $setting->getLastFaqId() + 1,
                'title' => $request->get('title'),
                'body'  => $request->get('body'),
                'photo' => $photo,
                'video' => $request->get('video'),
                'order' => $request->get('order', 0),
            ]);

            $faqs[] = $faq;
        }
        $updateFaq = $setting->update(['faq' => $faqs]);

        if ($updateFaq) {
            Cache::tags(['websiteSetting', 'websiteSetting_' . $setting->id])->flush();
            session()->put('success', 'سؤال با موفقیت ذخیره شد');
        } else {
            session()->put('error', 'خطای پایگاه داده در ذخیره سؤال');

        }

        return redirect()->back();
    }

    public function destroyFaq(Request $request, Websitesetting $setting, $settingId, $faqId)
    {
        $faqs   = $setting->faq;
        $faqKey = array_search($faqId, array_column($faqs, 'id'));
        if ($faqKey === false) {
            return response()->json([
                'message' => 'No FAQ found',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        unset($faqs[$faqKey]);
        $faqs = array_values($faqs);

        $updateFaq = $setting->update(['faq' => $faqs]);

        if ($updateFaq) {
            Cache::tags(['websiteSetting', 'websiteSetting_' . $setting->id])->flush();
            $responseStatus = Response::HTTP_OK;
            $responseText   = 'سؤال متداول با موفقیت حذف شد';
        } else {
            $responseStatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseText   = 'خطای پایگاه داده';
        }

        return response()->json([
            'message' => $responseText,
        ], $responseStatus);
    }

    /**
     * @param EditWebsiteFaqRequest $request
     *
     * @return string
     * @throws FileNotFoundException
     */
    private function storeFAQPhoto(EditWebsiteFaqRequest $request): ?string
    {
        $file = $this->getRequestFile($request->all(), 'photo');
        if ($file !== false) {
            $extension = $file->getClientOriginalExtension();
            $fileName  =
                basename($file->getClientOriginalName(), '.' . $extension) . '_' . date('YmdHis') . '.' . $extension;
            $disk      = Storage::disk(config('constants.DISK29'));
            if ($disk->put($fileName, File::get($file))) {
                $photo = 'upload/images/faq/' . $fileName;
            }
        }
        return isset($photo) ? $photo : null;
    }
}
