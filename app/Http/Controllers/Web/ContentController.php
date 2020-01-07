<?php

namespace App\Http\Controllers\Web;

use App\Block;
use App\Classes\Search\ContentSearch;
use App\Classes\Search\ContentsetSearch;
use App\Classes\Search\ProductSearch;
use App\Collection\ContentCollection;
use App\Collection\ProductCollection;
use App\Content;
use App\Contentset;
use App\Contenttype;
use App\Http\Controllers\Controller;
use App\Http\Requests\{ContentIndexRequest, EditContentRequest, InsertContentRequest, Request, UpdateContentSetRequest};
use App\Section;
use App\Source;
use App\Traits\{APIRequestCommon,
    CharacterCommon,
    Content\ContentControllerResponseTrait,
    FileCommon,
    Helper,
    MetaCommon,
    ProductCommon,
    RequestCommon,
    SearchCommon
};
use App\User;
use App\Websitesetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{Cache, File, Storage};
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

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

    private $setting;


    public function __construct(Agent $agent, Websitesetting $setting)
    {
        $this->setting = $setting->setting;
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ContentIndexRequest $request
     *
     *
     * @param ContentSearch       $contentSearch
     * @param ContentsetSearch    $setSearch
     * @param ProductSearch       $productSearch
     *
     * @return mixed
     */
    public function index(ContentIndexRequest $request, ContentSearch $contentSearch, ContentsetSearch $setSearch, ProductSearch $productSearch)
    {
        $request->offsetSet('free', $request->get('free', [1]));
        $contentTypes = array_filter($request->get('contentType', Contenttype::List()));
        $contentOnly  = $request->get('contentOnly', false);
        $tags         = (array)$request->get('tags');
        $filters      = $request->all();

        $strstr = strstr($request->header('User-Agent'), 'Alaa');
        $isApp  = ($strstr !== false && $strstr !== '') ? true : false;
        if ($isApp) {
            $contentSearch->setNumberOfItemInEachPage(200);
        }

        $result = $contentSearch->get(compact('filters', 'contentTypes'));

        $setFilters            = $filters;
        $setFilters['enable']  = 1;
        $setFilters['display'] = 1;
        $result->offsetSet('set', !$contentOnly ? $setSearch->get($setFilters) : null);

        $productFilters                    = $filters;
        $productFilters['active']          = 1;
        $productFilters['doesntHaveGrand'] = 1;
        $result->offsetSet('product', !$contentOnly ? $productSearch->get($productFilters) : null);

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

    public function create(Request $request)
    {
        $contenttypes = [8 => 'فیلم', 1 => 'جزوه'];

        $setId       = $request->get('set');
        $set         = Contentset::find($setId);
        $lastContent = null;
        if (isset($set)) {
            $lastContent = $set->getLastContent();
            if ($request->expectsJson())
                return response()->json([
                    'lastContent' => $lastContent,
                    'set'         => $set,
                ]);

        } else if (isset($setId)) {
            session()->flash('error', 'ست مورد نظر شما یافت نشد');
        }

        $view = view('content.create', compact('contenttypes', 'lastContent'));
        return httpResponse(null, $view);
    }

    public function createArticle(Request $request)
    {
        $contenttypes = [8 => 'فیلم', 1 => 'جزوه'];

        $setId       = $request->get('set');
        $set         = Contentset::find($setId);
        $lastContent = null;
        if (isset($set)) {
            $lastContent = $set->getLastContent();
            if ($request->expectsJson())
                return response()->json([
                    'lastContent' => $lastContent,
                    'set'         => $set,
                ]);

        } else if (isset($setId)) {
            session()->flash('error', 'ست مورد نظر شما یافت نشد');
        }

        $view = view('content.createArticle', compact('contenttypes', 'lastContent'));
        return httpResponse(null, $view);
    }

    public function show(Request $request, Content $content)
    {
        $user = $request->user();
        if (isset($content->redirectUrl)) {
            return redirect($content->redirectUrl, Response::HTTP_FOUND, $request->headers->all());
        }

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

        $userCanSeeCounter = optional($user)->CanSeeCounter();
        $apiResponse       = response()->json($content, Response::HTTP_OK);

        $productsHasThisContentThroughBlockCollection = $content->related_products;

//        $recommendedProductsOfThisContent = $content->recommended_products ;

        $contentBlocks = Block::getContentBlocks();

        $isFavored =
            optional(optional(optional(optional($user)->favoredContents())->where('id', $content->id))->get())->isNotEmpty();

        $sources = $content->sources;

        $viewResponse = view('content.show',
            compact('seenCount', 'author', 'content', 'contentsWithSameSet', 'videosWithSameSet',
                'pamphletsWithSameSet', 'contentSetName', 'tags',
                'userCanSeeCounter', 'adItems', 'videosWithSameSetL', 'videosWithSameSetR',
                'productsThatHaveThisContent', 'user_can_see_content', 'message', 'productsHasThisContentThroughBlockCollection', 'contentBlocks', 'isFavored', 'sources'));

        return httpResponse($apiResponse, $viewResponse);
    }

    /**
     * @param InsertContentRequest $request
     *
     * @return RedirectResponse|null
     */
    public function store(InsertContentRequest $request)
    {
        $contentTypeId = $request->get('contenttype_id');
        $fileName      = $request->get('fileName');
        $contentsetId  = $request->get('contentset_id');
        $isFree        = $request->has('isFree');
        $content       = new Content();

        $files = $this->makeContentFilesArray($contentTypeId, $contentsetId, $fileName, $isFree);

        if ($contentTypeId != Content::CONTENT_TYPE_PAMPHLET) {
            $thumbnailFileName = pathinfo(parse_url($fileName)['path'], PATHINFO_FILENAME) . '.jpg';
            $thumbnail         = $this->makeContentThumbnailStd($contentsetId, $thumbnailFileName);

            if (isset($thumbnail)) {
                $content->thumbnail = $thumbnail;
            }
        }

        if (isset($files)) {
            $request->offsetSet('files', $files);
        }

        $this->fillContentFromRequest($request->all(), $content);

        $done = false;
        if ($content->save()) {
            $done = true;
        }

        if ($request->expectsJson()) {
            if ($done) {
                $api = response()->json([
                    'id' => $content->id,
                ]);
                return httpResponse($api, null);

            }
            $api1 = response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
            return httpResponse($api1, null);

        }
        session()->flash('success', 'محتوا با موفقیت درج شد. ' . '<a href="' . action('Web\ContentController@edit', $content) . '">اصلاح محتوا</a>');
        return redirect()->back();
    }

    public function edit(Content $content)
    {
        $validSinceTime = optional($content->validSince)->format('H:i:s');
        $tags           = optional($content->tags)->tags;
        $tags           = implode(',', isset($tags) ? $tags : []);
        /** @var Contentset $contentset */
        $contentset   = $content->set;
        $contenttypes = [8 => 'فیلم', 1 => 'جزوه', 9 => 'مقاله'];
        $sections     = Section::all()->pluck('name', 'id')->toArray();
        $sections[0]  = 'ندارد';
        $sections     = Arr::sortRecursive($sections);

        $sources        = $contentset->sources->pluck('title', 'id')->toArray();
        $contentSources = $content->sources->pluck('id')->toArray();

        $result =
            compact('content', 'validSinceTime', 'tags', 'contentset', 'contenttypes', 'sections', 'sources', 'contentSources');
        $view   = view('content.edit', $result);
        return httpResponse(null, $view);
    }

    /**
     * @param EditContentRequest $request
     * @param Content            $content
     *
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function update(EditContentRequest $request, Content $content)
    {
        $user = $request->user();
        if (!$user->can(config('constants.REDIRECT_EDUCATIONAL_CONTENT_ACCESS'))) {
            $request->offsetUnset('redirectUrl');
        }

        $contentTypeId = $request->get('contenttype_id');
        $contentsetId  = $content->contentset_id;
        $isFree        = $request->has('isFree');

        $fileName =
            basename(optional(optional($content->file_for_admin[$content->contenttype->name])->first())->fileName);
        if (isset($fileName[0])) {
            $files             = $this->makeContentFilesArray($contentTypeId, $contentsetId, $fileName, $isFree);
            $thumbnailFileName = pathinfo(parse_url($fileName)['path'], PATHINFO_FILENAME) . '.jpg';
        }

        if ($content->contenttype_id != Content::CONTENT_TYPE_PAMPHLET) {
            if ($request->hasFile('thumbnail') && isset($content->contentset_id)) {
                $thumbnailFile = $this->getRequestFile($request->all(), 'thumbnail');
                if (!isset($thumbnailFileName)) {
                    $thumbnailFileName = $thumbnailFile->getClientOriginalName();
                }

                if (Storage::disk(config('constants.DISK25'))->put('/' . $content->contentset_id . '/' . $thumbnailFileName, File::get($thumbnailFile))) {
                    Storage::disk(config('constants.DISK25'))->delete('/' . $content->contentset_id . '/' . $thumbnailFileName . '.webp');
                }
            }

            if (isset($thumbnailFileName)) {
                $content->thumbnail = $this->makeContentThumbnailStd($contentsetId, $thumbnailFileName);
            }
        }

        if (isset($files)) {
            $request->offsetSet('files', $files);
        }


        $this->fillContentFromRequest($request->all(), $content);

        if ($request->has('acceptTmpDescription') && $user->can(config('constants.ACCEPT_CONTENT_TMP_DESCRIPTION_ACCESS')) && !is_null($content->tmp_description)) {
            $content->description     = $content->tmp_description;
            $content->tmp_description = null;
        }

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
     * @param Request $request
     *
     * @param Content $content
     *
     * @return RedirectResponse|Redirector
     * @throws FileNotFoundException
     */
    public function updateSet(UpdateContentSetRequest $request, Content $content)
    {
        $newContetnsetId = $request->get("newContetnsetId");
        $newFileFullName = $request->get("newFileFullName");
        $contentTypeId   = $content->contenttype_id;
        $contentsetId    = $content->contentset_id;

        if ($newContetnsetId != $content->contentset_id) {
            $contentsetId = $newContetnsetId;
        }

        if (!isset($newFileFullName)) {
            $newFileFullName =
                basename(optional(optional($content->file_for_admin[$content->contenttype->name])->first())->fileName);
        }

        $files = $this->makeContentFilesArray($contentTypeId, $contentsetId, $newFileFullName, $content->isFree);

        if ($content->contenttype_id != Content::CONTENT_TYPE_PAMPHLET) {
            $thumbnailFileName = pathinfo(parse_url($newFileFullName)['path'], PATHINFO_FILENAME) . '.jpg';
            $thumbnail         = $this->makeContentThumbnailStd($contentsetId, $thumbnailFileName);
            if (isset($thumbnail)) {
                $content->thumbnail = $thumbnail;
            }

        }

        if (!empty($files)) {
            $this->makeFilesCollection($content, $files);
        }
        Cache::tags([
            'content_' . $content->id,
            'set_' . $newContetnsetId,
            'set_' . $content->contentset_id,
        ])->flush();
        $content->contentset_id = $contentsetId;
        if ($content->update()) {
            session()->flash('success', 'تغییر نام با موفقیت انجام شد');
        } else {
            session()->flash('error', 'خطا در اصلاح ست');
        }

        return redirect()->back();
    }

    public function indexPendingDescriptionContent()
    {
        $contents = Content::whereNotNull('tmp_description')->paginate(10, ['*']);

        return view('content.listPendingDescription', compact('contents'));
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

    public function uploadContent()
    {
        $rootContentTypes = Contenttype::getRootContentType();
        $contentsets      = Contentset::latest()
            ->pluck('name', 'id');
        $authors          = User::getTeachers()
            ->pluck('full_name', 'id');

        $view = view('content.uploadContent', compact('rootContentTypes', 'contentsets', 'authors'));
        return httpResponse(null, $view);
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param int    $contenttypeId
     * @param int    $isFree
     * @param string $fileName
     * @param int    $contentsetId
     * @param int    $productId
     *
     * @return array
     */
    private function makeFreeVideoFiles(string $fileName, int $contentsetId): array
    {
        $serverUrl        = config('constants.DOWNLOAD_SERVER_PROTOCOL') . config('constants.CDN_SERVER_NAME');
        $mediaPartialPath = config('constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH');

        $fileUrl = [
            '720p' => [
                'url'         => $serverUrl . $mediaPartialPath . $contentsetId . '/HD_720p/' . $fileName,
                'partialPath' => $mediaPartialPath . $contentsetId . '/HD_720p/' . $fileName,
            ],
            '480p' => [
                'url'         => $serverUrl . $mediaPartialPath . $contentsetId . '/hq/' . $fileName,
                'partialPath' => $mediaPartialPath . $contentsetId . '/hq/' . $fileName,
            ],
            '240p' => [
                'url'         => $serverUrl . $mediaPartialPath . $contentsetId . '/240p/' . $fileName,
                'partialPath' => $mediaPartialPath . $contentsetId . '/240p/' . $fileName,
            ],
        ];

        return $this->makeFilesArray($fileUrl, config('constants.DISK_FREE_CONTENT'));
    }

    /**
     * @param string $fileName
     * @param int    $productId
     * @param int    $contentsetId
     *
     * @return array
     */
    private function makePaidVideoFiles(string $fileName, int $productId): array
    {
        $fileUrl = [
            '720p' => [
                'partialPath' => '/paid/' . $productId . '/video/HD_720p/' . $fileName,
                'url'         => null,
            ],
            '480p' => [
                'partialPath' => '/paid/' . $productId . '/video/hq/' . $fileName,
                'url'         => null,
            ],
            '240p' => [
                'partialPath' => '/paid/' . $productId . '/video/240p/' . $fileName,
                'url'         => null,
            ],
        ];

        return $this->makeFilesArray($fileUrl, config('constants.DISK_PRODUCT_CONTENT'));
    }

    /**
     * @param string $fileName
     *
     * @return array
     */
    private function makeFreePamphletFiles(string $fileName): array
    {
        $files[] = $this->makePamphletFileStdClass($fileName, config('constants.DISK19_CLOUD'));
        return $files;
    }

    /**
     * @param string $fileName
     * @param int    $productId
     *
     * @return array
     */
    private function makePaidPamphletFiles(string $fileName, int $productId): array
    {
        $files[] =
            $this->makePamphletFileStdClass("/paid/" . $productId . "/" . $fileName, config('constants.DISK_PRODUCT_CONTENT'));
        return $files;
    }

    private function makeContentThumbnailStd(?int $contentSetId, string $fileName): ?array
    {
        if (is_null($contentSetId)) {
            return null;
        }

        return $this->makeThumbnailFile($this->makeThumbnailUrlFromFileName($fileName, $contentSetId));
    }

    /**
     * @param array   $inputData
     * @param Content $content
     *
     * @return void
     */
    private function fillContentFromRequest(array $inputData, Content $content): void
    {
        $validSinceDateTime = Arr::get($inputData, 'validSinceDate');
        $enabled            = Arr::has($inputData, 'enable');
        $isFree             = Arr::has($inputData, 'isFree');
        $tagString          = Arr::get($inputData, 'tags');
        $files              = Arr::get($inputData, 'files', []);
        $pamphlet           = Arr::get($inputData, 'pamphlet');

        $content->fill($inputData);

        if (!$content->isEnable() && $enabled) {
            $content->validSince = Carbon::now('Asia/Tehran');
        } else {
            $content->validSince = Carbon::parse($validSinceDateTime)->format('Y-m-d H:i:s');
        }

        $content->enable = $enabled ? 1 : 0;
        $content->isFree = $isFree ? 1 : 0;
        $content->tags   = convertTagStringToArray($tagString);

        if (Arr::get($inputData, 'section_id') == 0) {
            $content->section_id = null;
        }

        if (isset($pamphlet)) {
            $files = $this->storePamphletOfContent($content, $pamphlet);
        }

        if (!empty($files)) {
            $this->makeFilesCollection($content, $files);
        }

        if (Arr::has($inputData, 'sources_id')) {
            $sources = Source::whereIn('id', Arr::get($inputData, 'sources_id'))->get();
            if ($sources->isNotEmpty()) {
                $content->sources()->sync($sources);
            }
        }
    }

    private function storePamphletOfContent(Content $content, $pamphletFile): array
    {
        $disk = Storage::disk(config('constants.DISK19_CLOUD'));

        foreach ($content->getPamphlets() as $pamphlet) {
            $disk->delete(basename($pamphlet->link));
        }
        $filename = $pamphletFile->getClientOriginalName();
        if ($disk->put($filename, File::get($pamphletFile))) {
            return $this->makeFreePamphletFiles($filename);
        }
        return [];
    }

    /**
     * @param Content $content
     *
     * @param array   $files
     */
    private function makeFilesCollection(Content $content, array $files): void
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

    private function makeContentFilesArray(int $contentTypeId, ?int $contentSetId, ?string $fileName, int $isFree): ?array
    {
        if (!$isFree) {
            $productId = optional(Contentset::find($contentSetId)->products->first())->id;
            if (is_null($productId)) {
                return null;
            }
        }

        if ($contentTypeId == config('constants.CONTENT_TYPE_VIDEO')) {
            if ($isFree) {
                return $this->makeFreeVideoFiles($fileName, $contentSetId);
            } else {
                return $this->makePaidVideoFiles($fileName, $productId);
            }
        } else if ($contentTypeId == config('constants.CONTENT_TYPE_PAMPHLET')) {
            if ($isFree) {
                return $this->makeFreePamphletFiles($fileName);
            } else {
                return $this->makePaidPamphletFiles($fileName, $productId);
            }
        }

        return [];
    }

    /**
     * @param Content $content
     *
     * @return array
     */
    private function getContentInformation(Content $content): array
    {
        $key       = 'content:getContentInformation: ' . $content->id;
        $cacheTags = ['content', 'content_' . $content->id];
        $cacheTags =
            (isset($content->contentset_id)) ? array_merge($cacheTags, ['set_' . $content->contentset_id]) : $cacheTags;
        $cacheTags =
            (isset($content->author_id)) ? array_merge($cacheTags, ['user_' . $content->author_id]) : $cacheTags;
        return Cache::tags($cacheTags)
            ->remember($key, config('constants.CACHE_600'), function () use ($content) {
                $author = $content->authorName;

                [
                    $contentsWithSameSet,
                    $contentSetName,
                ] = $content->getSetMates();
                /** @var ContentCollection $contentsWithSameSet */
                $contentsWithSameSet  = $contentsWithSameSet->normalMates();
                $videosWithSameSet    = optional($contentsWithSameSet)->whereIn('type', 'video');
                $pamphletsWithSameSet = optional($contentsWithSameSet)->whereIn('type', 'pamphlet');
                [
                    $videosWithSameSetL,
                    $videosWithSameSetR,
                ] = optional($videosWithSameSet)->partition(function ($i) use ($content) {
                    return $i['content']->session < $content->session;
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

    private function makeJsonForAndroidApp($items): array
    {
        $key = md5(collect($items)
            ->pluck('id')
            ->implode(','));

        if ($items === null) {
            $response   = [];
            $response[] = json_decode('{}', false);
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

                    } else if (strcmp($source->res, '480p') === 0) {
                        $s_hq = $source->link;
                    } else if (strcmp($source->res, '720p') === 0) {
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
     * @param Agent $agent
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
        $this->middleware('permission:' . config('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'), [
            'only' => [
                'store',
                'create',
                'create2',
            ],
        ]);
        $this->middleware('permission:' . config('constants.EDIT_EDUCATIONAL_CONTENT'), [
            'only' => [
                'update',
                'edit',
            ],
        ]);
        $this->middleware('permission:' . config('constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS'),
            ['only' => 'destroy']);
        $this->middleware('convert:order|title', [
            'only' => [
                'store',
                'update',
            ],
        ]);
    }
}
