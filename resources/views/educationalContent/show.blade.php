@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link rel="stylesheet" href="/videojs/video.js/dist/video-js.min.css">
    <style>
        @media screen and (max-width: 480px) {
            .google-docs {
                height: 350px;
            }
        }

        .mt-element-list {
            background-color: white;
        }

    </style>
@endsection

@section("pageBar")

@endsection
@section("bodyClass")
    class = "page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <i class="fa fa-list-ul" aria-hidden="true"></i>
                <a href="{{action("EducationalContentController@search")}}">محتوای آموزشی</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>نمایش @if(isset($rootContentType->displayName[0])){{$rootContentType->displayName}}@endif</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    @if(isset($educationalContent->template))
        @if($educationalContent->template->name == "video1")
            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-video-camera" aria-hidden="true"></i>
                                {{ isset($educationalContentDisplayName) ? $educationalContentDisplayName : '' }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div data-vjs-player>
                                <video
                                        id="video-{{$educationalContent->id}}"
                                        poster='@if(isset($files["thumbnail"])){{$files["thumbnail"]}}@endif'
                                        width='100%'
                                        height='400px'
                                        style="width: 100%"
                                        class="video-js vjs-default-skin" controls>

                                    @foreach($files["videoSource"] as $source)
                                        <source label="{{ $source["caption"] }}" src="{{ $source["src"] }}" type='video/mp4'>
                                    @endforeach
                                    <p class="vjs-no-js">جهت پخش آنلاین فیلم، ابتدا مطمئن شوید که جاوا اسکریپت در مرور
                                        گر شما فعال است و از آخرین نسخه ی مرورگر استفاده می کنید.</p>
                                </video>
                                <script>
                                    {{--$(document).ready(function(){--}}
                                        {{--console.log( "ready!" );--}}
                                        {{--options = {--}}
                                            {{--controlBar: {--}}
                                                {{--children: [--}}
                                                    {{--'playToggle',--}}
                                                    {{--'progressControl',--}}
                                                    {{--'volumePanel',--}}
                                                    {{--'fullscreenToggle',--}}
                                                {{--],--}}
                                            {{--},--}}
                                        {{--};--}}
                                        {{--var player = videojs('video-{{$educationalContent->id}}',options);--}}

                                    {{--});--}}
                                </script>
                            </div>
                            <div class="row">
                                @if(isset($educationalContent->author_id))
                                    <hr>
                                    <div class="col-md-12">
                                        <ul class="list-inline">
                                            <li><i class="fa fa-user"></i>مدرس : {{$author}}</li>&nbsp;
                                        </ul>
                                    </div>
                                @endif
                                @foreach($files["videoSource"] as $key => $source)
                                    <div class="col-md-4">
                                        <a href="{{$source["src"]}}?download=1" class="btn red margin-bottom-5" style="width: 250px;">
                                            فایل {{$source["caption"]}}{{ (isset($source["size"]))?"(".$source["size"]. "مگ)":""  }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if(!empty($tags))
                                        <hr>
                                        @include("partials.search.tagLabel" , ["tags"=>$tags])
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-comment-o" aria-hidden="true"></i>
                                        توضیح این جلسه
                                    </div>
                                </div>
                                <div class="portlet-body text-justify">
                                    @if(isset($educationalContent->description[0]))
                                        <div class="scroller" style="height:100px" data-rail-visible="1" data-rail-color="black"
                                             data-handle-color="#a1b2bd">
                                            {!! $educationalContent->description !!}
                                        </div>
                                    @else
                                        به زودی ...
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($contentsWithSameSet))
                    <div class="col-md-4 margin-bottom-15">
                        <div class="mt-element-list">
                        <div class="mt-list-head list-news ext-1 font-white bg-yellow-crusta">
                            <div class="list-head-title-container">
                                <h3 class="list-title">جلسات دیگر</h3>
                            </div>
                            <div class="list-count pull-right bg-yellow-saffron"></div>
                        </div>
                        <div class="mt-list-container list-news ext-2" id="otherSessions">
                            <div id="playListScroller" class="scroller" style="min-height: 50px; max-height:600px" data-always-visible="1" data-rail-visible="1"
                                 data-rail-color="red" data-handle-color="green">
                                <ul>

                                    @foreach($contentsWithSameSet->whereIn("type" , "video" ) as $item)
                                        <li class="mt-list-item @if($item["content"]->id == $educationalContent->id) bg-grey-mint @endif " id="playlistItem_{{$item["content"]->id}}">
                                            <div class="list-icon-container">
                                                <a href="{{action("EducationalContentController@show" , $item["content"])}}">
                                                    <i class="fa fa-angle-left"></i>
                                                </a>
                                            </div>
                                            <div class="list-thumb">
                                                <a href="{{action("EducationalContentController@show" , $item["content"])}}">
                                                    <img alt="{{$item["content"]->name}}"
                                                         src="{{(isset($item["thumbnail"]))?$item["thumbnail"]:''}}"/>
                                                </a>
                                            </div>
                                            <div class="list-datetime bold uppercase font-yellow-casablanca"> {{($item["content"]->getDisplayName())}} </div>
                                            <div class="list-item-content">
                                                <h3 class="uppercase bold">
                                                    <a href="javascript:;">&nbsp;</a>
                                                </h3>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                @endif
            </div>

            @if(isset($contentsWithSameSet) && $contentsWithSameSet->whereIn("type" , "pamphlet" )->isNotEmpty())
                <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comment-o" aria-hidden="true"></i>
                                جزوات این درس
                            </div>
                        </div>
                        <div class="portlet-body text-justify">
                            <div class="m-grid m-grid-demo">
                            @foreach($contentsWithSameSet->whereIn("type" , "pamphlet" )->chunk(5) as $chunk)
                                <div class="m-grid-row">
                                    @foreach($chunk as $item)
                                        <div class="m-grid-col m-grid-col-middle m-grid-col-center">

                                            <img width="80" alt="{{$item["content"]->name}}" src="{{( ( isset($item["thumbnail"]) && ( strlen($item["thumbnail"]) > 0 ) ) ? $item["thumbnail"] : 'https://www.freeiconspng.com/uploads/orange-pdf-icon-32.png' )}}"/>
                                            <br/>
                                            <a href="{{action("EducationalContentController@show" , $item["content"])}}">
                                                    <i class="fa fa-angle-left"></i>
                                                {{$item["content"]->name}}
                                            </a>

                                        </div>
                                        {{--<li class="mt-list-item @if($item["content"]->id == $educationalContent->id) bg-grey-mint @endif ">--}}
                                            {{--<div class="list-icon-container">--}}
                                                {{--<a href="{{action("EducationalContentController@show" , $item["content"])}}">--}}
                                                    {{--<i class="fa fa-angle-left"></i>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="list-thumb">--}}
                                                {{--<a href="{{action("EducationalContentController@show" , $item["content"])}}">--}}
                                                    {{--<img alt="{{$item["content"]->name}}"--}}
                                                         {{--src="{{(isset($item["thumbnail"]))?$item["thumbnail"]:''}}"/>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="list-datetime bold uppercase font-yellow-casablanca"> {{$item["content"]->name}} </div>--}}
                                            {{--<div class="list-item-content">--}}
                                                {{--<h3 class="uppercase bold">--}}
                                                    {{--<a href="javascript:;">&nbsp;</a>--}}
                                                {{--</h3>--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    @endforeach
                                </div>

                            @endforeach
                                <style>
                                    .m-grid.m-grid-demo .m-grid-col{
                                        border: none !important;
                                        min-height: 150px !important;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                    {{--<div class="mt-element-list">--}}
                        {{--<div class="mt-list-head list-news ext-1 font-white bg-blue">--}}
                            {{--<div class="list-head-title-container">--}}
                                {{--<h3 class="list-title">جزوات مرتبط</h3>--}}
                            {{--</div>--}}
                            {{--<div class="list-count pull-right bg-blue-chambray"></div>--}}
                        {{--</div>--}}
                        {{--<div class="mt-list-container list-news ext-2">--}}
                            {{--<div class="scroller" style="height:500px" data-always-visible="1" data-rail-visible="1"--}}
                                 {{--data-rail-color="red" data-handle-color="green">--}}
                                {{--<ul>--}}
                                    {{--@foreach($contentsWithSameSet->whereIn("type" , "pamphlet" ) as $item)--}}
                                        {{--<li class="mt-list-item @if($item["content"]->id == $educationalContent->id) bg-grey-mint @endif ">--}}
                                            {{--<div class="list-icon-container">--}}
                                                {{--<a href="{{action("EducationalContentController@show" , $item["content"])}}">--}}
                                                    {{--<i class="fa fa-angle-left"></i>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="list-thumb">--}}
                                                {{--<a href="{{action("EducationalContentController@show" , $item["content"])}}">--}}
                                                    {{--<img alt="{{$item["content"]->name}}"--}}
                                                         {{--src="{{(isset($item["thumbnail"]))?$item["thumbnail"]:''}}"/>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="list-datetime bold uppercase font-yellow-casablanca"> {{$item["content"]->name}} </div>--}}
                                            {{--<div class="list-item-content">--}}
                                                {{--<h3 class="uppercase bold">--}}
                                                    {{--<a href="javascript:;">&nbsp;</a>--}}
                                                {{--</h3>--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}

                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
            @endif
        @elseif($educationalContent->template->name == "pamphlet1" )
            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    {{isset($educationalContentDisplayName) ? $educationalContentDisplayName : "" }}
                            </div>
                            <div class="actions">
                                @if($files->count() == 1)
                                    <a target="_blank"
                                       href="{{action("HomeController@download" , ["fileName"=>$files->first()->uuid ])}}"
                                       class="btn btn-circle green btn-outline btn-sm"><i class="fa fa-download"></i>
                                        دانلود </a>
                                @else
                                    <div class="btn-group">
                                        <button class="btn btn-circle green btn-outline btn-sm" data-toggle="dropdown"
                                                aria-expanded="true">دانلود
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($files as $file)
                                                <li>
                                                    <a target="_blank"
                                                       href="{{action("HomeController@download" , ["fileName"=>$file->uuid ])}}">
                                                        فایل {{$file->pivot->caption}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body">
                                @if($fileToShow->getExtention() === "pdf")
                                    <iframe class="google-docs"
                                            src='http://docs.google.com/viewer?url={{$fileToShow->getUrl()}}&embedded=true'
                                            width='100%' height='760' style='border: none;'></iframe>
                                @endif
                            <div class="row">
                                <div class="col-md-12">
                                    @if(!empty($tags))
                                        <hr>
                                        @include("partials.search.tagLabel" , ["tags"=>$tags])
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comment-o" aria-hidden="true"></i>
                                    درباره فایل
                            </div>
                        </div>
                        <div class="portlet-body text-justify">
                            <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="black"
                                 data-handle-color="#a1b2bd">
                                @if(isset($educationalContent->description[0]))
                                    {!! $educationalContent->description !!}
                                @else
                                    به زودی ...
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                {{--<div class="col-md-4">--}}
                    {{--@if($contentsWithSameType->isNotEmpty())--}}
                        {{--<div class="mt-element-list">--}}
                            {{--<div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">--}}
                                {{--<div class="list-head-title-container">--}}
                                    {{--<div class="list-date">Nov 8, 2015</div>--}}
                                    {{--<h3 class="list-title">@if(isset($rootContentType->displayName[0])){{$rootContentType->displayName}}@endif--}}
                                        {{--های @if(isset($childContentType->displayName[0])){{$childContentType->displayName}}@endif--}}
                                        {{--دیگر</h3>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="mt-list-container list-simple ext-1">--}}
                                {{--<ul>--}}
                                    {{--@foreach($contentsWithSameType as $content)--}}
                                        {{--<li class="mt-list-item">--}}
                                            {{--<div class="list-icon-container">--}}
                                                {{--<i class="fa fa-file-pdf-o" aria-hidden="true"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="list-datetime"> @if($content->grades->isNotEmpty()){{$content->grades->first()->displayName}}@endif</div>--}}
                                            {{--<div class="list-item-content">--}}
                                                {{--<h5 class="uppercase">--}}
                                                    {{--<a href="{{action("EducationalContentController@show" , $content)}}">{{$content->getDisplayName()}}</a>--}}
                                                {{--</h5>--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</div>--}}
            </div>
        @elseif($educationalContent->template->name == "article1")
            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    {{$educationalContent->name}}
                            </div>
                        </div>
                        <div class="portlet-body">
                                {!! $educationalContent->context !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(!empty($tags))
                                            <hr>
                                            @include("partials.search.tagLabel" , ["tags"=>$tags])
                                        @endif
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comment-o" aria-hidden="true"></i>
                                    درباره مقاله
                            </div>
                        </div>
                        <div class="portlet-body text-justify">
                            <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="black"
                                 data-handle-color="#a1b2bd">
                                @if(isset($educationalContent->description[0])) {!! $educationalContent->description !!} @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    {{--@if($contentsWithSameType->isNotEmpty())--}}
                        {{--<div class="mt-element-list">--}}
                            {{--<div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">--}}
                                {{--<div class="list-head-title-container">--}}
                                    {{--<div class="list-date">Nov 8, 2015</div>--}}
                                    {{--<h3 class="list-title">@if(isset($rootContentType->displayName[0])){{$rootContentType->displayName}}@endif--}}
                                        {{--های @if(isset($childContentType->displayName[0])){{$childContentType->displayName}}@endif--}}
                                        {{--دیگر</h3>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="mt-list-container list-simple ext-1">--}}
                                {{--<ul>--}}
                                    {{--@foreach($contentsWithSameType as $content)--}}
                                        {{--<li class="mt-list-item">--}}
                                            {{--<div class="list-icon-container">--}}
                                                {{--<i class="fa fa-file-pdf-o" aria-hidden="true"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="list-datetime"> @if($content->grades->isNotEmpty()){{$content->grades->first()->displayName}}@endif</div>--}}
                                            {{--<div class="list-item-content">--}}
                                                {{--<h5 class="uppercase">--}}
                                                    {{--<a href="{{action("EducationalContentController@show" , $content)}}">{{$content->getDisplayName()}}</a>--}}
                                                {{--</h5>--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                </div>
            </div>
        @endif
    @else
        قالب محتوا تنظیم نشده است
    @endif
@endsection

@section("footerPageLevelPlugin")
@endsection

@section("footerPageLevelScript")
@endsection

@section("extraJS")
    <script type="text/javascript">

        $(document).ready(function (){
            var container = $("#playListScroller"),
                scrollTo = $("#playlistItem_"+"{{$educationalContent->id}}");
            container.scrollTop(
                scrollTo.offset().top - container.offset().top + container.scrollTop() - 100
            );
            $("#otherSessions").find(".slimScrollBar").css("top" , scrollTo.offset().top +"px");
        });
    </script>
@endsection