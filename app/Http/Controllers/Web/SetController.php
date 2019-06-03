<?php

namespace App\Http\Controllers\Web;

use App\Contentset;
use App\Traits\ProductCommon;
use App\Websitesetting;
use App\Traits\MetaCommon;
use Illuminate\Http\Request;
use App\Traits\RequestCommon;
use Illuminate\Http\Response;
use App\Classes\SEO\SeoDummyTags;
use App\Http\Controllers\Controller;
use App\Classes\Search\ContentsetSearch;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ContentsetIndexRequest;
use App\Http\Requests\InsertContentsetRequest;
use Illuminate\Support\Arr;

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
        
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags("دوره های آموزشی ".$this->setting->site->name,
            'دوره های آموزشی دهم، یازدهم و دوازدهم - کنکور و پایه آلاء با همکاری دبیرستان دانشگاه صنعتی شریف', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));
        
        if (request()->expectsJson() || true) {
            return $this->response->setStatusCode(Response::HTTP_OK)
                ->setContent([
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

//            $products = $request->get('products');
//            if(isset($products))
//            {
//                $this->syncProducts($products , $contentSet);
//            }
            
            session()->put('success' , 'دسته با موفقیت درج شد');
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

//            $products = $request->get('products');
//            if(isset($products))
//            {
//                $this->syncProducts($products , $contentSet);
//            }

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
        $contents = $set->contents2->sortBy('order');
        return view('listTest',compact('set','contents'));
    }
    
    private function syncProducts(array $products , Contentset $contentset){
        $contentset->products()->sync($products);
    }

    private function storePhotoOfSet(Contentset $contentSet, $file): void
    {
        $serverUrl = config('constants.DOWNLOAD_SERVER_PROTOCOL').config('constants.DOWNLOAD_SERVER_NAME');
        $partialPath = '/upload/contentset/lesson/';

        $contentSet->photo = $serverUrl.$partialPath.$file->getClientOriginalName();
    }
}
