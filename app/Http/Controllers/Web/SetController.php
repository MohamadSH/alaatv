<?php

namespace App\Http\Controllers\Web;

use App\Adapter\AlaaSftpAdapter;
use App\Classes\Search\ContentsetSearch;
use App\Content;
use App\Contentset;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentsetIndexRequest;
use App\Http\Requests\InsertContentsetRequest;
use App\Http\Resources\ContentInSetWithFileWithoutPagination as ContentResource;
use App\Http\Resources\SetWithoutPagination as SetResource;
use App\Source;
use App\Traits\FileCommon;
use App\Traits\MetaCommon;
use App\Traits\ProductCommon;
use App\Traits\RequestCommon;
use App\User;
use App\Websitesetting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

    use ProductCommon;
    use RequestCommon;
    use MetaCommon;
    use FileCommon;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $setting;

    public function __construct(Websitesetting $setting)
    {
        $this->setting = $setting->setting;
        $authException = $this->getAuthExceptionArray();
        $this->callMiddlewares($authException);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ContentsetIndexRequest $request
     * @param ContentsetSearch       $setSearch
     *
     * @return Factory|JsonResponse|RedirectResponse|Redirector|View
     */
    public function index(ContentsetIndexRequest $request, ContentsetSearch $setSearch)
    {

        $tags     = $request->get('tags');
        $filters  = $request->all();
        $pageName = 'setPage';

        $sets = $setSearch->setPageName($pageName)
            ->get($filters);

        if (request()->expectsJson()) {
            return response()->json([
                'result' => $sets,
                'tags'   => $tags,
            ]);
        }

        if (is_null($request->user())) {
            return redirect(route('login'));
        }

        if (!$request->user()->can(config('constants.LIST_CONTENT_SET_ACCESS'))) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return view('set.index', compact('sets', 'tags'));
    }

    public function indexContent(Request $request, Contentset $set)
    {
        $contents = optional($set->contents)->sortBy('order');
        return view('set.listContents', compact('set', 'contents'));
    }

    public function store(InsertContentsetRequest $request)
    {
        $contentSet = new Contentset();
        $this->fillContentFromRequest($request->all(), $contentSet);

        if ($contentSet->save()) {

            if ($request->has('products')) {
                $products = $request->get('products');
                if ($products === null) {
                    $products = [];
                }

                $this->syncProducts($products, $contentSet);
            }

            session()->put('success', 'دسته با موفقیت درج شد . شماره دسته : ' . $contentSet->id);
            return redirect()->back();
        }

        session()->put('error', 'خطای پایگاه داده');
        return redirect()->back();
    }

    public function update(Request $request, Contentset $contentSet)
    {
        $this->fillContentFromRequest($request->all(), $contentSet);

        if ($contentSet->update()) {

            if ($request->has('redirectAllContents')) {
                foreach ($contentSet->contents as $content) {
                    $content->update([
                        'redirectUrl' => $request->get('redirectUrl'),
                    ]);
                }
            }

            $products = $request->get('products');
            if (is_null($products))
                $products = [];

            if ($request->user()->can(config('constants.ADD_PRODUCT_TO_SET_ACCESS'))) {
                $this->syncProducts($products, $contentSet);
            }

            session()->put('success', 'دسته با موفقیت اصلاح شد');
            return redirect()->back();
        }

        session()->put('error', 'خطای پایگاه داده');
        return redirect()->back();
    }

    public function show(Request $request, Contentset $contentSet)
    {
        /** @var User $user */
        $user  = $request->user();
        $order = $request->get('order', 'asc');
        if (isset($contentSet->redirectUrl)) {
            return redirect($contentSet->redirectUrl, Response::HTTP_FOUND, $request->headers->all());
        }

        if (!$contentSet->isActive()) {
            //Should implement a page for de-activated stuffs
            return redirect(route('web.home'));
        }

        if ($request->expectsJson() && !$request->has('raheAbrisham')) {
            return response()->json($contentSet);
        }

        $contents = $contentSet->getActiveContents2();
        if ($order === 'desc') {
            $contents = $contents->sortByDesc('order');
        }


        // ToDo : To get sorted contents grouped by section
//        Note : can't add sortBy to this
//        $contents = $contentSet->active_contents_by_section;

        $pamphlets = $contents->where('contenttype_id', Content::CONTENT_TYPE_PAMPHLET);
        $videos    = $contents->where('contenttype_id', Content::CONTENT_TYPE_VIDEO);
        $articles  = $contents->where('contenttype_id', Content::CONTENT_TYPE_ARTICLE);

        if ($request->expectsJson()) {
            $files = [];
            $files['pamphlets'] = ContentResource::collection($pamphlets);
            $files['videos'] = ContentResource::collection($videos);

            return response()->json([
                'set'   => new SetResource($contentSet),
                'files' => $files,
            ]);
        }

        $jsonLdArray = $this->getJsonLdArray($videos, $pamphlets, $articles);

        $this->generateSeoMetaTags($contentSet);

        $isFavored = (isset($user)) ? $user->hasFavoredSet($contentSet) : false;

        $sources = $contentSet->sources;

        return view('set.show', compact('contentSet', 'videos', 'pamphlets', 'articles', 'jsonLdArray', 'order', 'isFavored', 'sources'));
    }

    public function edit(Contentset $set)
    {
        $setProducts = $set->products()->whereNull('contentset_product.deleted_at')->get();
        $products    = $this->makeProductCollection();
        $sources     = Source::all()->pluck('title', 'id')->toArray();
        $setSources  = $set->sources->pluck('id')->toArray();
        return view('set.edit', compact('set', 'setProducts', 'products', 'sources', 'setSources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $products = $this->makeProductCollection();
        $sources  = Source::all()->pluck('title', 'id')->toArray();
        return view('set.create', compact('products', 'sources'));
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

    /**
     * @return array
     */
    private function getAuthExceptionArray(): array
    {
        return [
            'index',
            'show',
        ];
    }

    /**
     * @param $authException
     */
    private function callMiddlewares($authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . config('constants.REMOVE_CONTENT_SET_ACCESS'), [
            'only' => [
                'destroy',
            ],
        ]);
        $this->middleware('permission:' . config('constants.EDIT_CONTENT_SET_ACCESS'), [
            'only' => [
                'update',
            ],
        ]);

        $this->middleware('permission:' . config('constants.INSERT_CONTENT_SET_ACCESS'), [
            'only' => [
                'store',
            ],
        ]);

        $this->middleware('permission:' . config('constants.LIST_CONTENT_SET_ACCESS'), [
            'only' => [
//                'index',
            ],
        ]);

        $this->middleware('permission:' . config('constants.LIST_CONTENTS_OF_CONTENT_SET_ACCESS'), [
            'only' => [
                'indexContent',
            ],
        ]);

        $this->middleware('permission:' . config('constants.SHOW_CONTENT_SET_ACCESS'), [
            'only' => [
                'edit',
                //                'show',
            ],
        ]);


    }

    /**
     * @param $videos
     * @param $pamphlets
     * @param $articles
     *
     * @return array|null
     */
    private function getJsonLdArray($videos, $pamphlets, $articles): ?array
    {
        $jsonLdItems = [];
        if ($videos->isNotEmpty()) {
            foreach ($videos as $item) {
                $jsonLdItems[] = [
                    '@type'    => 'ListItem',
                    'position' => $item->order,
                    'url'      => action([ContentController::class, 'show'], $item),
                ];
            }
        } else if ($pamphlets->isNotEmpty()) {
            foreach ($pamphlets as $item) {
                $jsonLdItems[] = [
                    '@type'    => 'ListItem',
                    'position' => $item->order,
                    'url'      => action([ContentController::class, 'show'], $item),
                ];
            }
        } else if ($articles->isNotEmpty()) {
            foreach ($articles as $item) {
                $jsonLdItems[] = [
                    '@type'    => 'ListItem',
                    'position' => $item->order,
                    'url'      => action([ContentController::class, 'show'], $item),
                ];
            }
        }
        $jsonLdArray = null;
        if (!empty($jsonLdItems)) {
            $jsonLdArray = [
                '@context'        => 'https://schema.org',
                '@type'           => 'ItemList',
                'itemListElement' => $jsonLdItems,
            ];
        }
        return $jsonLdArray;
    }

    /**
     * @param array      $inputData
     * @param Contentset $contentSet
     *
     * @return void
     */
    private function fillContentFromRequest(array $inputData, Contentset $contentSet): void
    {
        $enabled   = Arr::has($inputData, 'enable');
        $display   = Arr::has($inputData, 'display');
        $tagString = Arr::get($inputData, 'tags');

        $contentSet->fill($inputData);
        $contentSet->tags = convertTagStringToArray($tagString);

        $contentSet->enable  = $enabled ? 1 : 0;
        $contentSet->display = $display ? 1 : 0;

        if (Arr::has($inputData, 'photo')) {
            $this->storePhotoOfSet($contentSet, Arr::get($inputData, 'photo'));
        }

        if (isset($contentSet->redirectUrl)) {
            $contentSet->display = 0;
        }

        if (Arr::has($inputData, 'sources_id')) {
            $sources = Source::whereIn('id', Arr::get($inputData, 'sources_id'))->get();
            if ($sources->isNotEmpty()) {
                $contentSet->sources()->sync($sources);
                if (Arr::has($inputData, 'attachSourceToContents')) {
                    $sourcesId = Arr::get($inputData, 'sources_id');
                    $contentSet->contents->attachSource($sourcesId);
                }
            }
        }
    }

    private function storePhotoOfSet(Contentset $contentSet, $file): void
    {
        $extension = $file->getClientOriginalExtension();
        $fileName  =
            basename($file->getClientOriginalName(), '.' . $extension) . '_' . date('YmdHis') . '.' . $extension;
        $disk      = Storage::disk(config('constants.DISK23'));
        /** @var AlaaSftpAdapter $adaptor */
        if ($disk->put($fileName, File::get($file))) {
            $fullPath          = $disk->getAdapter()
                ->getRoot();
            $partialPath       = $this->getSubDirectoryInCDN($fullPath);
            $contentSet->photo =
                config('constants.DOWNLOAD_SERVER_PROTOCOL') . config('constants.CDN_SERVER_NAME') . '/' . $partialPath . $fileName;
        }
    }

    private function syncProducts(array $products, Contentset $contentSet)
    {
        foreach ($contentSet->products as $product) {
            Cache::tags(['product_' . $product->id . '_sets'])->flush();
        }

        $contentSet->products()->detach();
        $contentSet->products()->attach($products);

        foreach ($products as $productId) {
            Cache::tags(['product_' . $productId . '_sets'])->flush();
        }

    }

}
