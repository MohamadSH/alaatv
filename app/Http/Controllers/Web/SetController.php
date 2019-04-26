<?php

namespace App\Http\Controllers\Web;

use App\Classes\Search\ContentsetSearch;
use App\Classes\SEO\SeoDummyTags;
use App\Contentset;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentsetIndexRequest;
use App\Http\Requests\InsertContentsetRequest;
use App\Traits\MetaCommon;
use App\Traits\RequestCommon;
use App\Websitesetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

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
        $this->setting = $setting->setting;
        $authException = $this->getAuthExceptionArray();
        $this->callMiddlewares($authException);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ContentsetIndexRequest $request
     * @param ContentsetSearch $setSearch
     * @return \Illuminate\Http\Response
     */
    public function index(ContentsetIndexRequest $request, ContentsetSearch $setSearch)
    {

        $tags = $request->get('tags');
        $filters = $request->all();
        $pageName = 'setPage';

        $sets = $setSearch->setPageName($pageName)->get($filters);

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags("دوره های آموزشی ".$this->setting->site->name,
            'دوره های آموزشی دهم، یازدهم و دوازدهم - کنکور و پایه آلاء با همکاری دبیرستان دانشگاه صنعتی شریف', $url, $url, route('image', [
                'category' => '11',
                'w' => '100',
                'h' => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));

        if (request()->expectsJson() || true) {
            return $this->response->setStatusCode(Response::HTTP_OK)->setContent([
                'result' => $sets,
                'tags' => $tags,
            ]);
        }

        return view("set.index", compact("sets", 'tags'));
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
     * @param InsertContentsetRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertContentsetRequest $request)
    {
        $contentSet = new Contentset();
        $this->fillContentFromRequest($request, $contentSet);

        if ($contentSet->save()) {
            return $this->response->setStatusCode(Response::HTTP_OK);
        } else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param Contentset $set
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Contentset $set)
    {
        if ($request->expectsJson()) {
            return response()->json($set);
        }

        $contents = $set->getContents();

        return view('listTest', compact('set', 'contents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

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
     * @param FormRequest $request
     * @param Contentset $contentset
     *
     * @return void
     */
    private function fillContentFromRequest(FormRequest $request, Contentset &$contentset): void
    {
        $inputData = $request->all();
        $enabled = $request->has("enable");
        $display = $request->has("display");

        $contentset->fill($inputData);
        if ($request->has("id")) {
            $contentset->id = $request->id;
        }

        $contentset->enable = $enabled ? 1 : 0;
        $contentset->display = $display ? 1 : 0;
    }
}
