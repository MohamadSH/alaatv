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
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{
    Config, File, Input
};
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;


class ContentController extends Controller
{

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

            $result = compact( "seenCount","author", "content", "rootContentType", "childContentType", "contentsWithSameType", "soonContentsWithSameType", "contentSet", "contentsWithSameSet", "videosWithSameSet", "pamphletsWithSameSet", "contentSetName", "videoSources"
              , "tags", "sideBarMode", "userCanSeeCounter", "adItems", "videosWithSameSetL", "videosWithSameSetR","contentId");

//            return ("sohrab");
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
        //TODO:// validate Data Format in Requests
        $content = new Content();
        $contentset_id = $request->get("contentset_id");
        $order = $request->get("order");
        $this->fillContentFromRequest($request, $content);

        if($content->save()){
            if(isset($contentset_id))
                $this->attachContentSetToContent($content, $contentset_id,$order);
            return $this->response
                ->setStatusCode(Response::HTTP_OK )
                ->setContent(["id"=>$content->id]);
        }
        return $this->response
            ->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE) ;
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
        $this->fillContentFromRequest($request, $content);

        //TODO:// update default contentset
        if($content->update()){
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
        //TODO:// remove Tags From Redis, ( Do it in ContentObserver)
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



    /**
     * @param $time
     * @param $validSince
     * @return null|string
     */
    private function getValidSinceDateTime($time, $validSince): string
    {
        if (isset($time)) {
            if (strlen($time) > 0)
                $time = Carbon::parse($time)->format('H:i:s');
            else
                $time = "00:00:00";
        }
        if (isset($validSince)) {
            $validSince = Carbon::parse($validSince)->format('Y-m-d'); //Muhammad : added a day because it returns one day behind and IDK why!!
            if (isset($time))
                $validSince = $validSince . " " . $time;
            return $validSince;
        }
        return null;
    }

    /**
     * @param $tagString
     * @return array
     */
    private function getTagsArrayFromTagString($tagString): array
    {
        $tags = explode(",", $tagString);
        $tags = array_filter($tags);
        return $tags;
    }

    /**
     * @param Content $content
     * @param $contentset_id
     * @param $order
     * @param int $isDefault
     */
    private function attachContentSetToContent(Content &$content, $contentset_id,$order, $isDefault = 1): void
    {
        //TODO:// handle Not Default ContentSets Like WatchLater ContentSet or Favorite ContentSet For a User
        $pivots = [];
        $pivots["order"] = isset($order) ? $order : 0;
        $pivots["isDefault"] = $isDefault;
        $content->contentsets()->attach($contentset_id, $pivots);
    }

    /**
     * @param $fileName
     * @return boolean
     */
    private function strIsEmpty($str):bool
    {
        return strlen(preg_replace('/\s+/', '', $str)) == 0 ;
    }

    /**
     * @param Content $content
     *
     * @param array $files
     */
    private function storeFilesOfContent(Content &$content, array $files):void
    {
        $disk = $content->isFree ? config("constants.DISK_FREE_CONTENT") : config("constants.DISK_PRODUCT_CONTENT");

        $fileCollection = collect();

        foreach ($files as $key => $file) {
            $fileName = $file->name;
            $caption = $file->caption;
            $res = $file->res;
            $type = $file->type;
            if ($this->strIsEmpty($fileName))
                continue;
            $fileCollection->push([
                "uuid" => Str::uuid()->toString(),
                "disk" => $disk,
                "url" => null,
                "fileName" => $fileName,
                "size" => null,
                "caption" => $caption,
                "res" => $res,
                "type" => $type,
                "ext" => pathinfo($fileName, PATHINFO_EXTENSION)
            ]);
        }
        $content->file = $fileCollection;
    }

    /**
     * @param FormRequest $request
     * @param Content $content
     * @return void
     */
    private function fillContentFromRequest(FormRequest $request, Content &$content):void
    {
        $inputData = $request->all();
        $time = $request->get("validSinceTime");
        $validSince = $request->get("validSinceDate");
        $enabled = $request->has("enable");
        $tagString = $request->get("tags");
        $files = $request->get("files");

        $content->fill($inputData);
        $content->validSince = $this->getValidSinceDateTime($time, $validSince);
        $content->enable = $enabled ? 1 : 0;
        $content->tags = $this->getTagsArrayFromTagString($tagString);

        if (isset($files))
            $this->storeFilesOfContent($content, $files);
    }
}
