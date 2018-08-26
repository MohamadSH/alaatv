<?php

namespace App\Http\Controllers;

use App\Contentset;
use App\Contenttype;
use App\Educationalcontent;
use App\Http\Requests\EditEducationalContentRequest;
use App\Http\Requests\InsertEducationalContentFileCaption;
use App\Http\Requests\InsertEducationalContentRequest;
use App\Http\Requests\InsertFileRequest;
use App\Http\Requests\Request;
use App\Traits\APIRequestCommon;
use App\Traits\FileCommon;
use App\Traits\Helper;
use App\Traits\ProductCommon;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Jenssegers\Agent\Agent;
use SEO;
use SSH;


class EducationalContentController extends Controller
{
    use APIRequestCommon;
    protected $response ;
    protected $setting ;

    use ProductCommon ;
    use Helper;
    use FileCommon ;

    private function getAuthExceptionArray(Agent $agent): array
    {
        if ($agent->isRobot())
        {
            $authException = ["index" , "show" , "search" ,"embed" ];
        }else{
            $authException = ["index" ,"search"  ];
        }
        //TODO:// preview
        $authException = ["index" , "show" , "search" ,"embed" ];
        return $authException;
    }

    public function __construct(Agent $agent, Response $response)
    {
//        dd($setting);
        $this->response = $response;
        $this->setting = json_decode(app('setting')->setting);
        $authException = $this->getAuthExceptionArray($agent);
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:'.Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'),['only'=>['store' , 'create' , 'create2']]);
        $this->middleware('permission:'.Config::get("constants.EDIT_EDUCATIONAL_CONTENT"),['only'=>['update' , 'edit']]);
        $this->middleware('permission:'.Config::get("constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS"),['only'=>'destroy']);
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
                $educationalContents = Educationalcontent::orderBy("created_at" , "DESC");
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
        $url = action('EducationalContentController@show', $educationalcontent);
        //TODO:// $this->generateSeoMetaTags
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");

        //TODO: use Content Type instead of template_id
        if($educationalcontent->template_id != 1)
            return redirect($url, 301);
        $video = $educationalcontent;

        [
            $contentsWithSameSet ,
            $contentSetName
        ]  = $video->getSetMates();
        $files = $video->files;

        return view("educationalContent.embed",compact('video','files','contentsWithSameSet','contentSetName'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rootContentTypes = Contenttype::whereDoesntHave("parents")
            ->get();
        $contentsets = Contentset::latest()
                                ->pluck("name" , "id");
        $authors = User::whereHas("roles" , function ($q){
            $q->where("name", "teacher");
        })->get()
            ->sortBy("lastName")
            ->values()
            ->pluck("full_name", "id");

        return view("educationalContent.create2" , compact("rootContentTypes" ,
                                                                        "contentsets" ,
                                                                            "authors"
                                                                        )) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2()
    {
        $contenttypes = collect();
        $contenttypes->put("8" , "فیلم");
        $contenttypes->put("1" , "جزوه");

        return view("educationalContent.create3" , compact("contenttypes")) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InsertEducationalContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertEducationalContentRequest $request)
    {

        try
        {
            $educationalContent = new Educationalcontent();
            $educationalContent->fill($request->all()) ;
            if(is_null($educationalContent->order))
                $educationalContent->order = 0;
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

            if($request->has("enable"))
                $educationalContent->enable = 1;
            else
                $educationalContent->enable = 0 ;

            switch ($educationalContent->contenttype_id)
            {
                case 1 : // pamphlet
                    $educationalContent->template_id = 2 ;
                    break;
                case 8 : // video
                    $educationalContent->template_id = 1;
                    break;
                default:
                    break;
            }

            if($request->has("tags"))
            {
                $tagString = $request->get("tags") ;
                $tags = explode("," , $tagString);
                $tags = array_filter($tags);
                $tagsJson = [
                    "bucket" => "content",
                    "tags" => $tags
                ];
                $educationalContent->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
            }

            $done = false ;
            if($educationalContent->save()){

                if($request->has("contentset_id"))
                {
                    $contentset_id = $request->get("contentset_id");
                    if($request->has("order"))
                    {
                        $order = $request->get("order");
                        if(is_null($order))
                             $order = 0 ;

                        $pivots = [];
                        $pivots["order"] = $order;
                        $pivots["isDefault"] = 1;
                    }

                    if(empty($pivots))
                        $educationalContent->contentsets()->attach($contentset_id);
                    else
                        $educationalContent->contentsets()->attach($contentset_id , $pivots);
                }

                if($request->has("file"))
                {
                    $files = $request->get("file") ;
                }
                elseif($request->has("files")) {
                    $files = $request->get("files");
                } //ToDo : should be merged

                if(isset($files))
                {
                    foreach ($files as $key => $file)
                    {
                        $fileName = $file;
                        if(strlen(preg_replace('/\s+/', '',  $fileName) ) == 0)
                            continue;

                        $fileRequest->offsetSet('name' ,$fileName ) ;
                        $disk = $request->get("disk")[$key];
                        if(isset($disk))
                        {
                            $fileRequest->offsetSet('disk_id' , $disk) ;
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
                            $caption = $request->get("caption")[$key];
                            if(isset($caption))
                                $attachPivot["caption"] = $caption;

                            $label = $request->get("label")[$key];
                            if(isset($label))
                                $attachPivot["label"] = $label;

                            if(empty($attachPivot))
                                $educationalContent->files()->attach($fileId);
                            else
                                $educationalContent->files()->attach($fileId , $attachPivot);
                        }
                    }

                }

                if($educationalContent->enable  &&  isset($educationalContent->tags) &&
                    is_array($educationalContent->tags->tags) &&
                    !empty($educationalContent->tags->tags))
                {
                    $itemTagsArray = $educationalContent->tags->tags ;
                    $params = [
                        "tags" => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
                    ];

                    if(isset($educationalContent->created_at) && strlen($educationalContent->created_at) > 0 )
                        $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s" , $educationalContent->created_at )->timestamp;

                    $response =  $this->sendRequest(
                        config("constants.TAG_API_URL")."id/content/".$educationalContent->id ,
                        "PUT",
                        $params
                    );

                    if($response["statusCode"] == 200)
                    {
                        //
                    }
                    else
                    {
                    }
                }


                if($request->ajax() || $request->has("fromAPI"))
                    $done = true;
                else
                    session()->put('success', 'درج محتوا با موفقیت انجام شد');
            }
            else{
                if($request->ajax() || $request->has("fromAPI")) $done = false ;
                else session()->put('error', 'خطای پایگاه داده');
            }
            if(isset($done))
            {
                if($done)
                    return $this->response->setStatusCode(200 )
                        ->setContent(["id"=>$educationalContent->id]);
                else
                    return $this->response->setStatusCode(503) ;
            }
            else
            {
                return redirect()->back();
            }
        }
        catch (\Exception    $e)
        {
            $message = "unexpected error";
            return $this->response
                ->setStatusCode(500)
                ->setContent([
                    "message"=>$message ,
                    "error"=>$e->getMessage() ,
                    "line"=>$e->getLine() ,
                    "file"=>$e->getFile()
                ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Educationalcontent $educationalContent
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(Request $request, Educationalcontent $educationalContent)
    {
        $url = $request->url();
        if ($educationalContent->isActive()) {
            $userCanSeeCounter = false;
            $sideBarMode = "closed";
            $educationalContentDisplayName = $educationalContent->display_name;
            $adItems = $educationalContent->getAddItems();

            /**
             *      Retrieving Tags
             */
            $tags = $educationalContent->retrievingTags();
            [
                $author, $educationalContent, $contentsWithSameSet, $videosWithSameSet, $videosWithSameSetL, $videosWithSameSetR, $pamphletsWithSameSet, $contentSetName, $metaTagMod
            ] = $this->getContentInformation($educationalContent);

            $this->generateSeoMetaTags($educationalContentDisplayName, $educationalContent, $tags, $url, $metaTagMod, $author);


            if (Auth::check()) {
                $user = Auth::user();
                $contentPath = "/" . $request->path();
                $productSeenCount = $this->userSeen($contentPath, $user);
                if ($user->hasRole("admin"))
                    $userCanSeeCounter = true;
            }



            return view("educationalContent.show", compact("productSeenCount", "author", "educationalContent", "rootContentType", "childContentType", "contentsWithSameType", "soonContentsWithSameType", "educationalContentSet", "contentsWithSameSet", "videosWithSameSet", "pamphletsWithSameSet", "contentSetName", "videoSources",
                "files", "tags", "sideBarMode", "educationalContentDisplayName", "sessionNumber", "fileToShow", "userCanSeeCounter", "adItems", "videosWithSameSetL", "videosWithSameSetR"));
        } else
            abort(403);
    }

    private function generateSeoMetaTags($educationalContentDisplayName, $educationalContent, $tags, $url, $metaTagMod, $author)
    {
        SEO::setTitle($educationalContentDisplayName);
        if (isset($educationalContent->metaDescription) && strlen($educationalContent->metaDescription) > 0)
            SEO::setDescription($educationalContent->metaDescription);
        else
            if (isset($tags)) {
                SEO::setDescription(implode(",", $tags));
            }

        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        //TODO: move thumbnails to sftp storage
        if (isset($files['thumbnail']))
            SEO::opengraph()->addImage($files['thumbnail'], ['height' => 720, 'width' => 1280]);
        else
            SEO::opengraph()->addImage(route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]), ['height' => 100, 'width' => 100]);
        switch ($metaTagMod) {
            case 1: // video

                SEO::twitter()->addValue('player', action('EducationalContentController@embed', $educationalContent));
                SEO::twitter()->addValue('player:width', "854");
                SEO::twitter()->addValue('player:height', "480");
                // video.movie
                SEO::opengraph()->setType('video')
                    ->setVideoMovie([
                        'actor' => (isset($author)) ? $author : "",
                        'actor:role' => 'دبیر',
                        'director' => 'آلاء',
                        'writer' => 'آلاء',
                        'duration' => null,
                        'release_date' => $educationalContent->creat_at,
                        'tag' => $tags
                    ]);
                // og:video
                SEO::opengraph()->addVideo($videoSources->get('hq')["src"], [
                    'secure_url' => $videoSources->get('hq')["src"],
                    'type' => 'video/mp4',
                    'width' => 854,
                    'height' => 480
                ]);

                break;
            case 2://pdf
                SEO::opengraph()->setType('website');
                break;
            case 3: //article
                SEO::opengraph()->setType('article')
                    ->setArticle([
                        'published_time' => $educationalContent->creat_at,
                        'modified_time' => $educationalContent->update_at,
                        'author' => $author,
                        'tag' => $tags
                    ]);
                break;
        }
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

        if(isset($educationalContent->validSince))
        {
            $validSinceTime = explode(" " , $educationalContent->validSince);
            $validSinceTime = $validSinceTime[1] ;
        }

        $tags = "";
        if(isset($educationalContent->tags->tags))
            $tags = $strTags = implode(",",$educationalContent->tags->tags);

        $contentset = $educationalContent->contentsets
                                        ->first();

        $rootContentTypes = Contenttype::whereDoesntHave("parents")
                                        ->get() ;

        return view("educationalContent.edit" , compact("educationalContent" ,
                                                                    "rootContentTypes" ,
                                                                    'validSinceTime' ,
                                                                    'tags' ,
                                                                    'contentset' ,
                                                                    'rootContentTypes'
                                                        )) ;
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

//        if($request->has("contenttype_id"))
//        {
//            $educationalContent->contenttype_id = $request->get("contenttype_id");
//        }

        if($request->has("enable"))
            $educationalContent->enable = 1;
        else
            $educationalContent->enable = 0 ;

        if($request->has("tags"))
        {
            $tagString = $request->get("tags") ;
            $tags = explode("," , $tagString);
            $tags = array_filter($tags);
            $tagsJson = [
                "bucket" => "content",
                "tags" => $tags
            ];
            $educationalContent->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
        }

        if($educationalContent->update()){

//            if($request->has("contentsets"))
//            {
//                $contentSets = $request->get("contentsets");
//                foreach ($contentSets as $contentSet)
//                {
//                    if(isset($contentSet["order"]))
//                        $educationalContent->contentsets()->sync($contentSet["id"] , ["order"=>$contentSet["order"]]);
//                    else
//                        $educationalContent->contentsets()->sync($contentSet["id"]);
//                }
//            }

//            if($request->has("majors"))
//            {
//                $majors = $request->get("majors") ;
//                $educationalContent->majors()->sync($majors);
//            }
//
//            if($request->has("grades"))
//            {
//                $grades = $request->get("grades") ;
//                $educationalContent->grades()->sync($grades);
//            }

            if ($request->has("file"))
            {
                $files = $request->get("file") ;

            }elseif($request->has("files")) {
                $files = $request->get("files");
            } //ToDo : should be merged

            if(isset($files))
            {
                foreach ($files as $key => $file)
                {
                    $fileName = $file;
                    if(strlen(preg_replace('/\s+/', '',  $fileName) ) == 0)
                        continue;

                    $fileRequest->offsetSet('name' ,$fileName ) ;
                    $disk = $request->get("disk")[$key];
                    if(isset($disk))
                    {
                        $fileRequest->offsetSet('disk_id' , $disk) ;
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
                        $caption = $request->get("caption")[$key];
                        if(isset($caption))
                            $attachPivot["caption"] = $caption;

                        $label = $request->get("label")[$key];
                        if(isset($label))
                            $attachPivot["label"] = $label;

                        if(empty($attachPivot))
                            $educationalContent->files()->attach($fileId);
                        else
                            $educationalContent->files()->attach($fileId , $attachPivot);
                    }
                }
            }

            if($educationalContent->enable  &&  isset($educationalContent->tags) &&
                is_array($educationalContent->tags->tags) &&
                !empty($educationalContent->tags->tags))
            {
                $itemTagsArray = $educationalContent->tags->tags ;
                $params = [
                    "tags" => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
                ];

                if(isset($educationalContent->created_at) && strlen($educationalContent->created_at) > 0 )
                    $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s" , $educationalContent->created_at )->timestamp;

                $response =  $this->sendRequest(
                    config("constants.TAG_API_URL")."id/content/".$educationalContent->id ,
                    "PUT",
                    $params
                );

                if($response["statusCode"] == 200)
                {
                    //
                }
                else
                {
                    session()->put('error', 'خطا در ریکوئست تگ ها');
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

     public function basicStore(Request $request)
     {
         try
         {
             $contentset_id = $request->get("contentset_id");
             $contenttype_id = $request->get("contenttype_id");
             $name = $request->get("name");
             if($request->has("order"))
                 $order = $request->get("order");
             $fileName = $request->get("fileName");
             $dateNow = Carbon::now();

             $contentset = Contentset::FindOrFail($contentset_id);
             $lastContent = $contentset->educationalcontents->sortByDesc("pivot.order")->first() ;
             if(isset($lastContent))
                $newContent = $lastContent->replicate();
             else
             {
                 session()->put("error" , "محتوایی برای کپی یافت نشد ، برای استفاده از این پنل باید ابتدا یک محتوا برای این دوره درج کنید");
                 return redirect()->back();
             }
             $newContent->contenttype_id = $contenttype_id ;
             if($contenttype_id == 1)
                 $newContent->template_id = 2 ;
             elseif($contenttype_id == 8)
                 $newContent->template_id = 1 ;

             $newContent->name = $name;
             $newContent->description = null;
             $newContent->metaTitle = null;
             $newContent->metaDescription = null;
             $newContent->enable = 0;
             $newContent->validSince = $dateNow;
             $newContent->created_at = $dateNow;
             $newContent->updated_at = $dateNow;
             $newContent->save();
             $fileRequest = new InsertFileRequest();
             $fileController = new FileController();
             if(strcmp($request->get("mode") , "filelink") == 0)
             {
                 $hd = $request->get("hd");
                 $hq = $request->get("hq");
                 $_240p = $request->get("240p");
                 $thumbnail = $request->get("thumbnail");
                 if(isset($_240p))
                 {

                     $fileRequest->offsetSet("name"  , $_240p );
                     $_240pId =  $fileController->store($fileRequest);
                     $newContent->files()->attach($_240pId , ["caption"=>"کیفیت متوسط" , "label"=>"240p"]);
                 }

                 if(isset($hq))
                 {
                     $fileRequest->offsetSet("name"  , $hq );
                     $hqId =  $fileController->store($fileRequest);
                     $newContent->files()->attach($hqId , ["caption"=>"کیفیت بالا" , "label"=>"hq"]);
                 }

                 if(isset($hd))
                 {
                     $fileRequest->offsetSet("name"  , $hd );
                     $hdId =  $fileController->store($fileRequest);
                     $newContent->files()->attach($hdId , ["caption"=>"کیفیت عالی" , "label"=>"hd"]);
                 }

                 if(isset($thumbnail))
                 {
                     $fileRequest->offsetSet("name"  , $thumbnail );
                     $thumbnailId =  $fileController->store($fileRequest);
                     $newContent->files()->attach($thumbnailId , ["caption"=>"تامبنیل" , "label"=>"thumbnail"]);
                 }
             }
             elseif(strcmp($request->get("mode") , "filename") == 0)
             {
                 $baseUrl = "https://cdn.sanatisharif.ir/media/";
                 if(isset($fileName))
                 {
                     //240p
                     $_240pUrl = $baseUrl.$contentset_id."/240p/".$fileName;
                     $fileRequest->offsetSet("name"  , $_240pUrl );
                     $_240pId =  $fileController->store($fileRequest);
                     $newContent->files()->attach($_240pId , ["caption"=>"کیفیت متوسط" , "label"=>"240p"]);

                     //hq
                     $hqUrl = $baseUrl.$contentset_id."/hq/".$fileName;
                     $fileRequest->offsetSet("name"  , $hqUrl );
                     $hqId =  $fileController->store($fileRequest);
                     $newContent->files()->attach($hqId , ["caption"=>"کیفیت بالا" , "label"=>"hq"]);

                     //HD
                     $hdUrl =  $baseUrl.$contentset_id."/HD_720p/".$fileName;
                     $fileRequest->offsetSet("name"  , $hdUrl );
                     $hdId =  $fileController->store($fileRequest);
                     $newContent->files()->attach($hdId , ["caption"=>"کیفیت عالی" , "label"=>"hd"]);

                     //thumbnail
                     $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                     $thumbnailFileName = basename($fileName, "." . $ext);
                     $thumbnailUrl =  $baseUrl."thumbnails/".$contentset_id."/".$thumbnailFileName.".jpg";
                     $fileRequest->offsetSet("name"  , $thumbnailUrl );
                     $thumbnailId =  $fileController->store($fileRequest);
                     $newContent->files()->attach($thumbnailId , ["caption"=>"تامبنیل" , "label"=>"thumbnail"]);
                 }
             }


             if(!isset($order))
                 $order = $lastContent->pivot->order + 1;
             $newContent->contentsets()->attach($contentset->id , ["order"=>$order , "isDefault"=>1]);

             return redirect(action("EducationalContentController@edit" , $newContent->id));
         }
         catch (\Exception    $e)
         {
             $message = "unexpected error";
             return $this->response
                 ->setStatusCode(503)
                 ->setContent([
                     "message"=>$message ,
                     "error"=>$e->getMessage() ,
                     "line"=>$e->getLine() ,
                     "file"=>$e->getFile()
                 ]);
         }

     }

    /**
     * @param Educationalcontent $educationalContent
     * @return array
     */
    private function getContentInformation(Educationalcontent $educationalContent): array
    {
        $key = "content:show" . $educationalContent->cacheKey();
        [
            $author,
            $educationalContent,
            $contentsWithSameSet,
            $videosWithSameSet,
            $videosWithSameSetL,
            $videosWithSameSetR,
            $pamphletsWithSameSet,
            $contentSetName,
            $metaTagMod
        ] = Cache::tags(["content", "c" . $educationalContent->id])->remember($key, Config::get("constants.CACHE_60"), function () use ($educationalContent) {

            $videosWithSameSetL = null;
            $videosWithSameSetR = null;

            $contentSetName = null;
            $author = optional($educationalContent->user)->getfullName();

            [
                $contentsWithSameSet,
                $contentSetName
            ] = $educationalContent->getSetMates();
            $contentsWithSameSet = $contentsWithSameSet->normalMates();
            $videosWithSameSet = optional($contentsWithSameSet)->whereIn("type", "video");
            $pamphletsWithSameSet = optional($contentsWithSameSet)->whereIn("type", "pamphlet");
            [
                $videosWithSameSetL,
                $videosWithSameSetR
            ] = optional($videosWithSameSet)->partition(function ($i) use ($educationalContent) {
                return $i["content"]->id < $educationalContent->id;
            });

            //TODO: replace metaTag Mod with contentType
            switch (optional($educationalContent->template)->name) {
                case "video1":
                    $metaTagMod = 1;
                    break;
                case  "pamphlet1":
                    $metaTagMod = 2;
                    break;
                case "article" :
                    $metaTagMod = 3;
                    break;
                default:
                    $metaTagMod = 4;
                    break;
            }

            return [
                $author,
                $educationalContent,
                $contentsWithSameSet,
                $videosWithSameSet,
                $videosWithSameSetL,
                $videosWithSameSetR,
                $pamphletsWithSameSet,
                $contentSetName,
                $metaTagMod
            ];

        });
        return [
            $author, $educationalContent, $contentsWithSameSet, $videosWithSameSet, $videosWithSameSetL, $videosWithSameSetR, $pamphletsWithSameSet, $contentSetName, $metaTagMod
        ];
    }
}
