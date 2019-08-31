@extends("app")

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>

    <link href = "../assets/pages/css/blog-rtl.min.css" rel = "stylesheet" type = "text/css"/>
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
                <a href = "{{action("Web\ArticleController@showList")}}">لیست مقالات</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>نمایش مقاله</span>
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
                        <h1 class = "blog-single-head-title">{{$article->title}}</h1>
                        <div class = "blog-single-head-date">
                            <i class = "icon-calendar m--font-info"></i>
                            <a href = "javascript:">{{$article->CreatedAt_Jalali()}}</a>
                        </div>
                    </div>
                    <div class = "blog-single-img">
                        <img src = "{{ route('image', ['category'=>'8','w'=>'608' , 'h'=>'608' ,  'filename' =>  $article->image ]) }}" alt = "عکس مقاله@if(isset($article->title[0])) {{$article->title}} @endif"/>
                    </div>
                    <div class = "blog-single-desc">
                        <p> {!! $article->brief !!}</p>
                        <p> {!! $article->body !!}</p>
                    </div>
                    <div class = "blog-single-foot">
                        <ul class = "blog-post-tags">
                            @if(sizeof($tags) > 0)
                                @foreach($tags as $tag)
                                    <li class = "uppercase">
                                        <a href = "">{{$tag}}</a>
                                    </li>
                                @endforeach
                            @else
                                <li class = "uppercase">
                                    <a href = "">{{$article->title}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    {{--<div class="blog-comments">--}}
                    {{--<h3 class="sbold blog-comments-title">Comments(30)</h3>--}}
                    {{--<div class="c-comment-list">--}}
                    {{--<div class="media">--}}
                    {{--<div class="media-left">--}}
                    {{--<a href="#">--}}
                    {{--<img class="media-object" alt="" src="../assets/pages/img/avatars/team1.jpg"> </a>--}}
                    {{--</div>--}}
                    {{--<div class="media-body">--}}
                    {{--<h4 class="media-heading">--}}
                    {{--<a href="#">Sean</a> on--}}
                    {{--<span class="c-date">23 May 2015, 10:40AM</span>--}}
                    {{--</h4> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. </div>--}}
                    {{--</div>--}}
                    {{--<div class="media">--}}
                    {{--<div class="media-left">--}}
                    {{--<a href="#">--}}
                    {{--<img class="media-object" alt="" src="../assets/pages/img/avatars/team3.jpg"> </a>--}}
                    {{--</div>--}}
                    {{--<div class="media-body">--}}
                    {{--<h4 class="media-heading">--}}
                    {{--<a href="#">Strong Strong</a> on--}}
                    {{--<span class="c-date">21 May 2015, 11:40AM</span>--}}
                    {{--</h4> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.--}}
                    {{--<div class="media">--}}
                    {{--<div class="media-left">--}}
                    {{--<a href="#">--}}
                    {{--<img class="media-object" alt="" src="../assets/pages/img/avatars/team4.jpg"> </a>--}}
                    {{--</div>--}}
                    {{--<div class="media-body">--}}
                    {{--<h4 class="media-heading">--}}
                    {{--<a href="#">Emma Stone</a> on--}}
                    {{--<span class="c-date">30 May 2015, 9:40PM</span>--}}
                    {{--</h4> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. </div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="media">--}}
                    {{--<div class="media-left">--}}
                    {{--<a href="#">--}}
                    {{--<img class="media-object" alt="" src="../assets/pages/img/avatars/team7.jpg"> </a>--}}
                    {{--</div>--}}
                    {{--<div class="media-body">--}}
                    {{--<h4 class="media-heading">--}}
                    {{--<a href="#">Nick Nilson</a> on--}}
                    {{--<span class="c-date">30 May 2015, 9:40PM</span>--}}
                    {{--</h4> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. </div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<h3 class="sbold blog-comments-title">Leave A Comment</h3>--}}
                    {{--<form action="#">--}}
                    {{--<div class="form-group">--}}
                    {{--<input type="text" placeholder="Your Name" class="form-control c-square"> </div>--}}
                    {{--<div class="form-group">--}}
                    {{--<input type="text" placeholder="Your Email" class="form-control c-square"> </div>--}}
                    {{--<div class="form-group">--}}
                    {{--<input type="text" placeholder="Your Website" class="form-control c-square"> </div>--}}
                    {{--<div class="form-group">--}}
                    {{--<textarea rows="8" name="message" placeholder="Write comment here ..." class="form-control c-square"></textarea>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                    {{--<button type="submit" class="btn blue uppercase btn-md sbold btn-block">Submit</button>--}}
                    {{--</div>--}}
                    {{--</form>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class = "col-lg-3">
                <div class = "blog-single-sidebar bordered blog-container">
                    <div class = "blog-single-sidebar-search">
                        <div class = "input-icon right">
                            {{--<i class="icon-magnifier"></i>--}}
                            {{--<input type="text" class="form-control" placeholder="Search Blog"> --}}
                        </div>
                    </div>
                    <div class = "blog-single-sidebar-recent">
                        @if(strcmp($otherArticlesType, "same") == 0)
                            <h3 class = "blog-sidebar-title uppercase bold">مقالات دیگر این دسته</h3>
                        @elseif(strcmp($otherArticlesType, "recent") == 0)
                            <h3 class = "blog-sidebar-title uppercase bold">مقالات اخیر</h3>
                        @endif

                        <ul>
                            @foreach($otherArticles as $otherArticle)
                                <li>
                                    <a href = "{{action("Web\ArticleController@show", $otherArticle)}}">{{$otherArticle->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class = "blog-single-sidebar-tags">
                        <h3 class = "blog-sidebar-title uppercase">کلمات کلیدی</h3>
                        <ul class = "blog-post-tags">
                            @if(sizeof($tags) > 0)
                                @foreach($tags as $tag)
                                    <li class = "uppercase">
                                        <a href = "">{{$tag}}</a>
                                    </li>
                                @endforeach
                            @else
                                <li class = "uppercase">
                                    <a href = "">{{$article->title}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    {{--<div class="blog-single-sidebar-links">--}}
                    {{--<h3 class="blog-sidebar-title uppercase">Useful Links</h3>--}}
                    {{--<ul>--}}
                    {{--<li>--}}
                    {{--<a href="javascript:;">Lorem Ipsum </a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="javascript:;">Dolore Amet</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="javascript:;">Metronic Database</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="javascript:;">UI Features</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="javascript:;">Advanced Forms</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="blog-single-sidebar-ui">--}}
                    {{--<h3 class="blog-sidebar-title uppercase">UI Examples</h3>--}}
                    {{--<div class="row ui-margin">--}}
                    {{--<div class="col-xs-4 ui-padding">--}}
                    {{--<a href="javascript:;">--}}
                    {{--<img src="../assets/pages/img/background/1.jpg" />--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-4 ui-padding">--}}
                    {{--<a href="javascript:;">--}}
                    {{--<img src="../assets/pages/img/background/37.jpg" />--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-4 ui-padding">--}}
                    {{--<a href="javascript:;">--}}
                    {{--<img src="../assets/pages/img/background/57.jpg" />--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-4 ui-padding">--}}
                    {{--<a href="javascript:;">--}}
                    {{--<img src="../assets/pages/img/background/53.jpg" />--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-4 ui-padding">--}}
                    {{--<a href="javascript:;">--}}
                    {{--<img src="../assets/pages/img/background/59.jpg" />--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-4 ui-padding">--}}
                    {{--<a href="javascript:;">--}}
                    {{--<img src="../assets/pages/img/background/42.jpg" />--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
@endsection
