@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
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
    <link href='https://sanatisharif.ir/package/video-js-5.11.3/video-js.css' rel="stylesheet">
    <link href='https://sanatisharif.ir/package/video-js-5.11.3/videojs-resolution-switcher-0.4.2/lib/videojs-resolution-switcher.css'
          rel="stylesheet">
    {{--<link href="http://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">--}}
@endsection

@section("title")
    <title>تخته خاک|محتوای آموزشی|جزوه|آزمون</title>
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
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                فیلم {{$educationalContent->name}}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="video">
                                <video id='{{$educationalContent->id}}' class='video-js vjs-default-skin' controls
                                       preload='auto'
                                       poster='@if(isset($files["thumbnail"])){{$files["thumbnail"]}}@endif'
                                       width='100%' height='400px'>
                                    @foreach($files["videoSource"] as $source)
                                        <source label='{{$source["caption"]}}' src='{{$source["src"]}}'
                                                type='video/mp4'/>
                                    @endforeach
                                    <p class="vjs-no-js">جهت پخش آنلاین فیلم، ابتدا مطمئن شوید که جاوا اسکریپت در مرور
                                        گر شما فعال است و از آخرین نسخه ی مرورگر استفاده می کنید.</p>
                                </video>
                            </div>
                            {{--<hr>--}}
                            {{--<ul class="list-inline">--}}
                            {{--<li><i class="fa fa-map-marker"></i>مدرس : محمدرضا مقصودی</li>&nbsp;--}}
                            {{--<li><i class="fa fa-heart"></i>&nbsp;سوم دبیرستان ۹۶-۹۷</li>--}}
                            {{--</ul>--}}
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
                <div class="col-md-4 margin-bottom-15">
                    <div class="mt-element-list">
                        <div class="mt-list-head list-news ext-1 font-white bg-yellow-crusta">
                            <div class="list-head-title-container">
                                <h3 class="list-title">جلسات دیگر</h3>
                            </div>
                            <div class="list-count pull-right bg-yellow-saffron"></div>
                        </div>
                        <div class="mt-list-container list-news ext-2">
                            <div class="scroller" style="height:500px" data-always-visible="1" data-rail-visible="1"
                                 data-rail-color="red" data-handle-color="green">
                                <ul>

                                    @foreach($contentsWithSameSet->whereIn("type" , "video" ) as $item)
                                        <li class="mt-list-item @if($item["content"]->id == $educationalContent->id) bg-grey-mint @endif ">
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
                                            <div class="list-datetime bold uppercase font-yellow-casablanca"> {{(isset($item["content"]->name))?$item["content"]->name:"بدون عنوان"}} </div>
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
                            <div class="scroller" style="height:100px" data-rail-visible="1" data-rail-color="black"
                                 data-handle-color="#a1b2bd">
                                @if(isset($educationalContent->description[0])) {!! $educationalContent->description !!} @endif
                            </div>

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
        @elseif($educationalContent->template->name == "pamphlet1")
            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    {{$educationalContent->getDisplayName()}}
                            </div>
                            <div class="actions">
                                @if($educationalContent->files->count() == 1)
                                    <a target="_blank"
                                       href="{{action("HomeController@download" , ["fileName"=>$educationalContent->files->first()->uuid ])}}"
                                       class="btn btn-circle green btn-outline btn-sm"><i class="fa fa-download"></i>
                                        دانلود </a>
                                @else
                                    <div class="btn-group">
                                        <button class="btn btn-circle green btn-outline btn-sm" data-toggle="dropdown"
                                                aria-expanded="true">دانلود
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($educationalContent->files as $file)
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
                            @if($educationalContent->getFilesUrl()->isNotEmpty())
                                @if($educationalContent->file->getExtention() === "pdf")
                                    <iframe class="google-docs"
                                            src='http://docs.google.com/viewer?url={{$educationalContent->getFilesUrl()->first()}}&embedded=true'
                                            width='100%' height='760' style='border: none;'></iframe>
                                @endif
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
                                @if(isset($educationalContent->description[0])) {!! $educationalContent->description !!} @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    @if($contentsWithSameType->isNotEmpty())
                        <div class="mt-element-list">
                            <div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">
                                <div class="list-head-title-container">
                                    {{--<div class="list-date">Nov 8, 2015</div>--}}
                                    <h3 class="list-title">@if(isset($rootContentType->displayName[0])){{$rootContentType->displayName}}@endif
                                        های @if(isset($childContentType->displayName[0])){{$childContentType->displayName}}@endif
                                        دیگر</h3>
                                </div>
                            </div>
                            <div class="mt-list-container list-simple ext-1">
                                <ul>
                                    @foreach($contentsWithSameType as $content)
                                        <li class="mt-list-item">
                                            <div class="list-icon-container">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="list-datetime"> @if($content->grades->isNotEmpty()){{$content->grades->first()->displayName}}@endif</div>
                                            <div class="list-item-content">
                                                <h5 class="uppercase">
                                                    <a href="{{action("EducationalContentController@show" , $content)}}">{{$content->getDisplayName()}}</a>
                                                </h5>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
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
                    @if($contentsWithSameType->isNotEmpty())
                        <div class="mt-element-list">
                            <div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">
                                <div class="list-head-title-container">
                                    {{--<div class="list-date">Nov 8, 2015</div>--}}
                                    <h3 class="list-title">@if(isset($rootContentType->displayName[0])){{$rootContentType->displayName}}@endif
                                        های @if(isset($childContentType->displayName[0])){{$childContentType->displayName}}@endif
                                        دیگر</h3>
                                </div>
                            </div>
                            <div class="mt-list-container list-simple ext-1">
                                <ul>
                                    @foreach($contentsWithSameType as $content)
                                        <li class="mt-list-item">
                                            <div class="list-icon-container">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="list-datetime"> @if($content->grades->isNotEmpty()){{$content->grades->first()->displayName}}@endif</div>
                                            <div class="list-item-content">
                                                <h5 class="uppercase">
                                                    <a href="{{action("EducationalContentController@show" , $content)}}">{{$content->getDisplayName()}}</a>
                                                </h5>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @else
        قالب محتوا تنظیم نشده است
    @endif

    {{--RELATED CONTENT COMMING SOON   --}}
    {{--<div class="row">--}}
        {{--<div class="col-md-6">--}}
            {{--@include("educationalContent.partials.similarContent")--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/js/extraJS/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    {{--<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>--}}
    <!-- If you'd like to support IE8 -->
    <script type="text/javascript"
            src="https://sanatisharif.ir/package/video-js-5.11.3/ie8/videojs-ie8.min.js"></script>
    <script type="text/javascript" src="https://sanatisharif.ir/package/video-js-5.11.3/video.min.js"></script>

    <script type="text/javascript"
            src="https://sanatisharif.ir/package/video-js-5.11.3/videojs-resolution-switcher-0.4.2/lib/videojs-resolution-switcher.js"></script>
    <script>videojs.options.flash.swf = "https://sanatisharif.ir/package/video-js-5.11.3/video-js.swf";</script>
    <script type="text/javascript">
        $(document).ready(function () {
            videojs('{{$educationalContent->id}}', {
                fluid: true,
                plugins: {
                    videoJsResolutionSwitcher: {
                        default: 'low',
                        dynamicLabel: true
                    }
                }
            }, function () {

                var myPlayer = this;

                myPlayer.dimensions('100%', '400px');
                myPlayer.videoJsResolutionSwitcher();

                myPlayer.on('resolutionchange', function () {
                    console.info('Source changed to %s', myPlayer.src())
                });
            });
            $('.switch').hover(function () {
                $(this).fadeTo('fast', 0.5);
            }, function () {
                $(this).fadeTo('fast', 1);
            });
        });
    </script>
@endsection