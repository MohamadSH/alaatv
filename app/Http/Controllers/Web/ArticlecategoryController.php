<?php

namespace App\Http\Controllers\Web;

use App\Article;
use App\Articlecategory;
use App\Http\Controllers\Controller;
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
        $this->middleware('permission:'.config('constants.LIST_ARTICLECATEGORY_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_ARTICLECATEGORY_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.config('constants.INSERT_ARTICLECATEGORY_ACCESS'), ['only' => 'store']);
        $this->middleware('permission:'.config('constants.REMOVE_ARTICLECATEGORY_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.SHOW_ARTICLECATEGORY_ACCESS'), ['only' => 'edit']);
        $this->middleware('permission:'.config('constants.EDIT_ARTICLECATEGORY_ACCESS'), ['only' => 'update']);
        
        $this->response = new Response();
    }

    public function index()
    {
        $articlecategories = Articlecategory::all();
        
        return view('articlecategory.index', compact('articlecategories'));
    }

    public function store(InsertArticlecategoryRequest $request)
    {
        $articlecategory = new Articlecategory();
        if (isset($request->enable)) {
            $request->offsetSet("enable", 1);
        }
        else {
            $request->offsetSet("enable", 0);
        }
        $articlecategory->fill($request->all());
        
        if ($articlecategory->save()) {
            return $this->response->setStatusCode(Response::HTTP_OK);
        }
        else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function edit($articlecategory)
    {
        return view('articlecategory.edit', compact('articlecategory'));
    }

    public function update(EditArticlecategoryRequest $request, $articlecategory)
    {
        if (isset($request->enable)) {
            $request->offsetSet("enable", 1);
        }
        else {
            $request->offsetSet("enable", 0);
        }
        $articlecategory->fill($request->all());
        
        if ($articlecategory->update()) {
            session()->put('success', 'اصلاح دسته با موفقیت انجام شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        return redirect()->back();
    }

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
