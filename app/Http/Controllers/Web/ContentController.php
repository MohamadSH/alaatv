<?php

namespace App\Http\Controllers\Web;

use App\User;
use Exception;
use App\Content;
use Carbon\Carbon;
use App\Contentset;
use App\Contenttype;
use App\Websitesetting;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{Cache};
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Collection\ProductCollection;
use App\Classes\Search\ContentSearch;
use App\Classes\Search\ProductSearch;
use Illuminate\Http\RedirectResponse;
use App\Classes\Search\ContentsetSearch;
use App\Http\Requests\{Request, EditContentRequest, ContentIndexRequest, InsertContentRequest};
use App\Traits\{Helper,
    FileCommon,
    MetaCommon,
    SearchCommon,
    RequestCommon,
    ProductCommon,
    CharacterCommon,
    APIRequestCommon,
    Content\ContentControllerResponseTrait};

class ContentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */
    
    use ProductCommon;
    use Helper;
    use FileCommon;
    use RequestCommon;
    use APIRequestCommon;
    use CharacterCommon;
    use MetaCommon;
    use SearchCommon;
    use ContentControllerResponseTrait;
    
    protected $setting;
    
    
    public function __construct(
        Agent $agent,
        Websitesetting $setting
    )
    {
        $this->setting = $setting->setting;
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
    }
    
    /**
     * @param  Agent  $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(Agent $agent): array
    {
        if ($agent->isRobot()) {
            $authException = [
                "index",
                "show",
                "embed",
            ];
        } else {
            $authException = ["index"];
        }
        //TODO:// preview(Telegram)
        $authException = [
            "index",
            "show",
            "search",
            "embed",
            "attachContentToContentSet",
        ];
        
        return $authException;
    }
    
    /**
     * @param $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:'.config('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'), [
            'only' => [
                'store',
                'create',
                'create2',
            ],
        ]);
        $this->middleware('permission:'.config("constants.EDIT_EDUCATIONAL_CONTENT"), [
            'only' => [
                'update',
                'edit',
            ],
        ]);
        $this->middleware('permission:'.config("constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS"),
            ['only' => 'destroy']);
        $this->middleware('convert:order|title', [
            'only' => [
                'store',
                'update',
            ],
        ]);
    }
    
    private function makeJsonForAndroidApp($items): array
    {
        $key = md5(collect($items)
            ->pluck('id')
            ->implode(','));
        return Cache::remember($key, config('constants.CACHE_60'), function () use ($items) {
            $response = [];
        
            /** @var Content $item */
            foreach ($items as $content) {
                $s_hd = $s_hq = $s_240 = null;
            
                foreach ($content->getVideos() as $source) {
                    if (strcmp($source->res, '240p') === 0) {
                        $s_240 = $source->link;
                    
                    } elseif (strcmp($source->res, '480p') === 0) {
                        $s_hq = $source->link;
                    } elseif (strcmp($source->res, '720p') === 0) {
                        $s_hd = $source->link;
                    }
                }
                $response[] = [
                    'videoId'          => $content->id,
                    'name'             => $content->displayName,
                    'videoDescribe'    => $content->description,
                    'url'              => $content->url,
                    'videoLink480'     => $s_hq ?: $s_hd,
                    'videoLink240'     => $s_240 ?: $s_hd,
                    'videoviewcounter' => '0',
                    'videoDuration'    => 0,
                    'session'          => $content->order,
                    'thumbnail'        => $content->thumbnail,
                ];
            }
            $response[] = json_decode('{}', false);
        
            return $response;
        });
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  ContentIndexRequest  $request
     *
     *
     * @param  ContentSearch        $contentSearch
     * @param  ContentsetSearch     $setSearch
     * @param  ProductSearch        $productSearch
     *
     * @return mixed
     */
    public function index(ContentIndexRequest $request, ContentSearch $contentSearch,
        ContentsetSearch $setSearch,
        ProductSearch $productSearch)
    {
        $request->offsetSet('free', $request->get('free', [1]));
        $contentTypes = array_filter($request->get('contentType', Contenttype::List()));
        $contentOnly  = $request->get('contentOnly', false);
        $tags         = (array) $request->get('tags');
        $filters      = $request->all();
//        dd($filters);
        $result = $contentSearch->get(compact('filters', 'contentTypes'));
        
        $result->offsetSet('set', !$contentOnly ? $setSearch->get($filters) : null);
        $result->offsetSet('product', !$contentOnly ? $productSearch->get($filters) : null);
    
        $pageName = 'content-search';
    
        $strstr = strstr($request->header('User-Agent'), 'Alaa');
        $isApp  = ($strstr !== false && $strstr !== '') ? true : false;
        if ($isApp) {
            return response()->json($this->makeJsonForAndroidApp(optional($result->get('video'))
                ->items()));
        }
        $api  = response()->json([
            'result' => $result,
            'tags'   => empty($tags) ? null : $tags,
        ]);
        $view = view('pages.content-search', compact('result', 'contentTypes', 'tags', 'pageName'));
        return httpResponse($api, $view);
    }
    
    public function embed(Request $request, Content $content)
    {
        $url = action('ContentController@show', $content);
        $this->generateSeoMetaTags($content);
        if ($content->contenttype_id !== Content::CONTENT_TYPE_VIDEO) {
            return redirect($url, Response::HTTP_MOVED_PERMANENTLY);
        }
        $video = $content;
        [
            $contentsWithSameSet,
            $contentSetName,
        ] = $video->getSetMates();
    
        $view = view('content.embed', compact('video', 'contentsWithSameSet', 'contentSetName'));
        return httpResponse(null, $view);
    }
    
    public function create()
    {
        $rootContentTypes = Contenttype::getRootContentType();
        $contentsets      = Contentset::latest()
            ->pluck('name', 'id');
        $authors          = User::getTeachers()
            ->pluck('full_name', 'id');
    
        $view = view('content.create2', compact('rootContentTypes', 'contentsets', 'authors'));
        return httpResponse(null, $view);
    }
    
    public function create2()
    {
        $contenttypes = Contenttype::getRootContentType()
            ->pluck('displayName', 'id');
        
        $view = view("content.create3", compact("contenttypes"));
        return httpResponse(null, $view);
    }
    
    public function show(Request $request, Content $content)
    {
        if (!$content->isActive()) {
            abort(Response::HTTP_LOCKED, 'Deactivated!');
        }
        $user_can_see_content        = $this->userCanSeeContent($request, $content, 'web');
        $message                     = null;
        $productsThatHaveThisContent = $content->products() ?: new ProductCollection();
        if (!$user_can_see_content) {
    
            $jsonResponse = $this->getUserCanNotSeeContentJsonResponse($content, $productsThatHaveThisContent,
                static function ($msg) use (&$message) {
                    $message = $msg;
                });
            
            if (request()->expectsJson()) {
                return redirect()->to($content->api_url['v1']);
            }
        }
        $this->generateSeoMetaTags($content);
        $adItems = $content->getAddItems();
        $tags    = $content->retrievingTags();
        [
            $author,
            $content,
            $contentsWithSameSet,
            $videosWithSameSet,
            $videosWithSameSetL,
            $videosWithSameSetR,
            $pamphletsWithSameSet,
            $contentSetName,
        ] = $this->getContentInformation($content);
    
    
        $seenCount = $content->pageView;
        
        $userCanSeeCounter = optional(auth()->user())->CanSeeCounter();
        $apiResponse       = response()->json($content, Response::HTTP_OK);
        $viewResponse      = view('content.show',
            compact('seenCount', 'author', 'content', 'contentsWithSameSet', 'videosWithSameSet',
                'pamphletsWithSameSet', 'contentSetName', 'tags',
                'userCanSeeCounter', 'adItems', 'videosWithSameSetL', 'videosWithSameSetR',
                'productsThatHaveThisContent', 'user_can_see_content', 'message'));
        return httpResponse($apiResponse, $viewResponse);
    }
    
    /**
     * @param  Content  $content
     *
     * @return array
     */
    private function getContentInformation(Content $content): array
    {
        $key = 'getContentInformation: '.$content->id;
        return Cache::tags('set')
            ->remember($key, config('constants.CACHE_600'), function () use ($content) {
                $author = $content->authorName;
                
                [
                    $contentsWithSameSet,
                    $contentSetName,
                ] = $content->getSetMates();
                $contentsWithSameSet  = $contentsWithSameSet->normalMates();
                $videosWithSameSet    = optional($contentsWithSameSet)->whereIn('type', 'video');
                $pamphletsWithSameSet = optional($contentsWithSameSet)->whereIn('type', 'pamphlet');
                [
                    $videosWithSameSetL,
                    $videosWithSameSetR,
                ] = optional($videosWithSameSet)->partition(function ($i) use ($content) {
                    return $i['content']->id < $content->id;
                });
                
                return [
                    $author,
                    $content,
                    $contentsWithSameSet,
                    $videosWithSameSet,
                    $videosWithSameSetL,
                    $videosWithSameSetR,
                    $pamphletsWithSameSet,
                    $contentSetName,
                ];
            });
        
    }
    
    public function edit($content)
    {
        $validSinceTime = optional($content->validSince)->format('H:i:s');
        $tags           = optional($content->tags)->tags;
        $tags           = implode(",", isset($tags) ? $tags : []);
        $contentset     = $content->set;
    
        $result = compact('content', 'rootContentTypes', 'validSinceTime', 'tags',
            'contentset'//            "rootContentTypes"
        );
        
        $view = view("content.edit", $result);
        return httpResponse(null, $view);
    }
    
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
        $this->fillContentFromRequest($request, $content);
        
        if ($content->save()) {
            $api = response()->json([
                "id" => $content->id,
            ]);
            return httpResponse($api, null);
        }
        
        $api1 = response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
        return httpResponse($api1, null);
    }
    
    
    /**
     * @param  Content  $content
     *
     * @param  array    $files
     */
    private function storeFilesOfContent(Content $content, array $files): void
    {
        $disk = $content->isFree ? config('constants.DISK_FREE_CONTENT') : config('constants.DISK_PRODUCT_CONTENT');
        
        $fileCollection = collect();
        
        foreach ($files as $key => $file) {
            $fileName = isset($file->name) ? $file->name : null;
            $caption  = isset($file->caption) ? $file->caption : null;
            $res      = isset($file->res) ? $file->res : null;
            $type     = isset($file->type) ? $file->type : null;
            if ($this->strIsEmpty($fileName)) {
                continue;
            }
            $fileCollection->push([
                'uuid'     => Str::uuid()
                    ->toString(),
                'disk'     => $disk,
                'url'      => null,
                'fileName' => $fileName,
                'size'     => null,
                'caption'  => $caption,
                'res'      => $res,
                'type'     => $type,
                'ext'      => pathinfo($fileName, PATHINFO_EXTENSION),
            ]);
        }
        /** @var TYPE_NAME $content */
        $content->file = $fileCollection;
    }
    
    /**
     * @param  Request  $request
     *
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function basicStore(Request $request)
    {
        $contentset_id  = $request->get('contentset_id');
        $contenttype_id = $request->get('contenttype_id');
        $name           = $request->get('name');
        $order          = $request->get('order');
        $fileName       = $request->get('fileName');
        $dateNow        = Carbon::now();
        
        $contentset  = Contentset::FindOrFail($contentset_id);
        $lastContent = $contentset->getLastContent();
        
        if (isset($lastContent)) {
            $newContent = $lastContent->replicate();
        } else {
            session()->put('error', trans('content.No previous content found'));
            
            return redirect()->back();
        }
        if ($newContent instanceof Content) {
            $newContent->contenttype_id  = $contenttype_id;
            $newContent->name            = $name;
            $newContent->description     = null;
            $newContent->metaTitle       = null;
            $newContent->metaDescription = null;
            $newContent->enable          = 0;
            $newContent->validSince      = $dateNow;
            $newContent->created_at      = $dateNow;
            $newContent->updated_at      = $dateNow;
            
            $files = $this->makeVideoFileArray($fileName, $contentset_id);
            
            $thumbnailUrl          = $this->makeThumbnailUrlFromFileName($fileName, $contentset_id);
            $newContent->thumbnail = $this->makeThumbanilFile($thumbnailUrl);
            $this->storeFilesOfContent($newContent, $files);
            
            $newContent->save();
            if (!isset($order)) {
                //TODO://deprecate
                $order = $lastContent->pivot->order + 1;
            }
            //TODO://deprecate
            $this->attachContentSetToContent($newContent, $contentset->id, $order);
            
            return redirect(action("Web\ContentController@edit", $newContent->id));
        } else {
            throw new Exception('replicate Error!'.$contentset_id);
        }
    }
    
    
    public function update(EditContentRequest $request, $content)
    {
        $this->fillContentFromRequest($request, $content);
        
        //TODO:// update default contentset
        if ($content->update()) {
            session()->put('success', 'اصلاح محتوا با موفقیت انجام شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        return redirect()->back();
    }
    
    public function destroy(Content $content)
    {
        //TODO:// remove Tags From Redis, ( Do it in ContentObserver)
        try {
            if ($content->delete()) {
                return response()->json([], Response::HTTP_OK);
            }
        } catch (Exception $e) {
        }
        return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
    }
    
    /**
     * Search for an educational content
     *
     * @param
     *
     * @return Response
     */
    public function search()
    {
        return redirect('/c', Response::HTTP_MOVED_PERMANENTLY);
    }
    
    
}
