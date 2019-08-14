<?php

namespace App\Http\Controllers\Web;

use App\Adapter\AlaaSftpAdapter;
use App\Contentset;
use App\Traits\FileCommon;
use App\Websitesetting;
use App\Traits\MetaCommon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Traits\ProductCommon;
use App\Traits\RequestCommon;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Classes\Search\ContentsetSearch;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ContentsetIndexRequest;
use App\Http\Requests\InsertContentsetRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $this->setting  = $setting->setting;
        $authException  = $this->getAuthExceptionArray();
        $this->callMiddlewares($authException);
    }

    /**
     * @return array
     */
    private function getAuthExceptionArray(): array
    {
        $authException = [
            "index",
            "show",
        ];

        return $authException;
    }

    /**
     * @param $authException
     */
    private function callMiddlewares($authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:'.config('constants.REMOVE_CONTENT_SET_ACCESS'), [
            'only' => [
                'destroy',
            ],
        ]);
        $this->middleware('permission:'.config('constants.EDIT_CONTENT_SET_ACCESS'), [
            'only' => [
                'update',
            ],
        ]);

        $this->middleware('permission:'.config('constants.INSERT_CONTENT_SET_ACCESS'), [
            'only' => [
                'store',
            ],
        ]);

        $this->middleware('permission:'.config('constants.LIST_CONTENT_SET_ACCESS'), [
            'only' => [
//                'index',
            ],
        ]);

        $this->middleware('permission:'.config('constants.SHOW_CONTENT_SET_ACCESS'), [
            'only' => [
                'edit',
//                'show',
            ],
        ]);


    }

    /**
     * Display a listing of the resource.
     *
     * @param  ContentsetIndexRequest  $request
     * @param  ContentsetSearch        $setSearch
     *
     * @return Response
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
        return view("set.index", compact("sets", 'tags'));
    }

    public function store(InsertContentsetRequest $request)
    {
        $contentSet = new Contentset();
        $this->fillContentFromRequest($request->all(), $contentSet);

        if ($contentSet->save()) {

            if($request->has('products'))
            {
                $products = $request->get('products');
                if(is_null($products))
                    $products = [];

                $this->syncProducts($products , $contentSet);
            }

            session()->put('success' , 'دسته با موفقیت درج شد . شماره دسته : '.$contentSet->id);
            return redirect()->back();
        }
        else {
            session()->put('error' , 'خطای پایگاه داده');
            return redirect()->back();
        }
    }

    public function update(Request $request , Contentset $contentSet)
    {
        $this->fillContentFromRequest($request->all(), $contentSet);

        if ($contentSet->update()) {

            if($request->has('products'))
            {
                $products = $request->get('products');
                if(is_null($products))
                    $products = [];
                $this->syncProducts($products , $contentSet);
            }

            session()->put('success' , 'دسته با موفقیت اصلاح شد');
            return redirect()->back();
        }
        else {
            session()->put('error' , 'خطای پایگاه داده');
            return redirect()->back();
        }
    }

    /**
     * @param  FormRequest  $inputData
     * @param  Contentset   $contentset
     *
     * @return void
     */
    private function fillContentFromRequest(array $inputData, Contentset $contentset): void
    {
        $enabled   = Arr::has($inputData,'enable');
        $display   = Arr::has($inputData,'display');
        $tagString  = Arr::get($inputData , 'tags');

        $contentset->fill($inputData);
        $contentset->tags       = convertTagStringToArray($tagString);

        $contentset->enable  = $enabled ? 1 : 0;
        $contentset->display = $display ? 1 : 0;

        if(Arr::has($inputData , 'photo'))
        {
            $this->storePhotoOfSet($contentset , Arr::get($inputData , 'photo'));
        }
    }

    public function show(Request $request, Contentset $set)
    {
        if ($request->expectsJson()) {
            return response()->json($set);
        }

        $contents = $set->getActiveContents();

        return view('listTest', compact('set', 'contents'));
    }

    public function edit(Contentset $set) {
        $setProducts = $set->products;
        $products = $this->makeProductCollection();
        return view('set.edit', compact('set', 'setProducts', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $products = $this->makeProductCollection();
        return view('set.create', compact('products'));
    }

    public function indexContent (\App\Http\Requests\Request $request, Contentset $set){
        $contents = optional($set->contents)->sortBy('order');
        return view('set.listContents',compact('set','contents'));
    }

    private function syncProducts(array $products , Contentset $contentset){
        $contentset->products()->sync($products);
    }

    private function storePhotoOfSet(Contentset $contentSet, $file): void
    {
        $extension = $file->getClientOriginalExtension();
        $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
        $disk = Storage::disk(config('constants.DISK23'));
        /** @var AlaaSftpAdapter $adaptor */
        if ($disk->put($fileName, File::get($file))) {
            $fullPath = $disk->getAdapter()->getRoot();
            $partialPath = $this->getSubDirectoryInCDN($fullPath);
            $contentSet->photo = config('constants.DOWNLOAD_SERVER_PROTOCOL').config('constants.CDN_SERVER_NAME').'/' .$partialPath.$fileName;
        }
    }
}
