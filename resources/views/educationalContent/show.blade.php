@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <style>
        @media screen and (max-width: 480px) {
            .google-docs{
                height: 350px;
            }
        }

        .mt-element-list{
            background-color: white;
        }

    </style>
    <link  href='https://sanatisharif.ir/package/video-js-5.11.3/video-js.css' rel="stylesheet">
    <link  href='https://sanatisharif.ir/package/video-js-5.11.3/videojs-resolution-switcher-0.4.2/lib/videojs-resolution-switcher.css' rel="stylesheet">
    {{--<link href="http://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">--}}
@endsection

@section("title")
    <title>تخته خاک|محتوای آموزشی|جزوه|آزمون</title>
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

    <div class="row">
        @if($educationalContent->template->name == "video1")
            <div class="col-md-8">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                {{$educationalContent->getDisplayName()}}
                        </div>
                    </div>
                    <div class="portlet-body" >
                        <div class="video">
                            <video id='{{$educationalContent->id}}'  class='video-js vjs-default-skin' controls preload='auto' poster='{{$educationalContent->files->where("pivot.label" , "thumbnail")->first()->name}}' width='100%' height='400px'>
                                @foreach($videoSources as $source)
                                    <source label='{{$source["caption"]}}' src='{{$source["src"]}}' type='video/mp4' />
                                @endforeach
                                <p class="vjs-no-js">جهت پخش آنلاین فیلم، ابتدا مطمئن شوید که جاوا اسکریپت در مرور گر شما فعال است و از آخرین نسخه ی مرورگر استفاده می کنید.</p>
                            </video>
                        </div>
                        <hr>
                        <ul class="list-inline">
                            <li><i class="fa fa-map-marker"></i>مدرس : محمدرضا مقصودی</li>&nbsp;
                            <li><i class="fa fa-heart"></i>&nbsp;سوم دبیرستان ۹۶-۹۷</li>
                        </ul>
                        <hr>
                        <ul class="list-inline">
                            <li><i class="fa fa-map-marker"></i>مدرس : محمدرضا مقصودی</li>&nbsp;
                            <li><i class="fa fa-calendar"></i>&nbsp;19 اسفند الی 30 فروردین</li>&nbsp;
                            <li><i class="fa fa-briefcase"></i> برنامه ریزی</li>
                            <li><i class="fa fa-star"></i> رفع اشکال</li>
                            <li><i class="fa fa-heart"></i>&nbsp;لحظه به لحظه تا کنکور</li>
                        </ul>
                    </div>

                </div>
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-comment-o" aria-hidden="true"></i>
                            توضیح
                        </div>
                    </div>
                    <div class="portlet-body text-justify" >
                        <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="black" data-handle-color="#a1b2bd">
                            @if(isset($educationalContent->description[0])) {!! $educationalContent->description !!} @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mt-element-list">
                    <div class="mt-list-head list-news ext-1 font-white bg-yellow-crusta">
                        <div class="list-head-title-container">
                            <h3 class="list-title">جلسات دیگر</h3>
                        </div>
                        <div class="list-count pull-right bg-yellow-saffron"></div>
                    </div>
                           <div class="mt-list-container list-news ext-2" >
                        <div class="scroller" style="height:500px" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                            <ul>

                                @foreach($contentsWithSameSet as $item)
                                    <li class="mt-list-item @if($item->id == $educationalContent->id) bg-grey-mint @endif ">
                                        <div class="list-icon-container">
                                            <a href="{{action("EducationalContentController@show" , $item)}}">
                                                <i class="fa fa-angle-left"></i>
                                            </a>
                                        </div>
                                        <div class="list-thumb">
                                            <a href="{{action("EducationalContentController@show" , $item)}}">
                                                <img alt="" src="{{$item->files->where("pivot.label" , "thumbnail")->first()->name}}" />
                                            </a>
                                        </div>
                                        <div class="list-datetime bold uppercase font-yellow-casablanca"> {{$item->name}} </div>
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
                {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                {{--<a href="{{action("ProductController@landing2")}}"><img src="https://takhtekhak.com/image/4/300/300/D1-TALAEE-6_20180209174708.jpg" alt="اردو غیر حضوری" style="width: 100%"></a>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        @else
            <div class="col-md-8">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            @if(in_array("article" , $educationalContent->contenttypes->pluck("name")->toArray()))
                                {{$educationalContent->name}}
                            @else
                                {{$educationalContent->getDisplayName()}}
                            @endif
                        </div>
                        @if(!in_array("video" , $educationalContent->contenttypes->pluck("name")->toArray())
                        && !in_array("article" , $educationalContent->contenttypes->pluck("name")->toArray()))
                            <div class="actions">
                                @if($educationalContent->files->count() == 1)
                                    <a target="_blank" href="{{action("HomeController@download" , ["fileName"=>$educationalContent->files->first()->uuid ])}}" class="btn btn-circle green btn-outline btn-sm"><i class="fa fa-download"></i> دانلود </a>
                                @else
                                    <div class="btn-group">
                                        <button class="btn btn-circle green btn-outline btn-sm" data-toggle="dropdown" aria-expanded="true">دانلود
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($educationalContent->files as $file)
                                                <li>
                                                    <a target="_blank" href="{{action("HomeController@download" , ["fileName"=>$file->uuid ])}}" > فایل {{$file->pivot->caption}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="portlet-body" >
                            @if(in_array("video" , $educationalContent->contenttypes->pluck("name")->toArray()))
                                @if($educationalContent->id == 130)
                                    <iframe frameborder="0" allowfullscreen id="liveFrame" src="http://185.49.84.107:9092/index.html" width="100%" height="500"></iframe>
                                @elseif($educationalContent->id == 131)
                                    <iframe frameborder="0" allowfullscreen id="liveFrame" src="http://185.49.84.107:9092/index2.html" width="100%" height="500"></iframe>
                                @endif
                            @elseif(in_array("article" , $educationalContent->contenttypes->pluck("name")->toArray()))
                                {!! $educationalContent->context !!}
                            @elseif($educationalContent->getFilesUrl()->isNotEmpty())
                                @if($educationalContent->file->getExtention() === "pdf")
                                    <iframe class="google-docs" src='http://docs.google.com/viewer?url={{$educationalContent->getFilesUrl()->first()}}&embedded=true' width='100%' height='760' style='border: none;'></iframe>
                                @elseif(isset($educationalContent->description[0]))
                                    <p>
                                        {!! $educationalContent->description !!}
                                    </p>
                                @endif
                            @endif
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                @if( ( !is_null($educationalContent->file) and $educationalContent->file->getExtention() != "rar" ) or is_null($educationalContent->file))
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comment-o" aria-hidden="true"></i>
                                @if(in_array("article" , $educationalContent->contenttypes->pluck("name")->toArray()))
                                    درباره مقاله
                                @else
                                    درباره فایل
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body text-justify" >
                            <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="black" data-handle-color="#a1b2bd">
                                @if(isset($educationalContent->description[0])) {!! $educationalContent->description !!} @endif
                            </div>

                        </div>
                    </div>
                @endif
                @if(in_array("article" , $educationalContent->contenttypes->pluck("name")->toArray()))
                    <div class="row margin-bottom-10">
                        <div class="col-md-12">
                            <div class="mt-element-list">
                                <div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">
                                    <div class="list-head-title-container">
                                        {{--<div class="list-date">Nov 8, 2015</div>--}}
                                        <h3 class="list-title">مطالب دیگر</h3>
                                    </div>
                                </div>
                                <div class="mt-list-container list-simple ext-1">
                                    <ul>
                                        <li class="mt-list-item">
                                            <div class="list-icon-container">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="list-datetime"> کنکوری </div>
                                            <div class="list-item-content">
                                                <h5 class="uppercase">
                                                    <a href="{{action("ProductController@show" , 196)}}">اردوی غیر حضوری</a>
                                                </h5>
                                            </div>
                                        </li>
                                        <li class="mt-list-item">
                                            <div class="list-icon-container">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="list-datetime"> کنکوری </div>
                                            <div class="list-item-content">
                                                <h5 class="uppercase">
                                                    <a href="{{action("EducationalContentController@show" , 184)}}">اردوی حضوری</a>
                                                </h5>
                                            </div>
                                        </li>
                                        <li class="mt-list-item">
                                            <div class="list-icon-container">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="list-datetime"> کنکوری </div>
                                            <div class="list-item-content">
                                                <h5 class="uppercase">
                                                    <a href="{{action("EducationalContentController@show" , 130)}}">جلسه اول جمع بندی عربی کنکور</a>
                                                </h5>
                                            </div>
                                        </li>
                                        <li class="mt-list-item">
                                            <div class="list-icon-container">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="list-datetime"> کنکوری </div>
                                            <div class="list-item-content">
                                                <h5 class="uppercase">
                                                    <a href="{{action("EducationalContentController@show" , 131)}}">جلسه دوم جمع بندی عربی کنکور5</a>
                                                </h5>
                                            </div>
                                        </li>
                                        <li class="mt-list-item">
                                            <div class="list-icon-container">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="list-datetime"> کنکوری </div>
                                            <div class="list-item-content">
                                                <h5 class="uppercase">
                                                    <a href="{{action("EducationalContentController@show" , 129)}}">جمع بندی عربی کنکور - بررسی نقش ها در جمله در زبان عربی</a>
                                                </h5>
                                            </div>
                                        </li>
                                        <li class="mt-list-item">
                                            <div class="list-icon-container">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="list-datetime"> کنکوری </div>
                                            <div class="list-item-content">
                                                <h5 class="uppercase">
                                                    <a href="{{action("ProductController@landing1")}}">جمع بندی نیمسال اول کنکور در 1+5 ساعت</a>
                                                </h5>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row margin-bottom-10">
                    <div class="col-md-12">
                        @if($contentsWithSameType->isNotEmpty())
                            <div class="mt-element-list">
                                <div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">
                                    <div class="list-head-title-container">
                                        {{--<div class="list-date">Nov 8, 2015</div>--}}
                                        <h3 class="list-title">@if(isset($rootContentType->displayName[0])){{$rootContentType->displayName}}@endif های @if(isset($childContentType->displayName[0])){{$childContentType->displayName}}@endif دیگر</h3>
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
                <div class="row">
                    <div class="col-md-12">
                        @include("educationalContent.partials.similarContent")
                    </div>
                </div>
                {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                {{--<a href="{{action("ProductController@landing2")}}"><img src="https://takhtekhak.com/image/4/300/300/D1-TALAEE-6_20180209174708.jpg" alt="اردو غیر حضوری" style="width: 100%"></a>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        @endif
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
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
    <script type="text/javascript" src="https://sanatisharif.ir/package/video-js-5.11.3/ie8/videojs-ie8.min.js"></script>
    <script type="text/javascript" src="https://sanatisharif.ir/package/video-js-5.11.3/video.min.js"></script>

    <script type="text/javascript" src="https://sanatisharif.ir/package/video-js-5.11.3/videojs-resolution-switcher-0.4.2/lib/videojs-resolution-switcher.js"></script>
    <script>videojs.options.flash.swf = "https://sanatisharif.ir/package/video-js-5.11.3/video-js.swf";</script>
    <script type="text/javascript">
        $( document ).ready(function() {
            videojs( '{{$educationalContent->id}}', {
                fluid: true,
                plugins : {
                    videoJsResolutionSwitcher: {
                        default: 'low',
                        dynamicLabel : true
                    }
                } }, function() {

                var myPlayer = this;

                myPlayer.dimensions( '100%', '400px' );
                myPlayer.videoJsResolutionSwitcher();

                myPlayer.on('resolutionchange', function(){
                    console.info('Source changed to %s', myPlayer.src())
                });
            });
            $('.switch').hover(function(){
                $(this).fadeTo('fast', 0.5);
            }, function(){
                $(this).fadeTo('fast', 1);
            });
        });
    </script>
@endsection