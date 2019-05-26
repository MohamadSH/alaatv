<?php

namespace App\Http\Controllers\Web;

use App\Contentset;
use App\Product;
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
    protected $response;
    
    protected $setting;
    
    public function __construct(Response $response, Websitesetting $setting)
    {
        $this->response = $response;
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
        $this->fillContentFromRequest($request, $contentSet);
        
        if ($contentSet->save()) {
            return $this->response->setStatusCode(Response::HTTP_OK);
        }
        else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
    
    /**
     * @param  FormRequest  $request
     * @param  Contentset   $contentset
     *
     * @return void
     */
    private function fillContentFromRequest(FormRequest $request, Contentset $contentset): void
    {
        $inputData = $request->all();
        $enabled   = $request->has("enable");
        $display   = $request->has("display");
        
        $contentset->fill($inputData);
        if ($request->has("id")) {
            $contentset->id = $request->id;
        }
        
        $contentset->enable  = $enabled ? 1 : 0;
        $contentset->display = $display ? 1 : 0;
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
        $contents = $set->contents2->sortBy("order");
        return view('listTest',compact('set','contents'));
    }
}
