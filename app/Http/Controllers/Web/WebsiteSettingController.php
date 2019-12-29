<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Websitesetting;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
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
    }

    public function show(Websitesetting $setting)
    {
        $sideBarMode = "closed";

        return view("admin.siteConfiguration.websiteSetting", compact('sideBarMode'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request                    $request
     * @param                            $setting
     *
     * @return Response
     * @throws FileNotFoundException
     */
    public function update(Request $request, $setting)
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

        $wSetting->branches->main->displayName                       = $request->get("branchesName");
        $wSetting->branches->main->address->city                     = $request->get("addressCity");
        $wSetting->branches->main->address->street                   = $request->get("addressStreet");
        $wSetting->branches->main->address->avenue                   = $request->get("addressAvenue");
        $wSetting->branches->main->address->extra                    = $request->get("addressExtra");
        $wSetting->branches->main->address->plateNumber              = $request->get("addressPlateNumber");
        $wSetting->branches->main->contacts[0]->number               = $request->get("branchesContactsNumber")[0];
        $wSetting->branches->main->contacts[0]->description          = $request->get("branchesContactsDescription")[0];
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
        $setting->setting = json_encode($wSetting, JSON_UNESCAPED_UNICODE);
        if ($setting->update()) {
            session()->put("success", "تنظیمات سایت با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect()->back();
    }
}
