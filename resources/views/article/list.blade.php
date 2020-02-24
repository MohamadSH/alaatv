@extends('partials.templatePage',["pageName"=>"articles"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>

    <link href = "/assets/pages/css/blog-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("title")
    <title>آلاء|مقالات</title>
@endsection

@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>

            <li>
                <span>لیست مقالات و مطالب علمی</span>
            </li>
        </ul>
    </div>
@endsection
@section("content")
    <div class = "blog-page blog-content-2">
        <div class = "row">

            <div class = "col-lg-9">
                <div class = "blog-single-content bordered blog-container">
                    <div class = "blog-single-head">
                        <h1 class = "blog-single-head-title">@if(isset($articleCategoryName)) لیست
                                                                                              مقالات {{$articleCategoryName}}  @else لیست سایر مقالات @endif</h1>
                        <hr>
                    </div>
                    <ul>
                        @if(!$articles->isEmpty())
                            @foreach($articles as $article)
                                <div class = "blog-single-img">
                                    <img alt = "عکس مقاله @if(isset($article->title[0])) {{$article->title}} @endif" class = "timeline-badge-userpic" style = "width: 100px ;height: 100px" src = "{{ route('image', [ 'category'=>'8','w'=>'60' , 'h'=>'60' , 'filename' =>  $article->image ]) }}"/>
                                </div>
                                <br>
                                <h4 class = "bold" style = "text-align: right">
                                    <a href = "{{action("Web\ArticleController@show", $article->id)}}"> {{$article->title}}</a>
                                </h4>
                                <p style = "text-align: j"> {!! $article->brief !!}</p>
                                <a href = "{{action("Web\ArticleController@show", $article->id)}}" class = "btn btn-circle blue-hoki btn-outline sbold uppercase">خواندن ادامه</a>
                                <hr>
                            @endforeach
                        @else
                            <div class = "alert alert-info bold">
                                <h3 class = "bold" style = "text-align: center;">
                                    مقاله ای برای نمایش وجود ندارد.
                                </h3>
                            </div>
                        @endif
                    </ul>
                </div>
                <div class = "col-md-12 text-center">
                    @if($articles instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $articles->links() }}
                    @endif
                </div>
            </div>

            <div class = "col-lg-3">
                <div class = "blog-single-sidebar bordered blog-container">
                    <div class = "blog-single-sidebar-recent">
                        <h3 class = "blog-sidebar-title uppercase bold">دسته بندی ها</h3>
                        <ul>
                            @foreach($articlecategories as $articlecategory)
                                <li class = "blog-single-desc">
                                    <a class = "bold" style = "@if(isset($categoryId) && $categoryId == $articlecategory->id) color:red; background-color: #eeeeee; @endif" href = "{{action("Web\ArticleController@showList", ['categoryId' => $articlecategory->id])}}"> {{$articlecategory->name}}</a>
                                </li>
                            @endforeach
                            @if($countWithoutCategory != 0 )
                                <li class = "blog-single-img">
                                    <a class = "bold" style = "@if(!isset($categoryId) || $categoryId == null) color:red; background-color: #eeeeee; @endif" href = "{{action("Web\ArticleController@showList", ['categoryId' => 'else'])}}">
                                        سایر
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <hr>
                    <div class = "blog-single-sidebar-recent">
                        <h3 class = "blog-sidebar-title uppercase bold">مقالات اخیر</h3>
                        <ul>
                            @foreach($recentArticles as $recentArticle)
                                <li>
                                    <a href = "{{action("Web\ArticleController@show", $recentArticle)}}">{{$recentArticle->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>


@endsection
