<?php

namespace App\Http\Controllers;

use App\Contenttype;
use App\Educationalcontent;
use App\Grade;
use App\Http\Requests\EditEducationalContentRequest;
use App\Http\Requests\InsertEducationalContentFileCaption;
use App\Http\Requests\InsertEducationalContentRequest;
use App\Http\Requests\InsertFileRequest;
use App\Http\Requests\Request;
use App\Major;
use App\Majortype;
use App\Product;
use App\Traits\APIRequestCommon;
use App\Traits\ProductCommon;
use App\Websitesetting;
use Carbon\Carbon;
use Meta;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Auth;
use Jenssegers\Agent\Agent;
use SSH;

class EducationalContentController extends Controller
{
    use APIRequestCommon;
    protected $response ;
    protected $setting ;
    use ProductCommon ;

    public function __construct()
    {
        $agent = new Agent();
        if ($agent->isRobot())
        {
            $authException = ["index" , "show" , "search" ,"embed" ];
        }else{
            $authException = ["index" ,"search"  ];
        }
        $this->middleware('auth', ['except' => $authException]);

        $this->middleware('permission:'.Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'),['only'=>['store' , 'create' , 'create2']]);
        $this->middleware('permission:'.Config::get("constants.EDIT_EDUCATIONAL_CONTENT"),['only'=>['update' , 'edit']]);
        $this->middleware('permission:'.Config::get("constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS"),['only'=>'destroy']);

        $this->response = new Response();
        $this->setting = json_decode(app('setting')->setting);
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

    public function embed(Request $request , Educationalcontent $educationalcontent){
        $url = $request->url();
        Meta::set('canonical',str_replace('/embed/','/',$url));
        //TODO: Authentication

        //TODO: use Content Type instead of template_id

        if($educationalcontent->template_id != 1)
            return redirect('/',301);
        $video = $educationalcontent;
        $files = $video->files;
        return view("educationalContent.embed",compact('video','files'));
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

        $fileController = new FileController();
        $fileRequest = new InsertFileRequest();

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
        }

        if($request->has("enable"))
            $educationalContent->enable = 1;
        else
            $educationalContent->enable = 0 ;

        $done = false ;
        if($educationalContent->save()){

            if($request->has("contentsets"))
            {
                $contentSets = $request->get("contentsets");
                foreach ($contentSets as $contentSet)
                {
                    $pivots = array();
                    if(isset($contentSet["order"]))
                        $pivots["order"] = $contentSet["order"];
                    if(isset($contentSet["isDefault"]))
                        $pivots["isDefault"] = $contentSet["isDefault"];

                    if(!empty($pivots))
                        $educationalContent->contentsets()->attach($contentSet["id"] , $pivots);
                    else
                        $educationalContent->contentsets()->attach($contentSet["id"]);
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

            if(isset($contentTypes))
            {
                $educationalContent->contenttypes()->attach($contentTypes);

                //TODO: file1,2 ??!
                if ($request->hasFile("file1"))
                {
                    $file = $request->file('file1');
                    $extension = $file->getClientOriginalExtension();

                    $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
                    $disk = $educationalContent->fileMultiplexer($contentTypes);
                    if ($disk) {
                        if (Storage::disk($disk)->put($fileName, File::get($file))) {

                            $fileRequest->offsetSet('name' ,$fileName ) ;
                            $fileRequest->offsetSet('disk' , $disk) ;
                            $fileId = $fileController->store($fileRequest) ;
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

                            $fileRequest->offsetSet('name' ,$fileName ) ;
                            $fileRequest->offsetSet('disk' , $disk) ;
                            $fileId = $fileController->store($fileRequest) ;
                            if($fileId)
                                $educationalContent->files()->attach($fileId);
                        }
                    }
                }
            }


            if($request->has("file"))
            {
                if($request->has("caption"))
                    $caption = $request->get("caption");
                if(isset($caption))
                    $files = [ 0 => ["name"=>$request->get("file"),"caption"=> $caption] ];
                else
                    $files = [ 0 => [ "name"=>$request->get("file")] ];


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

                    $fileRequest->offsetSet('name' ,$fileName ) ;
                    if(isset($file["disk_id"]))
                    {
                        $fileRequest->offsetSet('disk_id' , $file["disk_id"]) ;
                    }
                    else
                    {
                        $disk = $educationalContent->fileMultiplexer();
                        if($disk !== false)
                            $fileRequest->offsetSet('disk_id' , $disk->id) ;
                    }

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
     * @param Request $request
     * @param  \App\Educationalcontent $educationalContent
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Educationalcontent $educationalContent)
    {

//        if(Auth::check() && Auth::user()->can(Config::get('constants.SHOW_EDUCATIONAL_CONTENT_ACCESS'))) $pass = true;
//        else $pass = false ;
        $pass=true;
        if($pass || $educationalContent->isValid() && $educationalContent->isEnable())
        {
            $contentsWithSameType = $educationalContent->contentsWithSameType()->orderBy("validSince","DESC")->take(5)->get();
            $soonContentsWithSameType = $educationalContent->contentsWithSameType(1,0)->orderBy("validSince","ASC")->soon()->take(5)->get() ;
            $rootContentType = $educationalContent->contenttypes()->whereDoesntHave("parents")->get()->first();
            $childContentType = $educationalContent->contenttypes()->whereHas("parents", function ($q) use ($rootContentType) {
                $q->where("id", $rootContentType->id);
            })->get()->first();

            $educationalContentDisplayName = $educationalContent->getDisplayName();

            /**
             *      Retrieving Tags
             */
            $response = $this->sendRequest(env("TAG_API_URL")."id/content/".$educationalContent->id,"GET");
            if($response["statusCode"] == 200){
                $result = json_decode($response["result"]);
                $tags = $result->data->tags;
            }

            $title ='';
            if (isset($educationalContent->template))
            {
                switch($educationalContent->template->name)
                {
                    case "video1":
                        $title ='فیلم ';
                        $files = collect();
                        $videoSources = collect();
    //                    $time_now = date('Hi');
                        $file = $educationalContent->files->where("pivot.label" , "hd")->first() ;
                        if(isset($file))
                        {
    //                        $download_link_postfix = md5($file->name).$time_now;
    //                        $download_link_postfix = str_replace("+","-",$download_link_postfix);
    //                        $download_link_postfix = str_replace("/","_",$download_link_postfix);
    //                        $download_link_postfix = str_replace("=","",$download_link_postfix);
    //                        $videoSources->put( "hd" , ["src"=>$file->name."?md5=".$download_link_postfix , "caption"=>$file->pivot->caption]) ;
                            $videoSources->put( "hd" , ["src"=>$file->name , "caption"=>$file->pivot->caption]) ;
                        }

                        $file = $educationalContent->files->where("pivot.label" , "hq")->first() ;
                        if(isset($file))
                        {
    //                        $download_link_postfix = md5($file->name).$time_now;
    //                        $download_link_postfix = str_replace("+","-",$download_link_postfix);
    //                        $download_link_postfix = str_replace("/","_",$download_link_postfix);
    //                        $download_link_postfix = str_replace("=","",$download_link_postfix);
    //                        $videoSources->put( "hq" , ["src"=>$file->name."?md5=".$download_link_postfix , "caption"=>$file->pivot->caption]) ;
                            $videoSources->put( "hq" , ["src"=>$file->name , "caption"=>$file->pivot->caption]) ;
                        }

                        $file = $educationalContent->files->where("pivot.label" , "240p")->first() ;
                        if(isset($file))
                        {
    //                        $download_link_postfix = md5($file->name).$time_now;
    //                        $download_link_postfix = str_replace("+","-",$download_link_postfix);
    //                        $download_link_postfix = str_replace("/","_",$download_link_postfix);
    //                        $download_link_postfix = str_replace("=","",$download_link_postfix);
    //                        $videoSources->put( "240p" , ["src"=>$file->name."?md5=".$download_link_postfix ,  "caption"=>$file->pivot->caption]) ;
                            $videoSources->put( "240p" , ["src"=>$file->name ,  "caption"=>$file->pivot->caption]) ;
                        }
                        $file = $educationalContent->files->where("pivot.label" , "thumbnail")->first();
                        if(isset($file))
                            $files->put("thumbnail" , $file->name);
                        $files->put("videoSource" , $videoSources);

                        $contenSets = $educationalContent->contentsets->where("pivot.isDefault" , 1);
                        if($contenSets->isNotEmpty())
                        {
                            $contentSet = $contenSets->first();
                            $sessionNumber = $contentSet->pivot->order;
                            $sameContents =  $contentSet->educationalcontents ;
                            $contentsWithSameSet = collect();
                            foreach ($sameContents as $content)
                            {
                                $file = $content->files->where("pivot.label" , "thumbnail")->first();
                                if(isset($file)) $thumbnailFile = $file->name;
                                else $thumbnailFile = "" ;

                                $contentTypes = $content->contenttypes->pluck("name")->toArray();
                                if(in_array("video" , $contentTypes ))
                                    $myContentType = "video";
                                elseif(in_array("pamphlet" , $contentTypes ))
                                    $myContentType = "pamphlet";

                                $session = $content->pivot->order;
                                $contentsWithSameSet->push(["type"=> $myContentType , "content"=>$content , "thumbnail"=>$thumbnailFile , "session"=>$session]);
                            }
                        }
                        break;
                    case  "pamphlet1":
                        $title ='جزوه ';
                        $files = $educationalContent->files;
                        $fileToShow = $educationalContent->file;
                        break;
                    case "article" :
                        $title ='';
                        break;
                    default:
                        break;
                }
            }

            $metaFromTags = "";
            foreach ($tags as $tag)
            {
                $metaFromTags .= $tag ;
                $metaFromTags .= ",";
            }

            if(isset($sessionNumber))
                $metaTitlePrefix = "جلسه ".$sessionNumber." - ";
            else
                $metaTitlePrefix = "";
            $url = $request->url();
            $title .= ( isset($sessionNumber)? "جلسه ".$sessionNumber." - ":"" )." ".$educationalContent->name;
            Meta::set('canonical',$url);
//            if(isset($educationalContent->metaTitle) && strlen($educationalContent->metaTitle) > 0)
//                Meta::set('title', $metaTitlePrefix.$educationalContent->metaTitle);
//            else
//                Meta::set('title', $title);
            Meta::set('title', $title);

            if(isset($educationalContent->metaKeywords) && strlen($educationalContent->metaKeywords) > 0)
                Meta::set('keywords', $educationalContent->metaKeywords);
            else
                Meta::set('keywords', $metaFromTags);

            if(isset($educationalContent->metaDescription) && strlen($educationalContent->metaDescription) > 0)
                Meta::set('description', $educationalContent->metaDescription);
            else
                Meta::set('description', $metaFromTags);

            //TODO: move thumbnails to sftp storage
            if(isset( $educationalContent->thumbnails ))
                Meta::set('image', $educationalContent->thumbnails->first()->name);
            else
                Meta::set('image',  route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]));

            $sideBarMode = "closed";

            return view("educationalContent.show", compact("title","educationalContent", "rootContentType", "childContentType", "contentsWithSameType" , "soonContentsWithSameType" , "educationalContentSet" , "contentsWithSameSet" , "videoSources" , "files" , "tags" , "sideBarMode" , "educationalContentDisplayName" , "sessionNumber" , "fileToShow"));
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

        $fileController = new FileController();
        $fileRequest = new InsertFileRequest();


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
        }

        if($request->has("enable"))
            $educationalContent->enable = 1;
        else
            $educationalContent->enable = 0 ;


        if($educationalContent->save()){

            if($request->has("contentsets"))
            {
                $contentSets = $request->get("contentsets");
                foreach ($contentSets as $contentSet)
                {
                    if(isset($contentSet["order"]))
                        $educationalContent->contentsets()->sync($contentSet["id"] , ["order"=>$contentSet["order"]]);
                    else
                        $educationalContent->contentsets()->sync($contentSet["id"]);
                }
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

            if(isset($contentTypes))
            {
                $educationalContent->contenttypes()->sync($contentTypes);
            }

            if ($request->has("file"))
            {
                $files = $request->get("file") ;

            }elseif($request->has("files")) {
                $files = $request->get("files");
            } //ToDo : should be merged

            if(isset($files)){
//                dd($request->all());
                foreach ($files as $file)
                {
                    $fileName = $file;
                    $fileRequest->offsetSet('name' ,$fileName ) ;
                    $disk = $educationalContent->fileMultiplexer();
                    $fileRequest->offsetSet('disk_id' , $disk->id) ;
                    $fileId = $fileController->store($fileRequest) ;
                    if($fileId)
                        $educationalContent->files()->attach($fileId);
                }
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
     * @param  \App\Educationalcontent $educationalContent
     * @return \Illuminate\Http\Response
     * @throws \Exception
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
        return redirect('/c',301);
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
    public function storeFileCaption(InsertEducationalContentFileCaption $request , Educationalcontent $educationalContent , File $file)
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

    public function retrieveTags()
    {
        if(Input::has("apipath"))
        {
            $apipath = Input::get("apipath");
            $client = new \GuzzleHttp\Client();
            $res = $client->get( $apipath );
            $responseStatus = $res->getStatusCode();
            if($responseStatus == 200)
            {
                $result = $res->getBody()->getContents();
                return $this->response->setStatusCode(200)->setContent($result);
            }
            else
            {
                return $this->response->setStatusCode($responseStatus);
            }
        }
    }
}
