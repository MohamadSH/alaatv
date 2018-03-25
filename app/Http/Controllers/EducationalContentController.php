<?php

namespace App\Http\Controllers;

use App\Contenttype;
use App\Educationalcontent;
use App\Grade;
use App\Http\Requests\EditEducationalContentRequest;
use App\Http\Requests\InsertEducationalContentFileCaption;
use App\Http\Requests\InsertEducationalContentRequest;
use App\Http\Requests\InsertFileRequest;
use App\Major;
use App\Majortype;
use App\Product;
use App\Traits\ProductCommon;
use App\Websitesetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Auth;
use Jenssegers\Agent\Agent;
use SSH;
use Meta;

class EducationalContentController extends Controller
{
    protected $response ;

    use ProductCommon ;

    public function __construct()
    {
        $agent = new Agent();
        if ($agent->isRobot())
        {
            $authException = ["index" , "show" , "search"  ];
        }else{
            $authException = ["index" , "show" ,"search"  ];
        }
        $this->middleware('auth', ['except' => $authException]);

        $this->middleware('permission:'.Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'),['only'=>['store' , 'create' , 'create2']]);
        $this->middleware('permission:'.Config::get("constants.EDIT_EDUCATIONAL_CONTENT"),['only'=>['update' , 'edit']]);
        $this->middleware('permission:'.Config::get("constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS"),['only'=>'destroy']);

        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Input::has("controlPanel")){
            if(Auth::check()&& Auth::user()->can(Config::get('constants.LIST_EDUCATIONAL_CONTENT_ACCESS')))
                $educationalContents = Educationalcontent::orderby("created_at" , "DESC");
            else abort(403) ;
        }
        else
            $educationalContents = Educationalcontent::enable()->valid()->orderBy("validSince","DESC");

        if(Input::has("searchText"))
        {
            $text = Input::get("searchText");
            if(strlen(preg_replace('/\s+/', '', $text)) >0)
            {
                $words = explode(" " , $text);
                $educationalContents = $educationalContents->where(function ($q) use ($words) {
                foreach ($words as $word)
                {
                    $q->orwhere('name', 'like', '%' . $word . '%')->orWhere('description', 'like', '%' . $word . '%');
                }

                });
            }
        }

        if(Input::has("majors"))
        {
            $majorsId = Input::get("majors");
            if(!in_array(  0 , $majorsId))
                $educationalContents = $educationalContents->whereHas("majors" , function ($q) use ($majorsId){
                    $q->whereIn("id" , $majorsId);
                });
        }

        if(Input::has("grades"))
        {
            $gradesId = Input::get("grades");
            if(!in_array(  0 , $gradesId))
                $educationalContents = $educationalContents->whereHas("grades", function ($q) use ($gradesId) {
                    $q->whereIn("id", $gradesId);
                });
        }

        if(Input::has("rootContenttypes"))
        {
            $contentTypes = Input::get("rootContenttypes");
            if(!in_array(0 , $contentTypes))
            {
                if(Input::has("childContenttypes"))
                {
                    $childContenttype = Input::get("childContenttypes");
                    if(!in_array(0 , $childContenttype))
                        $contentTypes = array_merge($childContenttype , $contentTypes);
                }
                foreach ($contentTypes as $id)
                {
                    $educationalContents = $educationalContents->whereHas("contenttypes" , function ($q) use ($id)
                    {
                        $q->where("id" , $id ) ;
                    });
                }
            }

        }

        $educationalContents = $educationalContents->get();
        if(Input::has("columns"))
            $columns = Input::get("columns");

        return view("educationalContent.index" , compact("educationalContents" , "columns"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rootContentTypes = Contenttype::whereDoesntHave("parents")->pluck("displayName" , "id") ;

        $childContentTypes = Contenttype::whereHas("parents" , function ($q) {
            $q->where("name" , "exam") ;
        })->pluck("displayName" , "id") ;

        $highSchoolType = Majortype::where("name" , "highschool")->get()->first();
        $majors = Major::where("majortype_id" , $highSchoolType->id)->pluck('name', 'id');

        $grades = Grade::pluck('displayName', 'id');

        return view("educationalContent.create" , compact("rootContentTypes" , "childContentTypes" , "majors" , "grades")) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2()
    {
        $rootContentTypes = Contenttype::whereDoesntHave("parents")->get() ;

        $childContentTypes = Contenttype::whereHas("parents" , function ($q) {
            $q->where("name" , "exam") ;
        })->pluck("displayName" , "id") ;

        $highSchoolType = Majortype::where("name" , "highschool")->get()->first();
        $majors = Major::where("majortype_id" , $highSchoolType->id)->pluck('name', 'id');

        $grades = Grade::pluck('displayName', 'id');

        return view("educationalContent.create2" , compact("rootContentTypes" , "childContentTypes" , "majors" , "grades")) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InsertEducationalContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertEducationalContentRequest $request)
    {
        $educationalContent = new Educationalcontent();
        $educationalContent->fill($request->all()) ;

        if($request->has("validSinceTime"))
        {
            $time =  $request->get("validSinceTime");
            if(strlen($time)>0) $time = Carbon::parse($time)->format('H:i:s');
            else $time ="00:00:00" ;
        }

        if($request->has("validSinceDate"))
        {
            $validSince = $request->get("validSinceDate");
            $validSince = Carbon::parse($validSince)->format('Y-m-d'); //Muhammad : added a day because it returns one day behind and IDK why!!
            if(isset($time)) $validSince = $validSince . " " . $time;
            $educationalContent->validSince = $validSince;
        }

        if($request->has("contenttypes"))
        {
            $contentTypes = $request->get("contenttypes");
//            if($request->has("order") )
//            {
//                if(strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) $educationalContent->order = 0;
//
//                $contentsWithSameType = \App\Educationalcontent::query() ;
//                foreach ($contentTypes as $id)
//                {
//                    $contentsWithSameType = $contentsWithSameType->whereHas("contenttypes" , function ($q) use ($id)
//                    {
//                        $q->where("id" , $id ) ;
//                    });
//                }
//
//                $contentsWithSameOrder = $contentsWithSameType->where("order" , $educationalContent->order);
//                if($contentsWithSameOrder->get()->isNotEmpty())
//                {
//                    $contentsWithGreaterOrder =  $contentsWithSameType->where("order" ,">=" ,$educationalContent->order)->get();
//                    foreach ($contentsWithGreaterOrder as $graterContent)
//                    {
//                        $graterContent->order = $graterContent->order + 1 ;
//                        $graterContent->update();
//                    }
//                }
//            }
        }

        if($request->has("enable")) $educationalContent->enable = 1;
        else $educationalContent->enable = 0 ;

        $done = false ;
        if($educationalContent->save()){
            if($request->has("contentsets"))
            {
                $contentSets = $request->get("contentsets");
                foreach ($contentSets as $contentSet)
                {
                    if(isset($contentSet["order"]))
                        $educationalContent->contentsets()->attach($contentSet["id"] , ["order"=>$contentSet["order"]]);
                    else
                        $educationalContent->contentsets()->attach($contentSet["id"]);
                }
            }
            if(isset($contentTypes))
            {
                $educationalContent->contenttypes()->attach($contentTypes);

                if ($request->hasFile("file1"))
                {
                    $file = $request->file('file1');
                    $extension = $file->getClientOriginalExtension();

                    $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
                    $disk = $educationalContent->fileMultiplexer($contentTypes);
                    if ($disk) {
                        if (Storage::disk($disk)->put($fileName, File::get($file))) {
                            $fileController = new FileController();
                            $request = new InsertFileRequest();
                            $request->offsetSet('name' ,$fileName ) ;
                            $request->offsetSet('disk' , $disk) ;
                            $fileId = $fileController->store($request) ;
                            if($fileId)
                                $educationalContent->files()->attach($fileId);
                        }
                    }
                }

                if ($request->hasFile("file2"))
                {
                    $file = $request->file('file2');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
                    $disk = $educationalContent->fileMultiplexer($contentTypes);
                    if ($disk) {
                        if (Storage::disk($disk)->put($fileName, File::get($file))) {
                            $fileController = new FileController();
                            $request = new InsertFileRequest();
                            $request->offsetSet('name' ,$fileName ) ;
                            $request->offsetSet('disk' , $disk) ;
                            $fileId = $fileController->store($request) ;
                            if($fileId)
                                $educationalContent->files()->attach($fileId);
                        }
                    }
                }
            }

            if($request->has("majors"))
            {
                $majors = $request->get("majors") ;
                $educationalContent->majors()->attach($majors);
            }

            if($request->has("grades"))
            {
                $grades = $request->get("grades") ;
                $educationalContent->grades()->attach($grades);
            }

            if($request->has("file"))
            {
                if($request->has("caption")) $caption = $request->get("caption");
                if(isset($caption))
                    $files = ["name"=>$request->get("file"),"caption"=> $caption];
                else
                    $files = ["name"=>$request->get("file")];
            }
            elseif($request->has("files")) {
                $files = $request->get("files");
            } //ToDo : should be merged
            if(isset($files))
            {
                foreach ($files as $file)
                {
                    $fileName = $file["name"];
                    if(strlen(preg_replace('/\s+/', '',  $fileName) ) == 0) continue;
                    $fileController = new FileController();
                    $fileRequest = new InsertFileRequest();
                    $fileRequest->offsetSet('name' ,$fileName ) ;
                    $disk = $educationalContent->fileMultiplexer();
                    if($disk !== false) $fileRequest->offsetSet('disk_id' , $disk->id) ;
                    $fileId = $fileController->store($fileRequest) ;
                    if($fileId)
                    {
                        $attachPivot = array();
                        if(isset($file["caption"])) $attachPivot["caption"] = $file["caption"];
                        if(isset($file["label"])) $attachPivot["label"] = $file["label"];
                        if(!empty($attachPivot)) $educationalContent->files()->attach($fileId , $attachPivot);
                        else $educationalContent->files()->attach($fileId);
                    }
                }
            }

            if($request->ajax() || $request->has("fromAPI")) $done = true;
            else session()->put('success', 'درج محتوا با موفقیت انجام شد');
        }
        else{
            if($request->ajax() || $request->has("fromAPI")) $done = false ;
            else session()->put('error', 'خطای پایگاه داده');
        }
        if(isset($done)) {
            if($done) return $this->response->setStatusCode(200 )->setContent(["id"=>$educationalContent->id]);
            else return $this->response->setStatusCode(503) ;
        }
        else return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Educationalcontent   $educationalContent
     * @return \Illuminate\Http\Response
     */
    public function show(Educationalcontent $educationalContent)
    {
        $setting = Websitesetting::where("version" , 1)->get()->first();
        $setting = json_decode($setting->setting);

        if(Auth::check()&& Auth::user()->can(Config::get('constants.SHOW_EDUCATIONAL_CONTENT_ACCESS'))) $pass = true;
        else $pass = false ;
        if($pass || $educationalContent->isValid() && $educationalContent->isEnable()) {
            $contentsWithSameType = $educationalContent->contentsWithSameType()->orderBy("validSince","DESC")->take(5)->get();
            $soonContentsWithSameType = $educationalContent->contentsWithSameType(1,0)->orderBy("validSince","ASC")->soon()->take(5)->get() ;
            $rootContentType = $educationalContent->contenttypes()->whereDoesntHave("parents")->get()->first();
            $childContentType = $educationalContent->contenttypes()->whereHas("parents", function ($q) use ($rootContentType) {
                $q->where("id", $rootContentType->id);
            })->get()->first();

            if(in_array("article" , $educationalContent->contenttypes->pluck("name")->toArray()))
                Meta::set('title', substr($educationalContent->name , 0 , Config::get("constants.META_TITLE_LIMIT")));
            else
                Meta::set('title', substr($educationalContent->getDisplayName() , 0 , Config::get("constants.META_TITLE_LIMIT")));
            Meta::set('keywords', substr($educationalContent->getDisplayName() , 0 , Config::get("constants.META_KEYWORDS_LIMIT")));
            Meta::set('description', substr($educationalContent->description, 0 , Config::get("constants.META_DESCRIPTION_LIMIT")));
            Meta::set('image',  route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $setting->site->siteLogo ]));

            return view("educationalContent.show", compact("educationalContent", "rootContentType", "childContentType", "contentsWithSameType" , "soonContentsWithSameType"));
        }
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Educationalcontent   $educationalContent
     * @return \Illuminate\Http\Response
     */
    public function edit($educationalContent)
    {
        $rootContentTypes = Contenttype::whereDoesntHave("parents")->get() ;

        $childContentTypes = Contenttype::whereHas("parents" , function ($q) {
            $q->where("name" , "exam") ;
        })->pluck("displayName" , "id") ;

        $highSchoolType = Majortype::where("name" , "highschool")->get()->first();
        $majors = Major::where("majortype_id" , $highSchoolType->id)->pluck('name', 'id');

        $grades = Grade::pluck('displayName', 'id');

        if(isset($educationalContent->validSince))
        {
            $validSinceTime = explode(" " , $educationalContent->validSince);
            $validSinceTime = $validSinceTime[1] ;
        }
        return view("educationalContent.edit" , compact("educationalContent" ,"rootContentTypes" , "childContentTypes" , "majors" , "grades" , 'validSinceTime')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditEducationalContentRequest  $request
     * @param  \App\Educationalcontent   $educationalContent
     * @return \Illuminate\Http\Response
     */
    public function update(EditEducationalContentRequest $request, $educationalContent)
    {
        $educationalContent->fill($request->all()) ;

        $time =  $request->get("validSinceTime");
        if(strlen($time)>0) $time = Carbon::parse($time)->format('H:i:s');
        else $time ="00:00:00" ;

        $validSince = $request->get("validSinceDate");
        $validSince = Carbon::parse($validSince)->addDay()->format('Y-m-d'); //Muhammad : added a day because it returns one day behind and IDK why!!
        $validSince = $validSince." ".$time;
        $educationalContent->validSince = $validSince;
        if($request->has("contenttypes"))
        {
            $contentTypes = $request->get("contenttypes");

//            if($request->has("order") )
//            {
//                if(strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) $educationalContent->order = 0;
//
//                $contentsWithSameType = \App\Educationalcontent::query() ;
//                foreach ($contentTypes as $id)
//                {
//                    $contentsWithSameType = $contentsWithSameType->whereHas("contenttypes" , function ($q) use ($id)
//                    {
//                        $q->where("id" , $id ) ;
//                    });
//                }
//
//                $contentsWithSameOrder = $contentsWithSameType->where("id" ,"<>", $educationalContent->id)->where("order" , $educationalContent->order);
//                if($contentsWithSameOrder->get()->isNotEmpty())
//                {
//                    $contentsWithGreaterOrder =  $contentsWithSameType->where("order" ,">=" ,$educationalContent->order)->get();
//                    foreach ($contentsWithGreaterOrder as $graterContent)
//                    {
//                        $graterContent->order = $graterContent->order + 1 ;
//                        $graterContent->update();
//                    }
//                }
//            }
        }

        if($request->has("enable")) $educationalContent->enable = 1;
        else $educationalContent->enable = 0 ;

        if ($request->has("file"))
        {
            $files = $request->get("file") ;
            foreach ($files as $file)
            {
                $fileName = $file;
                $fileController = new FileController();
                $request = new InsertFileRequest();
                $request->offsetSet('name' ,$fileName ) ;
                $disk = $educationalContent->fileMultiplexer();
                $request->offsetSet('disk_id' , $disk->id) ;
                $fileId = $fileController->store($request) ;
                if($fileId)
                    $educationalContent->files()->attach($fileId);
            }
        }

        if($educationalContent->save()){
            if(isset($contentTypes))
            {
                $educationalContent->contenttypes()->sync($contentTypes);
            }

            if($request->has("majors"))
            {
                $majors = $request->get("majors") ;
                $educationalContent->majors()->sync($majors);
            }

            if($request->has("grades"))
            {
                $grades = $request->get("grades") ;
                $educationalContent->grades()->sync($grades);
            }
            session()->put('success', 'اصلاح محتوا با موفقیت انجام شد');
        }
        else{
            session()->put('error', 'خطای پایگاه داده');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Educationalcontent  $educationalContent
     * @return \Illuminate\Http\Response
     */
    public function destroy($educationalContent)
    {
        if ($educationalContent->delete()){

            return $this->response->setStatusCode(200) ;
        }
        else {
            return $this->response->setStatusCode(503) ;
        }

    }

    /**
     * Search for an educational content
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $pageName = "educationalContent" ;

        $highSchoolType = Majortype::where("name" , "highschool")->get()->first();
        $majors = Major::where("majortype_id" , $highSchoolType->id)->pluck('name', 'id')->toArray();
        $majors = array_add($majors , 0 , "همه رشته ها");
        $majors = array_sort_recursive($majors);

        $grades = Grade::where("name" ,'<>' , 'graduated' )->pluck('displayName', 'id')->toArray(); //ToDo:
        $grades = array_add($grades , 0 , "همه مقاطع");
        $grades = array_sort_recursive($grades);

        $rootContentTypes = Contenttype::where("enable", 1)->whereDoesntHave("parents")->pluck("displayName" , "id")->toArray() ;
        $rootContentTypes = array_add($rootContentTypes , 0 , "نوع محتوا");
        $rootContentTypes = array_sort_recursive($rootContentTypes);

        $childContentTypes = Contenttype::whereHas("parents" , function ($q) {
            $q->where("name" , "exam") ;
        })->pluck("displayName" , "id")->toArray() ;
        $childContentTypes = array_add($childContentTypes , 0 , "زیر شاخه");
        $childContentTypes = array_sort_recursive($childContentTypes);

        $soonEducationalContents = Educationalcontent::soon()->orderBy("validSince")->take(9)->get() ;

        if(Config::has("constants.EDUCATIONAL_CONTENT_EXCLUDED_PRODUCTS"))
            $excludedProducts = Config::get("constants.EDUCATIONAL_CONTENT_EXCLUDED_PRODUCTS");
        else
            $excludedProducts = [] ;
        $products = Product::recentProducts(3)->whereNotIn("id",$excludedProducts)->get();
        $costCollection = $this->makeCostCollection($products) ;

        $educationalContents = Educationalcontent::enable()->valid()->orderBy("validSince","DESC")->take(10)->get() ;
        $metaKeywords = "";
        $metaDescription = "" ;
        foreach ($educationalContents as $educationalContent)
        {
            $metaKeywords .= $educationalContent->name."-";
            $metaDescription .= $educationalContent->name."-" ;
        }
        $setting = Websitesetting::where("version" , 1)->get()->first();
        $setting = json_decode($setting->setting);
        Meta::set('title', substr("محتوای آموزشی ".$setting->site->name, 0 , Config::get("constants.META_TITLE_LIMIT")));
        Meta::set('keywords', substr($metaKeywords , 0 , Config::get("constants.META_KEYWORDS_LIMIT")));
        Meta::set('description', substr($metaDescription , 0 , Config::get("constants.META_DESCRIPTION_LIMIT")));
        Meta::set('image',  route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $setting->site->siteLogo ]));

        return view("educationalContent.search" , compact("educationalContents" , "pageName" , "majors" , "grades" , "rootContentTypes", "childContentTypes" , "soonEducationalContents" , "products" , "costCollection"));
    }


    /**
     * Search for an educational content
     *
     * @param \App\Educationalcontent $educationalContent
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function detachFile($educationalContent , $file)
    {
        if($educationalContent->files()->detach($file))
        {
            session()->put('success', 'فایل محتوا با موفقیت حذف شد');
            return $this->response->setStatusCode(200) ;
        }else{
            return $this->response->setStatusCode(503) ;
        }
    }

    /**
     * String the caption of content file
     *
     * @param \App\Http\Requests\InsertEducationalContentFileCaption $request
     * @param \App\Educationalcontent $educationalContent
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function storeFileCaption(InsertEducationalContentFileCaption $request , $educationalContent , $file)
    {
        $caption = $request->get("caption");
        if(strcmp($educationalContent->files()->where("id" , $file->id)->get()->first()->pivot->caption , $caption) == 0)
            return $this->response->setStatusCode(501)->setContent("لطفا کپشن جدید وارد نمایید");
        if($educationalContent->files()->updateExistingPivot($file->id ,["caption" => $caption]))
        {
            session()->put('success', 'عنوان با موفقیت اصلاح شد');
            return $this->response->setStatusCode(200) ;
        } else {
            return $this->response->setStatusCode(503) ;
        }
     }
}
