<?php

namespace App\Http\Controllers;

use App\Slideshow;
use App\Websitepage;
use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SlideShowController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:'.Config::get('constants.LIST_SLIDESHOW_ACCESS'),['only'=>'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_SLIDESHOW_ACCESS'),['only'=>'create' , 'store']);
        $this->middleware('permission:'.Config::get('constants.EDIT_SLIDESHOW_ACCESS'),['only'=>'update' , 'edit']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_SLIDESHOW_ACCESS'),['only'=>'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_SLIDESHOW_ACCESS'),['only'=>'show' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides  = Slideshow::all()->sortBy("order");
        return $slides;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $websitepage = "";
//        if($request->has("websitepage_id"))
//            $websitepage = Websitepage::all()->where("id" , $request->get("websitepage_id"))->first()->url;
//
//        switch ($websitepage)
//        {
//            case "/home":
//                $diskName = Config::get('constants.DISK9');
//                break;
//            case "/لیست-مقالات":
//                $diskName = Config::get('constants.DISK13');
//                break;
//            default :
//                $diskName = Config::get('constants.DISK9');
//                break;
//        }
        $slide = new Slideshow();
        $slide->fill($request->all());

        if(strlen($slide->order)==0) $slide->order = 0;

        if(strlen($slide->link)==0)
            $slide->link = null;
        elseif(isset($slide->link))
        {
            if(strcmp($slide->link[0], "#") !=0 )
                if(!preg_match("/^http:\/\//",$slide->link) && !preg_match("/^https:\/\//", $slide->link) )
                $slide->link = "https://".$slide->link;
        }

        if ($request->hasFile("photo")) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName() , ".".$extension) . "_" . date("YmdHis") . '.' . $extension;

            if (Storage::disk(Config::get('constants.DISK9'))->put($fileName, File::get($file))) {
                $slide->photo = $fileName;
            } else {
                session()->put('error', 'بارگذاری عکس بسته با مشکل مواجه شد!');
            }
        }

        $isEnable= $request->get("isEnable");
    if(isset($isEnable)) $slide->isEnable = 1;
        else $slide->isEnable  = 0;

        if($slide->save()) session()->put('success', 'اسلاید با موفقیت افزوده شد!');
        else session()->put('error', 'خطای پایگاه داده!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slideshow $slide
     * @return \Illuminate\Http\Response
     */
    public function edit($slide)
    {
        $slideWebsitePage = $slide->websitepage->url ;
        switch ($slideWebsitePage)
        {
            case "/home":
                $slideDisk = 9;
                $previousUrl = action("HomeController@adminSlideShow");
                break;
//            case "/لیست-مقالات":
//                $slideDisk = 13 ;
//                $previousUrl = action("HomeController@adminArticleSlideShow");
//                break;
            default:
                break;
        }
        $slideWebsitepageId = $slide->websitepage->id;
        return view("slideShow.edit", compact('slide' , 'slideDisk' , 'slideWebsitepageId' , 'previousUrl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slideshow $slide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slide)
    {
//        $websitepage = "";
//        if($request->has("websitepage_id"))
//            $websitepage = Websitepage::all()->where("id" , $request->get("websitepage_id"))->first()->url;
//
//        switch ($websitepage)
//        {
//            case "/home":
//                $diskName = Config::get('constants.DISK9');
//                break;
//            case "/لیست-مقالات":
//                $diskName = Config::get('constants.DISK13');
//                break;
//            default :
//                $diskName = Config::get('constants.DISK9');
//                break;
//        }

        $oldPhoto = $slide->photo;

        $slide->fill($request->all());

        if(strlen($slide->order)==0) $slide->order = 0;

        if(strlen($slide->link)==0)
            $slide->link = null;
        elseif(isset($slide->link))
        {
            if(strcmp($slide->link[0], "#")!=0)
                if(!preg_match("/^http:\/\//",$slide->link) && !preg_match("/^https:\/\//", $slide->link))
                    $slide->link = "https://".$slide->link;
        }

        if ($request->hasFile("photo")) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName() , ".".$extension) . "_" . date("YmdHis") . '.' . $extension;

            if (Storage::disk(Config::get('constants.DISK9'))->put($fileName, File::get($file))) {
                Storage::disk(Config::get('constants.DISK9'))->delete($oldPhoto);
                $slide->photo = $fileName;
            } else {
                session()->put('error', 'بارگذاری عکس بسته با مشکل مواجه شد!');
            }
        }

        $isEnable= $request->get("isEnable");
        if(isset($isEnable)) $slide->isEnable = 1;
        else $slide->isEnable  = 0;

        if($slide->update()) session()->put('success', 'اسلاید با موفقیت اصلاح شد!');
        else session()->put('error', 'خطای پایگاه داده!');
        return redirect()->back() ;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slideshow $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy($slide)
    {
        if ($slide->delete()) session()->put('success', 'اسلاید با موفقیت حذف شد!');
        else session()->put('error', 'خطای پایگاه داده!');
        return response([
            'sessionData' => session()->all()
        ]);
    }
}
