<?php

namespace App\Http\Controllers\Web;

use App\Product;
use App\User;
use Exception;
use App\Content;
use App\Contentset;
use App\Contenttype;
use App\Websitesetting;
use App\Educationalcontent;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{Cache};
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
                'index',
                'show',
                'embed',
            ];
        } else {
            $authException = ['index'];
        }
        //TODO:// preview(Telegram)
        $authException = [
            'index',
            'show',
            'search',
            'embed',
            'attachContentToContentSet',
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
        $this->middleware('permission:'.config('constants.EDIT_EDUCATIONAL_CONTENT'), [
            'only' => [
                'update',
                'edit',
            ],
        ]);
        $this->middleware('permission:'.config('constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS'),
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
    
        if ($items === null)
        {
            $response = [];
            $response[]  = json_decode('{}', false);
            return $response;
        }

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
    
        $strstr = strstr($request->header('User-Agent'), 'Alaa');
        $isApp  = ($strstr !== false && $strstr !== '') ? true : false;
        if ($isApp) {
            $contentSearch->setNumberOfItemInEachPage(200);
        }
        
        $result = $contentSearch->get(compact('filters', 'contentTypes'));
        
        $result->offsetSet('set', !$contentOnly ? $setSearch->get($filters) : null);
        $result->offsetSet('product', !$contentOnly ? $productSearch->get($filters) : null);
    
        $pageName = 'content-search';
    
    
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
        $url = action('Web\ContentController@show', $content);
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
    
    public function create2(Request $request)
    {
//        $contenttypes = Contenttype::getRootContentType()
//            ->pluck('displayName', 'id');
        $contenttypes = [ 8 => 'فیلم' , 1 =>    'جزوه'];

        $setId = $request->get('set');
        $set = Contentset::find($setId);
        if(isset($set))
        {
            $lastContent = $set->getLastContent();
            if($request->expectsJson())
                return response()->json([
                    'lastContent' => $lastContent,
                    'set'       => $set
                ]);

        }elseif(isset($setId)){
            session()->flash('error' , 'ست مورد نظر شما یافت نشد');
        }
    
        $view = view('content.create3', compact('contenttypes', 'lastContent'));
        return httpResponse(null, $view);
    }
    
    public function show(Request $request, Content $content)
    {
        if (!$content->isActive()) {
            abort(Response::HTTP_LOCKED, 'Deactivated!');
        }
        $user_can_see_content        = $this->userCanSeeContent($request, $content, 'web');
        $message                     = null;
        $productsThatHaveThisContent = $content->activeProducts() ?: new ProductCollection();
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
    
//        $productsHasThisContentThroughBlock = Content::select('products.id', 'products.name')
//            ->join('blockables', 'educationalcontents.contentset_id', '=', 'blockables.blockable_id')
//            ->join('products', 'blockables.block_id', '=', 'products.block_id')
//            ->where('blockables.blockable_type', 'App\Contentset')
//            ->where('educationalcontents.id', $content->id)
//            ->get();
        $productsHasThisContentThroughBlockCollection = new ProductCollection();
//        foreach ($productsHasThisContentThroughBlock as $item) {
//            $productsHasThisContentThroughBlockCollection->push(Product::find($item->id));
//        }
        $viewResponse      = view('content.show',
            compact('seenCount', 'author', 'content', 'contentsWithSameSet', 'videosWithSameSet',
                'pamphletsWithSameSet', 'contentSetName', 'tags',
                'userCanSeeCounter', 'adItems', 'videosWithSameSetL', 'videosWithSameSetR',
                'productsThatHaveThisContent', 'user_can_see_content', 'message', 'productsHasThisContentThroughBlockCollection'));
        
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
    
    public function edit(Content $content)
    {
        $validSinceTime = optional($content->validSince)->format('H:i:s');
        $tags           = optional($content->tags)->tags;
        $tags           = implode(',', isset($tags) ? $tags : []);
        $contentset     = $content->set;
    
        $result = compact('content', 'rootContentTypes', 'validSinceTime', 'tags',
            'contentset'//            "rootContentTypes"
        );
    
        $view = view('content.edit', $result);
        return httpResponse(null, $view);
    }
    
    public function store(InsertContentRequest $request)
    {
        $contenttypeId = $request->get('contenttype_id');
        $fileName =       $request->get('fileName');
        $contentsetId=   $request->get('contentset_id');
        $isFree = $request->has('isFree');
        $content = new Content();

        if($isFree)
        {
            [$files , $thumbnail] = $this->makeFreeContentFiles($contenttypeId, $fileName, $contentsetId);
        }else{
            $contentset = Contentset::find($contentsetId);
            $productId = optional($contentset->products->first())->id;
            if(!isset($productId))
                return response()->json(['No product found for this set'], Response::HTTP_BAD_REQUEST);

            [$files , $thumbnail] = $this->makePaidContentFiles($contenttypeId, $fileName , $productId , $contentsetId);
        }

        if(isset($thumbnail))
            $content->thumbnail = $thumbnail;



        $request->offsetSet('files', $files);

        $this->fillContentFromRequest($request->all(), $content);

        $done = false;
        if ($content->save()) {
            $done = true;
        }

        if($request->expectsJson())
        {
            if($done)
            {
                $api = response()->json([
                    'id' => $content->id,
                ]);
                return httpResponse($api, null);

            }
            $api1 = response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
            return httpResponse($api1, null);

        }
//        Cache::tags('content')->flush();
        session()->flash('success' , 'محتوا با موفقیت درج شد. '.'<a href="'.action('Web\ContentController@edit' , $content).'">اصلاح محتوا</a>');
        return redirect()->back();
    }

    /**
     * @param  Content  $content
     *
     * @param  array    $files
     */
    private function storeFilesOfContent(Content $content, array $files): void
    {
        $fileCollection = collect();
        
        foreach ($files as $key => $file) {
            $disk     = isset($file->disk) ? $file->disk : null;
            $fileName = isset($file->name) ? $file->name : null;
            $caption  = isset($file->caption) ? $file->caption : null;
            $res      = isset($file->res) ? $file->res : null;
            $type     = isset($file->type) ? $file->type : null;
            $url      = isset($file->url) ? $file->url : null;
            $size     = isset($file->size) ? $file->size : null;
            if ($this->strIsEmpty($fileName)) {
                continue;
            }
            $fileCollection->push([
                'uuid'     => Str::uuid()->toString(),
                'disk'     => $disk,
                'url'      => $url,
                'fileName' => $fileName,
                'size'     => $size,
                'caption'  => $caption,
                'res'      => $res,
                'type'     => $type,
                'ext'      => pathinfo($fileName, PATHINFO_EXTENSION),
            ]);
        }
        /** @var Content $content */
        $content->file = $fileCollection;
    }
    
    /**
     * @param EditContentRequest $request
     * @param Content $content
     * @return RedirectResponse
     */
    public function update(EditContentRequest $request, Content $content)
    {
        $this->fillContentFromRequest($request->all(), $content);
        
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

    /**
     * @param int $contenttypeId
     * @param int $isFree
     * @param string $fileName
     * @param int $contentsetId
     * @param int $productId
     * @return array
     */
    private function makeFreeContentFiles(int $contenttypeId, string $fileName, int $contentsetId): array
    {
        $thumbnail = null;
        $files = [];
        if ($contenttypeId == config('constants.CONTENT_TYPE_VIDEO')) {
            [$files, $thumbnail] = $this->makeVideoFilesForFreeContent($fileName, $contentsetId);
        } elseif ($contenttypeId == config('constants.CONTENT_TYPE_PAMPHLET')) {
            $files = $this->makePamphletFilesForFreeContent($fileName);
        }
        return [$files , $thumbnail];
    }

    /**
     * @param int $contenttypeId
     * @param string $fileName
     * @param int $productId
     * @param int $contentsetId
     * @return array
     */
    private function makePaidContentFiles(int $contenttypeId,  string $fileName, int $productId , int $contentsetId): array
    {
        $thumbnail = null;
        $files = [];
        if ($contenttypeId == config('constants.CONTENT_TYPE_VIDEO')) {
            [$files, $thumbnail] = $this->makeVideoFilesForPaidContent($fileName, $productId , $contentsetId);
        } elseif ($contenttypeId == config('constants.CONTENT_TYPE_PAMPHLET')) {
            $files = $this->makePahmphletFilesForPaidContent($fileName, $productId);
        }
        return [$files , $thumbnail];
    }

    /**
     * @param string $fileName
     * @param int $productId
     * @param int $contentsetId
     * @return array
     */
    private function makeVideoFilesForPaidContent(string $fileName, int $productId , int $contentsetId): array
    {
        $files = $this->makePaidVideoFileArray($fileName, config('constants.DISK_PRODUCT_CONTENT'), $productId);
        $thumbnailUrl = $this->makeThumbnailUrlFromFileName($fileName, $contentsetId);
        $thumbnail = $this->makeThumbanilFile($thumbnailUrl);
        return [$files, $thumbnail];
    }

    /**
     * @param string $fileName
     * @param int $contentsetId
     * @return array
     */
    private function makeVideoFilesForFreeContent(string $fileName, int $contentsetId): array
    {
        $files = $this->makeFreeVideoFileArray($fileName, config('constants.DISK_FREE_CONTENT'), $contentsetId);
        $thumbnailUrl = $this->makeThumbnailUrlFromFileName($fileName, $contentsetId);
        $thumbnail = $this->makeThumbanilFile($thumbnailUrl);
        return [$files, $thumbnail];
    }

    /**
     * @param string $fileName
     * @param int $productId
     * @return array
     */
    private function makePahmphletFilesForPaidContent(string $fileName, int $productId): array
    {
        $files = $this->makePaidPamphletFileArray($fileName, config('constants.DISK_PRODUCT_CONTENT'), $productId);
        return $files;
    }

    /**
     * @param string $fileName
     * @return array
     */
    private function makePamphletFilesForFreeContent(string $fileName): array
    {
        $files = $this->makeFreePamphletFileArray($fileName, config('constants.DISK19_CLOUD'));
        return $files;
    }


}
