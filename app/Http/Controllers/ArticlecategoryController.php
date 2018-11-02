<?php

namespace App\Http\Controllers;

use App\Article;
use App\Articlecategory;
use App\Http\Requests\EditArticlecategoryRequest;
use App\Http\Requests\InsertArticlecategoryRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class ArticlecategoryController extends Controller
{
    protected $response;

    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:' . Config::get('constants.LIST_ARTICLECATEGORY_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . Config::get('constants.INSERT_ARTICLECATEGORY_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . Config::get('constants.INSERT_ARTICLECATEGORY_ACCESS'), ['only' => 'store']);
        $this->middleware('permission:' . Config::get('constants.REMOVE_ARTICLECATEGORY_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . Config::get('constants.SHOW_ARTICLECATEGORY_ACCESS'), ['only' => 'edit']);
        $this->middleware('permission:' . Config::get('constants.EDIT_ARTICLECATEGORY_ACCESS'), ['only' => 'update']);

        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articlecategories = Articlecategory::all();
        return view('articlecategory.index', compact('articlecategories'));
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
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertArticlecategoryRequest $request)
    {
        $articlecategory = new Articlecategory();
        if (isset($request->enable))
            $request->offsetSet("enable", 1);
        else    $request->offsetSet("enable", 0);
        $articlecategory->fill($request->all());

        if ($articlecategory->save()) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($articlecategory)
    {
        return view('articlecategory.edit', compact('articlecategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditArticlecategoryRequest $request, $articlecategory)
    {
        if (isset($request->enable))
            $request->offsetSet("enable", 1);
        else    $request->offsetSet("enable", 0);
        $articlecategory->fill($request->all());

        if ($articlecategory->update()) {
            session()->put('success', 'اصلاح دسته با موفقیت انجام شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($articlecategory)
    {
        $categoryId = $articlecategory->id;

        if ($articlecategory->delete()) {
            //            session()->put('success', 'دسته بندی با موفقیت حذف شد');
            $articles = Article::where('articlecategory_id', $categoryId)
                               ->get();
            foreach ($articles as $article) {
                $article->articlecategory_id = null;
                $article->update();
            }
            return redirect()->back();
        }
        //        else session()->put('error', 'خطای پایگاه داده');
    }
}
