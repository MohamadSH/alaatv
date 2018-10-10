<?php

namespace App\Http\Controllers;

use App\Classes\Search\ContentsetSearch;
use App\Contentset;
use App\Http\Requests\ContentsetIndexRequest;
use App\Http\Requests\InsertContentsetRequest;
use App\Http\Requests\ProductIndexRequest;
use App\Traits\RequestCommon;
use App\Websitesetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\{
    Request, Response
};
use Illuminate\Support\{
    Collection, Facades\Cache, Facades\View
};

class ContentsetController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | Traits
   |--------------------------------------------------------------------------
   */

    use RequestCommon;


    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $response ;
    protected $setting ;
    const PARTIAL_SEARCH_TEMPLATE = "partials.search.contentset";

    public function __construct(Response $response , Websitesetting $setting)
    {
        $this->response = $response;
        $this->setting = $setting->setting;
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param FormRequest $request
     * @param Contentset $contentset
     * @return void
     */
    private function fillContentFromRequest(FormRequest $request, Contentset &$contentset):void
    {
        $inputData = $request->all();
        $enabled = $request->has("enable");
        $display = $request->has("display");

        $contentset->fill($inputData);
        if($request->has("id"))
            $contentset->id = $request->id;

        $contentset->enable = $enabled ? 1 : 0;
        $contentset->display = $display ? 1 : 0;
    }

    /**
     * @param $query
     * @return string
     */
    private function getPartialSearchFromIds($query ){
        $partialSearch = View::make(
            self::PARTIAL_SEARCH_TEMPLATE,
            [
                'items' => $query
            ]
        )->render();
        return $partialSearch;
    }

    /**
     * @param Collection $items
     * @return \Illuminate\Http\Response
     */
    private function makeJsonForAndroidApp(Collection $items){
        $items = $items->pop();
        $key = md5($items->pluck("id")->implode(","));
        $response = Cache::remember($key,config("constants.CACHE_60"),function () use($items){
            $response = collect();

        });
        return $response;
    }

    /*
   |--------------------------------------------------------------------------
   | Public methods
   |--------------------------------------------------------------------------
   */

    /**
     * Display a listing of the resource.
     *
     * @param ContentsetIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ContentsetIndexRequest $request)
    {
        $tags = $request->get('tags');
        $filters = $request->all();
        $isApp = $this->isRequestFromApp($request);
        $items = collect();
        $pageName = 'contentsetPage' ;
        $contentsetResult = ( new ContentsetSearch() )
            ->setPageName($pageName)
            ->apply($filters);

        if($isApp)
        {
            $items->push($contentsetResult->getCollection());
        }
        else {
            if ($contentsetResult->total() > 0)
                $partialSearch = $this->getPartialSearchFromIds( $contentsetResult);
            else
                $partialSearch = null;
            $items->push([
                "totalitems"=> $contentsetResult->total(),
                "view"=>$partialSearch,
            ]);
        }

        if($isApp){
            $response = $this->makeJsonForAndroidApp($items);
            return response()->json($response,Response::HTTP_OK);
        }
        if(request()->ajax())
        {
            return $this->response
                ->setStatusCode(Response::HTTP_OK)
                ->setContent([
                    "items"=>$items ,
                    "tagLabels" => $tags ,
                ]);
        }

        return redirect(action("ContentController@index" , $tags)) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertContentsetRequest $request)
    {
        $contentSet = new Contentset();
        $this->fillContentFromRequest($request, $content);

        if($contentSet->save())
            return $this->response->setStatusCode(Response::HTTP_OK);
        else
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
