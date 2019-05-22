<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SlideShowController extends Controller
{
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
        //        $websitepage = "";
        //        if($request->has("websitepage_id"))
        //            $websitepage = Websitepage::all()->where("id" , $request->get("websitepage_id"))->first()->url;
        //
        //        switch ($websitepage)
        //        {
        //            case "/home":
        //                $diskName = config('constants.DISK9');
        //                break;
        //            case "/لیست-مقالات":
        //                $diskName = config('constants.DISK13');
        //                break;
        //            default :
        //                $diskName = config('constants.DISK9');
        //                break;
        //        }
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
            
            if (Storage::disk(config('constants.DISK9'))
                ->put($fileName, File::get($file))) {
                $slide->photo = $fileName;
            }
            else {
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
        $slideWebsitePage = $slide->websitepage->url;
        switch ($slideWebsitePage) {
            case "/home":
                $slideDisk   = 9;
                $previousUrl = action("Web\AdminController@adminSlideShow");
                break;
            //            case "/لیست-مقالات":
            //                $slideDisk = 13 ;
            //                $previousUrl = action("Web\AdminController@adminArticleSlideShow");
            //                break;
            default:
                break;
        }
        $slideWebsitepageId = $slide->websitepage->id;
    
    
        $websitePages = [
            'صفحه یک',
            'صفحه دو',
            'صفحه سه',
            'صفحه چهار'
        ];
        
        return view("slideShow.edit", compact('slide', 'slideDisk', 'slideWebsitepageId', 'previousUrl', 'websitePages'));
    }

    public function update(Request $request, $slide)
    {
        //        $websitepage = "";
        //        if($request->has("websitepage_id"))
        //            $websitepage = Websitepage::all()->where("id" , $request->get("websitepage_id"))->first()->url;
        //
        //        switch ($websitepage)
        //        {
        //            case "/home":
        //                $diskName = config('constants.DISK9');
        //                break;
        //            case "/لیست-مقالات":
        //                $diskName = config('constants.DISK13');
        //                break;
        //            default :
        //                $diskName = config('constants.DISK9');
        //                break;
        //        }
        
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
            
            if (Storage::disk(config('constants.DISK9'))
                ->put($fileName, File::get($file))) {
                Storage::disk(config('constants.DISK9'))
                    ->delete($oldPhoto);
                $slide->photo = $fileName;
            }
            else {
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
