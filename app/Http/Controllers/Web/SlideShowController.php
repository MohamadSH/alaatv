<?php

namespace App\Http\Controllers\Web;

use App\Adapter\AlaaSftpAdapter;
use App\Http\Controllers\Controller;
use App\Repositories\WebsitePageRepo;
use App\Slideshow;
use App\Traits\FileCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SlideShowController extends Controller
{
    use FileCommon;

    function __construct()
    {
        $this->middleware('permission:'.config('constants.LIST_SLIDESHOW_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_SLIDESHOW_ACCESS'), [
            'only' => 'create',
            'store',
        ]);
        $this->middleware('permission:'.config('constants.EDIT_SLIDESHOW_ACCESS'), [
            'only' => 'update',
            'edit',
        ]);
        $this->middleware('permission:'.config('constants.REMOVE_SLIDESHOW_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.SHOW_SLIDESHOW_ACCESS'), ['only' => 'show']);
    }

    public function index()
    {
        $slides = Slideshow::all()
            ->sortBy("order");
        
        return $slides;
    }

    public function store(Request $request)
    {
        $slide = new Slideshow();
        $slide->fill($request->all());
        
        if (strlen($slide->order) == 0) {
            $slide->order = 0;
        }
        
        if (strlen($slide->link) == 0) {
            $slide->link = null;
        }
        else {
            if (isset($slide->link)) {
                if (strcmp($slide->link[0], "#") != 0) {
                    if (!preg_match("/^http:\/\//", $slide->link) && !preg_match("/^https:\/\//", $slide->link)) {
                        $slide->link = "https://".$slide->link;
                    }
                }
            }
        }
        
        if ($request->hasFile("photo")) {
            $file      = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;

            $disk = Storage::disk(config('constants.DISK22'));
            /** @var AlaaSftpAdapter $adaptor */
            $adaptor = $disk->getAdapter();
            if ($disk->put($fileName, File::get($file))) {
                $fullPath = $adaptor->getRoot();
                $partialPath = $this->getSubDirectoryInCDN($fullPath);
                $slide->photo = $partialPath.$fileName;
            }else{
                session()->put('error', 'بارگذاری عکس بسته با مشکل مواجه شد!');
            }
        }
        
        $isEnable = $request->get("isEnable");
        if (isset($isEnable)) {
            $slide->isEnable = 1;
        }
        else {
            $slide->isEnable = 0;
        }
        
        if ($slide->save()) {
            session()->put('success', 'اسلاید با موفقیت افزوده شد!');
        }
        else {
            session()->put('error', 'خطای پایگاه داده!');
        }
        
        return redirect()->back();
    }

    public function edit($slide)
    {
        $previousUrl = action("Web\AdminController@adminSlideShow");
        $slideWebsitepageId = $slide->websitepage->id;
        $slideDisk          = 9;
        $websitePages = WebsitePageRepo::getWebsitePages(
            ['url' => [
                '/home',
                '/shop',
            ]]
        )->pluck('displayName' , 'id');
        
        return view("slideShow.edit", compact('slide', 'slideDisk', 'slideWebsitepageId', 'previousUrl', 'websitePages'));
    }

    /**
     * @param Request $request
     * @param Slideshow $slide
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(Request $request, Slideshow $slide)
    {
        
        $oldPhoto = $slide->photo;
        $slide->fill($request->all());

        if (strlen($slide->order) == 0) {
            $slide->order = 0;
        }
        
        if (strlen($slide->link) == 0) {
            $slide->link = null;
        }
        else {
            if (isset($slide->link)) {
                if (strcmp($slide->link[0], "#") != 0) {
                    if (!preg_match("/^http:\/\//", $slide->link) && !preg_match("/^https:\/\//", $slide->link)) {
                        $slide->link = "https://".$slide->link;
                    }
                }
            }
        }
        
        if ($request->hasFile("photo")) {
            $file      = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;

            $disk = Storage::disk(config('constants.DISK22'));
            /** @var AlaaSftpAdapter $adaptor */
            $adaptor = $disk->getAdapter();
            if ($disk->put($fileName, File::get($file))) {
                $disk->delete($oldPhoto);

                $fullPath = $adaptor->getRoot();
                $partialPath = $this->getSubDirectoryInCDN($fullPath);
                $slide->photo = $partialPath.$fileName;
            }else{
                session()->put('error', 'بارگذاری عکس بسته با مشکل مواجه شد!');
            }

        }
        
        $isEnable = $request->get("isEnable");
        if (isset($isEnable)) {
            $slide->isEnable = 1;
        }
        else {
            $slide->isEnable = 0;
        }
        
        if ($slide->update()) {
            session()->put('success', 'اسلاید با موفقیت اصلاح شد!');
            session()->put('warning', 'کش را پاک کنید');
        }
        else {
            session()->put('error', 'خطای پایگاه داده!');
        }
        
        return redirect()->back();
    }

    public function destroy($slide)
    {
        if ($slide->delete()) {
            session()->put('success', 'اسلاید با موفقیت حذف شد!');
        }
        else {
            session()->put('error', 'خطای پایگاه داده!');
        }
        
        return response([
            'sessionData' => session()->all(),
        ]);
    }
}
