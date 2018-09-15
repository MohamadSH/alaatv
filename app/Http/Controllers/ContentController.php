<?php

namespace App\Http\Controllers;

use App\Classes\Search\ContentSearch;
use App\Classes\SEO\SeoMetaTagsGenerator;
use App\Contentset;
use App\Contenttype;
use App\Content;
use App\Grade;
use App\Major;
use App\Product;
use App\User;
use App\Http\Requests\{
    ContentIndexRequest, EditContentRequest, InsertContentRequest, Request
};
use App\Traits\{
    APIRequestCommon, FileCommon, Helper, ProductCommon, UserSeenTrait
};

use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{
    Config, Input, View
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
    use APIRequestCommon;

    private function getAuthExceptionArray(Agent $agent): array
    {
        if ($agent->isRobot())
        {
            $authException = ["index" , "show" , "search" ,"embed" ];
        }else{
            $authException = ["index" ,"search"  ];
        }
        //TODO:// preview(Telegram)
        $authException = ["index" , "show" , "search" ,"embed","attachContentToContentSet" ];
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
     * @param ContentIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ContentIndexRequest $request)
    {
        $itemTypes = array_filter($request->get('itemTypes',
            ["video" , "pamphlet" , "article"]
        ));
        $isApp = ( strlen(strstr($request->header('User-Agent'),"Alaa")) > 0 )? true : false ;
        $queryResult = ( new ContentSearch )->apply($request->all());

        dump($queryResult);
        dump($queryResult->currentPage());
        dump($queryResult->nextPageUrl());
        $contents = $queryResult->onlyItemTypes($itemTypes);
        //VideoSearch, PamphletSearch
        return $contents;
        dd($contents);

        //TODO:// add itemType Filter
        foreach ($itemTypes as $itemType)
        {
            // $arrayOfId get from Redis ( add itemType tags to redis request )
            $arrayOfId = [];
            $query = Content::whereIn("id",$arrayOfId)
                ->active()
                ->orderBy("created_at" , "desc")
                ->get();
            if($isApp){
                $items->push($query);
            }else {
                if ($total_items_db > 0)
                    $partialSearch = $this->getPartialSearchFromIds($request, $query, $itemType, $perPage, $total_items_db, $pageName);
                else
                    $partialSearch = null;
                $items->push([
                    "type"=>$itemType,
                    "totalitems"=> $total_items_db,
                    "view"=>$partialSearch,
                ]);
            }

        }
        if($isApp){
            $response = $this->makeJsonForAndroidApp($items);
            return response()->json($response,200);
        }
        /**
        //درسی که به عنوان انتخاب شده در صفحه نشان داده میشه
        //["value"=>"آمار_و_مدلسازی"]
        $defaultLesson = null;
        $majorCollection = collect([
            [
                "name"=>"همه رشته ها" ,
                "description"=>""//قراره تگ قرار بگیره
            ]
        ]);
        $lessons= $lessons->merge(collect([
                [
                    "value"=>"",  // تگ درس
                    "initialIndex"=>"همه دروس"
                ]
            ]
        ));
        $majorLesson = collect();
        $majorLesson->put( $major["description"], $lessons);

         * $defaultMajor
         * $gradeCollection->push(["displayName"=>"اول دبیرستان" , "description"=>"اول_دبیرستان"]);
         * $defaultGrade
         * $defaultTeacher
         *
         * $lessonTeacher
        **/
        /**
        $lessonTeacher = collect(
            [
                "" => collect(
                    [
                        ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                        ["lastName"=>"ثابتی" , "firstName"=>"محمد صادق" , "value"=>"محمد_صادق_ثابتی"],
                    ]
                )
            ]
        );
         * **/


        /**
         * End of page inputs
         */

        if(request()->ajax())
        {
            return $this->response
                ->setStatusCode(200)
                ->setContent([
                    "items"=>$items ,
                    "itemTypes"=>$itemTypes ,
                    "tagLabels" => $tagInput ,
                ]);
        }
        else
        {

            $sideBarMode = "closed";
//            $ads1 = [
//                //DINI SEBTI
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-1.jpg' => 'https://sanatisharif.ir/landing/4',
//            ];
//            $ads2 = [
//                //DINI SEBTI
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-2.jpg' => 'https://sanatisharif.ir/landing/4',
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-3.jpg' => 'https://sanatisharif.ir/landing/4',
//            ];
            $ads1 = [];
            $ads2 = [];
            return view("pages.search" , compact("items" ,"itemTypes" ,"tagArray" , "extraTagArray",
                "majors" , "grades"  , "defaultLesson" , "sideBarMode" , "majorLesson" , "lessonTeacher" , "defaultTeacher"
                , "ads1" , "ads2" , 'tagInput' ,'defaultGrade' , 'defaultMajor' ));
        }
    }

    public function embed(Request $request , Content $content){
        $url = action('ContentController@show', $content);
        $this->generateSeoMetaTags($content);
        if($content->contenttype_id != Content::CONTENT_TYPE_VIDEO)
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
        $authors =User::getTeachers()->pluck("full_name", "id");

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
        $contenttypes->put(Content::CONTENT_TYPE_VIDEO , "فیلم");
        $contenttypes->put(Content::CONTENT_TYPE_PAMPHLET , "جزوه");

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
        /* files
         {
            {
                fileName --> required
                caption
                res
                type
                res
            },
            {
                        fileName
                caption
                res
                type
                res
            }
        }
        */
        $content = new Content();
        $contentset_id = $request->get("contentset_id");
        $order = $request->get("order");
        $this->fillContentFromRequest($request, $content);

        if($content->save()){
            if(isset($contentset_id))
                $this->attachContentSetToContent($content, $contentset_id,$order);
            return $this->response
                ->setStatusCode(Response::HTTP_OK )
                ->setContent([
                    "id"=>$content->id
                ]);
        }
        return $this->response
            ->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE) ;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function basicStore(Request $request)
    {
        $contentset_id = $request->get("contentset_id");
        $contenttype_id = $request->get("contenttype_id");
        $name = $request->get("name");
        $order = $request->get("order");
        $fileName = $request->get("fileName");
        $dateNow = Carbon::now();

        $contentset = Contentset::FindOrFail($contentset_id);
        $lastContent = $contentset->getLastContent();

        if(isset($lastContent))
            $newContent = $lastContent->replicate();
        else
        {
            session()->put("error" , trans('content.No previous content found'));
            return redirect()->back();
        }
        if($newContent instanceof Content){
            $newContent->contenttype_id = $contenttype_id ;
            $newContent->name = $name;
            $newContent->description = null;
            $newContent->metaTitle = null;
            $newContent->metaDescription = null;
            $newContent->enable = 0;
            $newContent->validSince = $dateNow;
            $newContent->created_at = $dateNow;
            $newContent->updated_at = $dateNow;

            $files = $this->makeVideoFileArray($fileName , $contentset_id);

            $thumbnailUrl          = $this->makeThumbnailUrlFromFileName($fileName, $contentset_id);
            $newContent->thumbnail = $this->makeThumbanilFile($thumbnailUrl);
            $this->storeFilesOfContent($newContent, $files);

            $newContent->save();
            if(!isset($order))
                $order = $lastContent->pivot->order + 1;
            $this->attachContentSetToContent($newContent,$contentset->id,$order);

            return redirect(action("ContentController@edit" , $newContent->id));
        }else
            throw new Exception("replicate Error!". $contentset_id);
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
     * @param $authException
     */
    private function callMiddlewares($authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'), ['only' => ['store', 'create', 'create2']]);
        $this->middleware('permission:' . Config::get("constants.EDIT_EDUCATIONAL_CONTENT"), ['only' => ['update', 'edit']]);
        $this->middleware('permission:' . Config::get("constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS"), ['only' => 'destroy']);
        $this->middleware('convert:order|title', ['only' => ['store' , 'update']]);
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
    private function attachContentSetToContent(Content &$content, $setId,$order, $isDefault = 1 ): void
    {
        $content->contentsets()->attach($setId, [
            "order" =>isset($order) ? $order : 0,
            "isDefault" => $isDefault
        ]);
    }

    //TODO:// implement
    public function attachContentToContentSet(Request $request, Content $content, Contentset $set){
        abort(Response::HTTP_FORBIDDEN);
        /*$order = $request->get('order', 0);
        $this->attachContentSetToContent($content, $set, $order,0);*/
    }
    public function updateContentSetPivots(Request $request, Content $content, Contentset $set){
        abort(Response::HTTP_FORBIDDEN);
        /*$order = $request->get('order', 0);
        $content->contentsets()
            ->updateExistingPivot($set->id, [
                'order' => $order
            ], false);*/
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
            $fileName = isset($file->name) ? $file->name : null;
            $caption = isset($file->caption) ? $file->caption : null;
            $res = isset($file->res) ? $file->res : null;
            $type = isset($file->type) ? $file->type : null;
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
        $files = json_decode($request->get("files"));

        $content->fill($inputData);
        $content->validSince = $this->getValidSinceDateTime($time, $validSince);
        $content->enable = $enabled ? 1 : 0;
        $content->tags = $this->getTagsArrayFromTagString($tagString);

        if (isset($files))
            $this->storeFilesOfContent($content, $files);
    }

    public function makeVideoFileArray($fileName,$contentset_id) :array {
        $fileUrl = [
            "720p" =>   "/media/".$contentset_id."/HD_720p/".$fileName,
            "480p" => "/media/".$contentset_id."/hq/".$fileName,
            "240p" =>"/media/".$contentset_id."/240p/".$fileName
        ];
        $files = [];
        $files[] = $this->makeVideoFileStdClass($fileUrl["240p"],"240p");

        $files[] = $this->makeVideoFileStdClass($fileUrl["480p"],"480p");

        $files[] = $this->makeVideoFileStdClass($fileUrl["720p"],"720p");
        return $files;
    }
    /**
     * @param $filename
     * @param $res
     * @return \stdClass
     */
    private function makeVideoFileStdClass($filename, $res): \stdClass
    {
        $file = new \stdClass();
        $file->name = $filename;
        $file->res = $res;
        $file->caption = Content::videoFileCaptionTable()[$res];
        $file->type = "video";
        return $file;
    }

    /**
     * @param $thumbnailUrl
     * @return array
     */
    private function makeThumbanilFile($thumbnailUrl): array
    {
        return [
            "uuid" => Str::uuid()->toString(),
            "disk" => "alaaCdnSFTP",
            "url" => $thumbnailUrl,
            "fileName" => parse_url($thumbnailUrl)['path'],
            "size" => null,
            "caption" => null,
            "res" => null,
            "type" => "thumbnail",
            "ext" => pathinfo(parse_url($thumbnailUrl)['path'], PATHINFO_EXTENSION)
        ];
    }

    /**
     * @param $fileName
     * @param $contentset_id
     * @return string
     */
    private function makeThumbnailUrlFromFileName($fileName, $contentset_id): string
    {
        $baseUrl = "https://cdn.sanatisharif.ir/media/";
        //thumbnail
        $thumbnailFileName = pathinfo($fileName, PATHINFO_FILENAME) . ".jpg";
        $thumbnailUrl = $baseUrl . "thumbnails/" . $contentset_id . "/" . $thumbnailFileName;
        return $thumbnailUrl;
    }


    private function getPartialSearchFromIds(Request $request, $query, string $itemType, int $perPage, int $total_items_db,string $pageName){
        $options = [
            "pageName" => $pageName
        ];
        $query = new LengthAwarePaginator(
            $query,
            $total_items_db,
            $perPage,
            null  ,
            $options
        );
        switch ($itemType)
        {
            case "video":
                $query->load('files');
                break;
            case "pamphlet":
            case "article":
                break;
            case "contentset":
                $query->load('contents');
                break;
            case "product":
                break;
        }
        $partialSearch = View::make(
            'partials.search.'.$itemType,
            [
                'items' => $query
            ]
        )->render();
        return $partialSearch;
    }
    private function makeJsonForAndroidApp(Collection $items){
        $items = $items->pop();
        $key = md5($items->pluck("id")->implode(","));
        $response = Cache::remember($key,Config::get("constants.CACHE_60"),function () use($items){
            $response = collect();
            $items->load('files');
            foreach ($items as $item){
                $hq = "";
                $h240 ="" ;
                if (isset($item->files)) {
                    $hq= $item->files->where('pivot.label','hq')->first();

                    if (isset($hq)) {
                        $hq = $hq->name;
                        $h240 = $hq;
                    }
                }

                if (isset($item->files)) {
                    $temp = $item->files->where('pivot.label','240p')->first();
                    if (isset($temp)) {
                        $h240 = $temp->name;
                    }
                }

                $thumbnail = $item->files->where('pivot.label','thumbnail')->first();
                $contenSets = $item->contentsets->where("pivot.isDefault" , 1)->first();
                $sessionNumber = $contenSets->pivot->order;
                $response->push(
                    [
                        "videoId" => $item->id,
                        "name" => $item->display_name,
                        "videoDescribe" => $item->description,
                        "url" => action('ContentController@show',$item),
                        "videoLink480" => $hq,
                        "videoLink240" => $h240,
                        "videoviewcounter" =>"0",
                        "videoDuration" => 0,
                        "session" => $sessionNumber."",
                        "thumbnail" => (isset($thumbnail->name))?$thumbnail->name:""
                    ]
                );
                //dd($response);
                //return response()->make("ok");
            }
            $response->push(json_decode("{}"));
            return $response;
        });
        return $response;
    }
}
