<?php

namespace App\Http\Controllers\Web;

use App\Article;
use App\Articlecategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditArticleRequest;
use App\Http\Requests\InsertArticleRequest;
use App\Slideshow;
use App\Websitepage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    protected $response;

    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.config('constants.LIST_ARTICLE_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_ARTICLE_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.config('constants.INSERT_ARTICLE_ACCESS'), ['only' => 'store']);
        $this->middleware('permission:'.config('constants.REMOVE_ARTICLE_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.SHOW_ARTICLE_ACCESS'), ['only' => 'edit']);
        $this->middleware('permission:'.config('constants.EDIT_ARTICLE_ACCESS'), ['only' => 'update']);
        $this->middleware('auth', [
            'except' => [
                'show',
                'showList',
            ],
        ]);

        $this->response = new Response();
    }

    public function index()
    {
        $articles = Article::all()
            ->sortByDesc("created_at");

        return view('article.index', compact('articles'));
    }

    public function create()
    {
        $articlecategories = Articlecategory::where('enable', 1)
            ->pluck('name', 'id');

        return view("article.create", compact("articlecategories"));
    }

    public function store(InsertArticleRequest $request)
    {
        $article = new Article();
        $article->fill($request->all());
        if (strlen($article->articlecategory_id) == 0 || !isset($article->articlecategory_id)) {
            $article->articlecategory_id = null;
        }
        $article->user_id = Auth::user()->id;

        if ($request->hasFile("image")) {
            $file      = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            if (Storage::disk(config('constants.DISK8'))
                ->put($fileName, File::get($file))) {
                $article->image = $fileName;
                $img            = Image::make(route('image', [
                    'category' => '8',
                    'w'        => '338',
                    'h'        => '338',
                    'filename' => $fileName,
                ]));
                $img->resize(766, 249);
                $img->save(Storage::disk(config('constants.DISK8'))
                        ->getAdapter()
                        ->getPathPrefix().$fileName);
            }
        }
        else {
            $article->image = config('constants.ARTICLE_DEFAULT_IMAGE');
        }

        if ($request->has("order")) {
            if (strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) {
                $article->order = 0;
            }
            $articlesWithSameOrder = Article::where("articlecategory_id", $article->articlecategory_id)
                ->where("order", $article->order)
                ->get();
            if (!$articlesWithSameOrder->isEmpty()) {
                $articlesWithGreaterOrder = Article::where("articlecategory_id", $article->articlecategory_id)
                    ->where("order", ">=", $article->order)
                    ->get();
                foreach ($articlesWithGreaterOrder as $graterArticle) {
                    $graterArticle->order = $graterArticle->order + 1;
                    $graterArticle->update();
                }
            }
        }

        if ($article->save()) {
            session()->put('success', 'درج مقاله با موفقیت انجام شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }

    public function show(Request $request, $article)
    {
        $articlecategories = Articlecategory::where('enable', 1)
            ->get();

        $otherArticlesType = "same";
        $otherArticles     = $article->sameCategoryArticles(4)
            ->get();
        if ($otherArticles->isEmpty()) {
            $otherArticles     = Article::recentArticles(4)
                ->get();
            $otherArticlesType = "recent";
        }

        if (isset($article->keyword) && strlen($article->keyword) > 0) {
            $tags = explode('،', $article->keyword);
        }
        else {
            $tags = [];
        }

        return view('article.show',
            compact('article', 'articlecategories', 'otherArticles', 'otherArticlesType', 'tags'));
    }

    public function edit($article)
    {
        $articlecategories = Articlecategory::where('enable', 1)
            ->pluck('name', 'id');

        return view('article.edit', compact('article', 'articlecategories'));
    }

    public function update(EditArticleRequest $request, $article)
    {
        $oldImage = $article->image;
        $article->fill($request->all());
        if (strlen($article->articlecategory_id) == 0 || !isset($article->articlecategory_id)) {
            $article->articlecategory_id = null;
        }

        if ($request->hasFile("image")) {
            $file      = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            if (Storage::disk(config('constants.DISK8'))
                ->put($fileName, File::get($file))) {
                Storage::disk(config('constants.DISK8'))
                    ->delete($oldImage);
                $article->image = $fileName;
                $img            = Image::make(route('image', [
                    'category' => '8',
                    'w'        => '338',
                    'h'        => '338',
                    'filename' => $fileName,
                ]));
                $img->resize(766, 249);
                $img->save(Storage::disk(config('constants.DISK8'))
                        ->getAdapter()
                        ->getPathPrefix().$fileName);
            }
        }

        if ($request->has("order")) {
            if (strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) {
                $article->order = 0;
            }
            $articlesWithSameOrder = Article::where("articlecategory_id", $article->articlecategory_id)
                ->where("id", "<>", $article->id)
                ->where("order",
                    $article->order)
                ->get();
            if (!$articlesWithSameOrder->isEmpty()) {
                $articlesWithGreaterOrder = Article::where("articlecategory_id", $article->articlecategory_id)
                    ->where("order", ">=", $article->order)
                    ->get();
                foreach ($articlesWithGreaterOrder as $graterArticle) {
                    $graterArticle->order = $graterArticle->order + 1;
                    $graterArticle->update();
                }
            }
        }

        if ($article->update()) {
            session()->put('success', 'اصلاح مقاله با موفقیت انجام شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }

    public function destroy($article)
    {
        if ($article->delete()) {
            session()->put('success', 'مقاله با موفقیت حذف شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }

    /**
     * Shows the list of articles to user
     *
     * @param Request $request
     * @return Response
     */
    public function showList(Request $request)
    {
        $categoryId        = $request->get('categoryId');
        $articlecategories = Articlecategory::where('enable', 1)
            ->orderBy('order')
            ->get();
        if (strcmp($categoryId, 'else') == 0) {
            $categoryId = null;
        }
        //        elseif(!isset($categoryId))
        //        {
        //            foreach ($articlecategories as $articlecategory)
        //            {
        //                if(!$articlecategory->articles->isEmpty())
        //                {
        //                    $categoryId = $articlecategory->id;
        //                    $articleCategoryName = $articlecategory->name;
        //                    break;
        //                }
        //            }

        //        }
        $countWithoutCategory = Article::where('articlecategory_id', null)
            ->count();
        if (!$request->has('categoryId')) {
            $itemsPerPage = 5;
            $articles     = Article::orderBy('created_at', 'desc')
                ->paginate($itemsPerPage);
        }
        else {
            $articles = Article::where('articlecategory_id', $categoryId)
                ->orderBy('order')
                ->get();
        }
        if (!isset($articleCategoryName) && isset($categoryId)) {
            $articleCategoryName = $articlecategories->where('id', $categoryId)
                ->first()->name;
        }

        $recentArticles = Article::recentArticles(4)
            ->get();

        $websitePageId = Websitepage::all()
            ->where('url', "/لیست-مقالات")
            ->first()->id;
        $slides        = Slideshow::all()
            ->where("isEnable", 1)
            ->where("websitepage_id", $websitePageId)
            ->sortBy("order");
        $slideCounter  = 1;
        $slideDisk     = 15;

        $metaDescription = "";
        $metaKeywords    = "";
        foreach ($articles as $article) {
            $metaKeywords    .= $article->title."-";
            $metaDescription .= $article->title."-";
        }

        return view('article.list',
            compact('articles', 'articlecategories', 'categoryId', 'articleCategoryName', 'countWithoutCategory',
                'recentArticles', "slides", "slideCounter",
                "slideDisk"));
    }
}
