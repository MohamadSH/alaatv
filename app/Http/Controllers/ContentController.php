<?php

namespace App\Http\Controllers;

use App\Classes\SEO\SeoMetaTagsGenerator;
use App\Contentset;
use App\Contenttype;
use App\Content;
use App\User;
use App\Http\Requests\{
    EditContentRequest, InsertContentFileCaption, InsertContentRequest, InsertFileRequest, Request
};
use App\Traits\{
    APIRequestCommon, FileCommon, Helper, ProductCommon, UserSeenTrait
};

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{
    Config, File, Input
};
use Jenssegers\Agent\Agent;


class ContentController extends Controller
{
    use APIRequestCommon;
    protected $response ;
    protected $setting ;

    use ProductCommon ;
    use Helper;
    use FileCommon ;
    use UserSeenTrait;
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
        $this->response = $response;
        $this->setting = json_decode(app('setting')->setting);
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
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
                $contents = Content::orderBy("created_at" , "DESC");
            else abort(403) ;
        }
        else
            $contents = Content::enable()->valid()->orderBy("validSince","DESC");

        if(Input::has("searchText"))
        {
            $text = Input::get("searchText");
            if(strlen(preg_replace('/\s+/', '', $text)) >0)
            {
                $words = explode(" " , $text);
                $contents = $contents->where(function ($q) use ($words) {
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
                $contents = $contents->whereHas("majors" , function ($q) use ($majorsId){
                    $q->whereIn("id" , $majorsId);
                });
        }

        if(Input::has("grades"))
        {
            $gradesId = Input::get("grades");
            if(!in_array(  0 , $gradesId))
                $contents = $contents->whereHas("grades", function ($q) use ($gradesId) {
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
                    $contents = $contents->whereHas("contenttypes" , function ($q) use ($id)
                    {
                        $q->where("id" , $id ) ;
                    });
                }
            }

        }

        $contents = $contents->get();
        if(Input::has("columns"))
            $columns = Input::get("columns");
        return view("content.index" , compact("contents" , "columns"));
    }

    public function embed(Request $request , Content $content){
        $url = action('ContentController@show', $content);
        $this->generateSeoMetaTags($content);
        //TODO: use Content Type instead of template_id
        if($content->template_id != 1)
            return redirect($url, 301);
        $video = $content;

        [
            $contentsWithSameSet ,
            $contentSetName
        ]  = $video->getSetMates();
        $files = $video->files;

        return view("content.embed",compact('video','files','contentsWithSameSet','contentSetName'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rootContentTypes = $this->getRootsContentTypes();
        $contentsets = Contentset::latest()
                                ->pluck("name" , "id");
        $authors = $this->getTeachers();

        return view("content.create2" , compact("rootContentTypes" ,
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

        return view("content.create3" , compact("contenttypes")) ;
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Content $content
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(Request $request, Content $content)
    {
        if ($content->isActive()) {

            $sideBarMode = "closed";
            $adItems = $content->getAddItems();
            $tags = $content->retrievingTags();
            [
                $author, $content, $contentsWithSameSet, $videosWithSameSet, $videosWithSameSetL, $videosWithSameSetR, $pamphletsWithSameSet, $contentSetName
            ] = $this->getContentInformation($content);

            $this->generateSeoMetaTags($content);

            $seenCount = $this->getSeenCountFromRequest($request);

            $userCanSeeCounter = optional(auth()->user())->CanSeeCounter();

            $result = compact( "seenCount","author", "content", "rootContentType", "childContentType", "contentsWithSameType", "soonContentsWithSameType", "contentSet", "contentsWithSameSet", "videosWithSameSet", "pamphletsWithSameSet", "contentSetName", "videoSources",
                "files", "tags", "sideBarMode", "contentDisplayName", "sessionNumber", "fileToShow", "userCanSeeCounter", "adItems", "videosWithSameSetL", "videosWithSameSetR");

            dd($result);
            return view("content.show", $result);
        } else
            abort(403);
    }

    private function generateSeoMetaTags(Content $content)
    {
        try {
            $seo = new SeoMetaTagsGenerator($content);
        } catch (\Exception $e) {
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content   $content
     * @return \Illuminate\Http\Response
     */
    public function edit($content)
    {
        $validSinceTime = optional($content->validSince)->format('H:i:s');
        $tags = optional($content->tags)->tags;
        $tags = implode(",", isset($tags) ? $tags : []);
        $contentset = $content->contentset;
        $rootContentTypes = $this->getRootsContentTypes();

        $result = compact("content" ,"rootContentTypes" ,"validSinceTime" ,"tags" ,"contentset" ,"rootContentTypes" );
        return view("content.edit" , $result) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InsertContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertContentRequest $request)
    {

        try
        {
            $content = new Content();
            $content->fill($request->all()) ;
            if(is_null($content->order))
                $content->order = 0;
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
                $content->validSince = $validSince;
            }

            if($request->has("enable"))
                $content->enable = 1;
            else
                $content->enable = 0 ;

            switch ($content->contenttype_id)
            {
                case 1 : // pamphlet
                    $content->template_id = 2 ;
                    break;
                case 8 : // video
                    $content->template_id = 1;
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
                $content->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
            }

            $done = false ;
            if($content->save()){

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
                        $content->contentsets()->attach($contentset_id);
                    else
                        $content->contentsets()->attach($contentset_id , $pivots);
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
                            $disk = $content->fileMultiplexer();
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
                                $content->files()->attach($fileId);
                            else
                                $content->files()->attach($fileId , $attachPivot);
                        }
                    }

                }

                if($content->enable  &&  isset($content->tags) &&
                    is_array($content->tags->tags) &&
                    !empty($content->tags->tags))
                {
                    $itemTagsArray = $content->tags->tags ;
                    $params = [
                        "tags" => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
                    ];

                    if(isset($content->created_at) && strlen($content->created_at) > 0 )
                        $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s" , $content->created_at )->timestamp;

                    $response =  $this->sendRequest(
                        config("constants.TAG_API_URL")."id/content/".$content->id ,
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
                        ->setContent(["id"=>$content->id]);
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditContentRequest  $request
     * @param  \App\Content   $content
     * @return \Illuminate\Http\Response
     */
    public function update(EditContentRequest $request, $content)
    {
        $content->fill($request->all()) ;

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
            $content->validSince = $validSince;
        }

//        if($request->has("contenttype_id"))
//        {
//            $content->contenttype_id = $request->get("contenttype_id");
//        }

        if($request->has("enable"))
            $content->enable = 1;
        else
            $content->enable = 0 ;

        if($request->has("tags"))
        {
            $tagString = $request->get("tags") ;
            $tags = explode("," , $tagString);
            $tags = array_filter($tags);
            $tagsJson = [
                "bucket" => "content",
                "tags" => $tags
            ];
            $content->tags = json_encode($tagsJson, JSON_UNESCAPED_UNICODE);
        }

        if($content->update()){

//            if($request->has("contentsets"))
//            {
//                $contentSets = $request->get("contentsets");
//                foreach ($contentSets as $contentSet)
//                {
//                    if(isset($contentSet["order"]))
//                        $content->contentsets()->sync($contentSet["id"] , ["order"=>$contentSet["order"]]);
//                    else
//                        $content->contentsets()->sync($contentSet["id"]);
//                }
//            }

//            if($request->has("majors"))
//            {
//                $majors = $request->get("majors") ;
//                $content->majors()->sync($majors);
//            }
//
//            if($request->has("grades"))
//            {
//                $grades = $request->get("grades") ;
//                $content->grades()->sync($grades);
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
                        $disk = $content->fileMultiplexer();
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
                            $content->files()->attach($fileId);
                        else
                            $content->files()->attach($fileId , $attachPivot);
                    }
                }
            }

            if($content->enable  &&  isset($content->tags) &&
                is_array($content->tags->tags) &&
                !empty($content->tags->tags))
            {
                $itemTagsArray = $content->tags->tags ;
                $params = [
                    "tags" => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
                ];

                if(isset($content->created_at) && strlen($content->created_at) > 0 )
                    $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s" , $content->created_at )->timestamp;

                $response =  $this->sendRequest(
                    config("constants.TAG_API_URL")."id/content/".$content->id ,
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
     * @param  \App\Content $content
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($content)
    {
        if ($content->delete()){
            return $this->response->setStatusCode(Response::HTTP_OK) ;
        }
        else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE) ;
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
        return redirect('/c',Response::HTTP_MOVED_PERMANENTLY);
    }


    /**
     * Search for an educational content
     *
     * @param \App\Content $content
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function detachFile($content , $file)
    {
        if($content->files()->detach($file))
        {
            session()->put('success', __('content.File Removed Successful'));
            return $this->response->setStatusCode(Response::HTTP_OK ) ;
        }else{
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE) ;
        }
    }

    /**
     * String the caption of content file
     *
     * @param \App\Http\Requests\InsertContentFileCaption $request
     * @param \App\Content $content
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function storeFileCaption(InsertContentFileCaption $request , Content $content , File $file)
    {
        $caption = $request->get("caption");
        if(strcmp($content->files()->where("id" , $file->id)->get()->first()->pivot->caption , $caption) == 0)
            return $this->response->setStatusCode(501)->setContent("لطفا کپشن جدید وارد نمایید");
        if($content->files()->updateExistingPivot($file->id ,["caption" => $caption]))
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
             $lastContent = $contentset->contents->sortByDesc("pivot.order")->first() ;
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

             return redirect(action("ContentController@edit" , $newContent->id));
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
     * @param Content $content
     * @return array
     */
    private function getContentInformation(Content $content): array
    {
        $author = $content->author;

        [
            $contentsWithSameSet,
            $contentSetName
        ] = $content->getSetMates();
        $contentsWithSameSet = $contentsWithSameSet->normalMates();
        $videosWithSameSet = optional($contentsWithSameSet)->whereIn("type", "video");
        $pamphletsWithSameSet = optional($contentsWithSameSet)->whereIn("type", "pamphlet");
        [
            $videosWithSameSetL,
            $videosWithSameSetR
        ] = optional($videosWithSameSet)->partition(function ($i) use ($content) {
            return $i["content"]->id < $content->id;
        });

        return [
            $author, $content, $contentsWithSameSet, $videosWithSameSet, $videosWithSameSetL, $videosWithSameSetR, $pamphletsWithSameSet, $contentSetName
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private function getRootsContentTypes()
    {
        $rootContentTypes = Contenttype::whereDoesntHave("parents")->get();
        return $rootContentTypes;
    }

    /**
     * @return Collection
     */
    private function getTeachers(): Collection
    {
        $authors = User::whereHas("roles", function ($q) {
            $q->where("name", "teacher");
        })->get()
            ->sortBy("lastName")
            ->values()
            ->pluck("full_name", "id");
        return $authors;
    }

    /**
     * @param $authException
     */
    private function callMiddlewares($authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'), ['only' => ['store', 'create', 'create2']]);
        $this->middleware('permission:' . Config::get("constants.EDIT_EDUCATIONAL_CONTENT"), ['only' => ['update', 'edit']]);
        $this->middleware('permission:' . Config::get("constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS"), ['only' => 'destroy']);
    }


}
