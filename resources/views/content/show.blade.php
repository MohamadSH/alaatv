@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link href="/video-js/video-js.min.css" rel="stylesheet">
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


@section("bodyClass")
    class = "page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("pageBar")
@endsection
@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">@lang('content.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <i class="fa fa-list-ul" aria-hidden="true"></i>
                <a href="{{action("ContentController@index")}}">@lang('content.Educational Content Of Alaa')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>@lang('content.show'){{ " ".$content->displayName }}</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    @if(isset($content->template))
        @if(optional($content->template)->name == "video1")
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-body  text-justify">
                            <div class="row col-md-8">
                                <video id="video-{{$content->id}}"
                                       class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered"
                                       controls
                                       preload="auto"
                                       height='360'
                                       width="640"
                                       poster='{{$content->thumbnail}}'>

                                    @foreach($content->getVideos() as $source)
                                        <source src="{{ $source->link }}" type='video/mp4' res="{{ $source->res }}"
                                                @if(strcmp( $source->res,"240p") == 0) default
                                                @endif label="{{ $source->caption }}"/>
                                    @endforeach
                                    <p class="vjs-no-js">@lang('content.javascript is disables! we need it to play a video')</p>
                                </video>

                            </div>
                            @if(isset($videosWithSameSet) and $videosWithSameSet->isNotEmpty())
                                <div class="row">
                                    <div class="col-md-12">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-sm ">
                                                <li class="page-item">
                                                    <a class="page-link"
                                                       href="{{action("ContentController@show" , $videosWithSameSet->first()["content"])}}"
                                                       aria-label="اولین">
                                                        <span aria-hidden="true">&laquo;</span>
                                                        <span class="sr-only">اولین</span>
                                                    </a>
                                                </li>
                                                @foreach($videosWithSameSetL->take(-5) as $item)

                                                    <li class="page-item @if($item["content"]->id == $content->id) active @endif">
                                                        <a class="page-link"
                                                           href="{{action("ContentController@show" , $item["content"])}}">{{ $item["content"]->order }}</a>
                                                    </li>

                                                @endforeach
                                                @foreach($videosWithSameSetR->take(6) as $item)

                                                    <li class="page-item @if($item["content"]->id == $content->id) active @endif">
                                                        <a class="page-link"
                                                           href="{{action("ContentController@show" , $item["content"])}}">{{ $item["content"]->order }}</a>
                                                    </li>

                                                @endforeach
                                                <li class="page-item">
                                                    <a class="page-link"
                                                       href="{{action("ContentController@show" , $videosWithSameSet->last()["content"])}}"
                                                       aria-label="آخرین">
                                                        <span aria-hidden="true">&raquo;</span>
                                                        <span class="sr-only">آخرین</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <hr>
                                    <div class="col-md-7">
                                        <div class="caption"><i class="fa fa-comment-o" aria-hidden="true"></i></div>
                                        <h2 style="font-size: 20px; font-weight: 500;">{{ $content->displayName }}</h2>

                                        @if(isset($content->description[0]))
                                            <div class="scroller" style="max-height:400px ; " data-rail-visible="1"
                                                 data-rail-color="black" data-handle-color="#a1b2bd">
                                                {!! $content->description !!}
                                            </div>
                                        @else
                                            به زودی ...
                                        @endif
                                    </div>

                                    <div class="col-md-5">
                                        @if(isset($content->author_id))

                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-user"></i>{{$author}}</li>
                                                &nbsp
                                                @if(isset($contentSetName))
                                                    <li><i class="fa fa-tv"></i>{{$contentSetName}}</li>&nbsp;
                                                @endif
                                                @if($userCanSeeCounter)
                                                    <li>
                                                        <i class="fa fa-eye"></i>
                                                        {{$seenCount}}
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <hr>
                                <div class="col-md-12">
                                    @if(!empty($tags))
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
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        لینک های دانلود
                                    </div>
                                </div>

                                @if(isset($content->file) and $content->file->isNotEmpty())
                                    <div class="portlet-body text-justify">
                                        <p>
                                            پیشنهاد می کنیم برای دانلود، از نرم افزار Internet Download Manager در
                                            ویندوز و یا ADM در اندروید و یا wget در لینوکس استفاده بفرمایید.
                                        </p>
                                        <p>
                                            جهت دانلود روی یکی از دکمه های زیر کلیک کنید:
                                        </p>
                                        <div class="row">


                                            @foreach($content->file->get('video') as $file)
                                                <div class="col-md-4">
                                                    <a href="{{$file->link}}?download=1" class="btn red margin-bottom-5"
                                                       style="width: 250px;">
                                                        فایل {{$file->caption}}{{ isset($file->size[0]) ? "(".$file->size. ")":""  }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 margin-bottom-15">
                    @if(isset($videosWithSameSet) && $videosWithSameSet->isNotEmpty())
                        <div class="mt-element-list">
                            <div class="mt-list-head list-news ext-1 font-white bg-yellow-crusta">
                                <div class="list-head-title-container">
                                    <h3 class="list-title">
                                        جلسات دیگر
                                        @if(isset($contentSetName))
                                            {{ $contentSetName }}
                                        @endif
                                    </h3>
                                </div>
                                <div class="list-count pull-right bg-yellow-saffron"></div>
                            </div>
                            <div class="mt-list-container list-news ext-1" id="otherSessions">
                                <div id="playListScroller" class="scroller" style="min-height: 50px; max-height:950px"
                                     data-always-visible="1" data-rail-visible="1"
                                     data-rail-color="red" data-handle-color="green">
                                    <ul>
                                        @foreach($videosWithSameSet as $item)
                                            <li class="mt-list-item @if($item["content"]->id == $content->id) bg-grey-mint @endif "
                                                id="playlistItem_{{$item["content"]->id}}">
                                                <div class="list-icon-container">
                                                    <a href="{{action("ContentController@show" , $item["content"])}}">
                                                        <i class="fa fa-angle-left"></i>
                                                    </a>
                                                </div>
                                                <div class="list-thumb">
                                                    <a href="{{action("ContentController@show" , $item["content"])}}">
                                                        <img alt="{{$item["content"]->name}}"
                                                             src="{{(isset($item["thumbnail"]))?$item["thumbnail"]."?w=210&h=118":''}}"/>
                                                    </a>
                                                </div>
                                                <div class="list-datetime bold uppercase font-yellow-casablanca">
                                                    <a href="{{action("ContentController@show" , $item["content"])}}">
                                                        {{($item["content"]->display_name)}}
                                                    </a>
                                                </div>
                                                <div class="list-item-content">
                                                    <h3 class="uppercase bold">
                                                        <a href="javascript:">&nbsp;</a>
                                                    </h3>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-md-4 margin-bottom-15">
                    @if(isset($adItems) )
                        <div class="portlet light margin-top-10">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                                    نمونه همایش های طلایی 97
                                </div>
                            </div>

                            <div class="portlet-body">
                                @include("content.partials.adSideBar" , ["items" => $adItems])
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <style>
                .mt-list-item {
                    min-height: 150px;
                }

                .list-thumb {
                    padding-left: 10px;
                    width: 220px !important;
                    height: 110px !important;
                }
            </style>
            @if(isset($pamphletsWithSameSet) && $pamphletsWithSameSet->isNotEmpty())
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
                                    @foreach($pamphletsWithSameSet->chunk(5) as $chunk)
                                        <div class="m-grid-row">
                                            @foreach($chunk as $item)
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center">

                                                    <img width="80" alt="{{$item["content"]->name}}"
                                                         src="{{( ( isset($item["thumbnail"]) && ( strlen($item["thumbnail"]) > 0 ) ) ? $item["thumbnail"] : '/img/extra/orange-pdf-icon-32.png' )}}"/>
                                                    <br/>
                                                    <a href="{{action("ContentController@show" , $item["content"])}}">
                                                        <i class="fa fa-angle-left"></i>
                                                        {{$item["content"]->name}}
                                                    </a>

                                                </div>
                                            @endforeach
                                        </div>

                                    @endforeach
                                    <style>
                                        .m-grid.m-grid-demo .m-grid-col {
                                            border: none !important;
                                            min-height: 150px !important;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @elseif(optional($content->template)->name == "pamphlet1" )
            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                {{ $content->displayName  }}
                            </div>
                            <div class="actions">
                                @if($content->file->count() == 1)

                                    <a target="_blank"
                                       href="{{ $content->getPamphlets()->first()->link }}"
                                       class="btn btn-circle green btn-outline btn-sm"><i class="fa fa-download"></i>
                                        دانلود </a>
                                @else
                                    <div class="btn-group">
                                        <button class="btn btn-circle green btn-outline btn-sm" data-toggle="dropdown"
                                                aria-expanded="true">دانلود
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($content->getPamphlets() as $file)
                                                <li>
                                                    <a target="_blank" href="{{ $file->link }}">{{ $file->caption }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if($content->getPamphlets()->first()->ext === 'pdf')
                                <iframe class="google-docs"
                                        src='https://docs.google.com/viewer?url={{$content->getPamphlets()->first()->link}}&embedded=true'
                                        width='100%' height='760' style='border: none;'>

                                </iframe>
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
                                @if(isset($content->description[0]))
                                    {!! $content->description !!}
                                @else
                                    به زودی ...
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 margin-bottom-15">
                    @if(isset($videosWithSameSet) && $videosWithSameSet->isNotEmpty())
                        <div class="mt-element-list">
                            <div class="mt-list-head list-news ext-1 font-white bg-yellow-crusta">
                                <div class="list-head-title-container">
                                    <h3 class="list-title">فیلم های درس</h3>
                                </div>
                                <div class="list-count pull-right bg-yellow-saffron"></div>
                            </div>
                            <div class="mt-list-container list-news ext-2" id="otherSessions">
                                <div id="playListScroller" class="scroller" style="min-height: 50px; max-height:500px"
                                     data-always-visible="1" data-rail-visible="1"
                                     data-rail-color="red" data-handle-color="green">
                                    <ul>

                                        @foreach($videosWithSameSet as $item)
                                            <li class="mt-list-item @if($item["content"]->id == $content->id) bg-grey-mint @endif "
                                                id="playlistItem_{{$item["content"]->id}}">
                                                <div class="list-icon-container">
                                                    <a href="{{action("ContentController@show" , $item["content"])}}">
                                                        <i class="fa fa-angle-left"></i>
                                                    </a>
                                                </div>
                                                <div class="list-thumb">
                                                    <a href="{{action("ContentController@show" , $item["content"])}}">
                                                        <img alt="{{$item["content"]->name}}"
                                                             src="{{(isset($item["thumbnail"]))?$item["thumbnail"]:''}}"/>
                                                    </a>
                                                </div>
                                                <div class="list-datetime bold uppercase font-yellow-casablanca"> {{($item["content"]->display_name)}} </div>
                                                <div class="list-item-content">
                                                    <h3 class="uppercase bold">
                                                        <a href="javascript:">&nbsp;</a>
                                                    </h3>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($adItems) )
                        <div class="portlet light margin-top-10">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                                    نمونه همایش های طلایی 97
                                </div>
                            </div>

                            <div class="portlet-body">
                                @include("content.partials.adSideBar" , ["items" => $adItems])
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if(isset($pamphletsWithSameSet) && $pamphletsWithSameSet->where("content.id" , "<>",$content->id)->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-comment-o" aria-hidden="true"></i>
                                    جزوات دیگر
                                </div>
                            </div>
                            <div class="portlet-body text-justify">
                                <div class="m-grid m-grid-demo">
                                    @foreach($pamphletsWithSameSet->chunk(5) as $chunk)
                                        <div class="m-grid-row">
                                            @foreach($chunk as $item)
                                                <div class="m-grid-col m-grid-col-middle m-grid-col-center">

                                                    <img width="80" alt="{{$item["content"]->name}}"
                                                         src="{{( ( isset($item["thumbnail"]) && ( strlen($item["thumbnail"]) > 0 ) ) ? $item["thumbnail"] : '/img/extra/orange-pdf-icon-32.png' )}}"/>
                                                    <br/>
                                                    <a href="{{action("ContentController@show" , $item["content"])}}">
                                                        <i class="fa fa-angle-left"></i>
                                                        {{$item["content"]->name}}
                                                    </a>

                                                </div>
                                            @endforeach
                                        </div>

                                    @endforeach
                                    <style>
                                        .m-grid.m-grid-demo .m-grid-col {
                                            border: none !important;
                                            min-height: 150px !important;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @elseif($content->template->name == "article1")
            <div class="row">
                <div class="col-md-8">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                {{$content->name}}
                            </div>
                        </div>
                        <div class="portlet-body">
                            {!! $content->context !!}
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
                                @if(isset($content->description[0])) {!! $content->description !!} @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
    {{--//v7.2--}}
    <script src="/video-js/video.min.js"></script>
    <script src="/video-js/nuevo/nuevo.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var container = $("#playListScroller"),
                scrollTo = $("#playlistItem_" + "{{$content->id}}");
            container.scrollTop(
                scrollTo.offset().top - container.offset().top + container.scrollTop() - 100
            );
            $("#otherSessions").find(".slimScrollBar").css("top", scrollTo.offset().top + "px");
        });
    </script>
    <script>
        var related_videos = [
                @if(!is_null(min(13,$videosWithSameSet->count())))
                @foreach($videosWithSameSet->random( min(13,$videosWithSameSet->count())) as $item)
                @if($item["content"]->id == $content->id)
                @else
            {
                thumb: '{{(isset($item["thumbnail"]))?$item["thumbnail"]:""}}',
                url: '{{action("ContentController@show" , $item["content"])}}',
                title: ' {{($item["content"]->display_name)}}',
                duration: '20:00'
            },
            @endif
            @endforeach
            @endif        ];
        var player = videojs('video-{{$content->id}}', {nuevo: true}, function () {
            this.nuevoPlugin({
                // plugin options here
                logocontrolbar: '/acm/extra/Alaa-logo.gif',
                logourl: '//sanatisharif.ir',

                videoInfo: true,
                relatedMenu: true,
                zoomMenu: true,
                mirrorButton: true,
                related: related_videos,
                endAction: 'related',

                shareTitle: '{{ $content->displayName }}',
                shareUrl: '{{action("ContentController@show" , $content)}}',
                shareEmbed: '<iframe src="{{action('ContentController@embed' , $content)}}" width="640" height="360" frameborder="0" allowfullscreen></iframe>'
            });
        });
        player.on('resolutionchange', function () {
            var last_resolution = param.label;
            console.log(last_resolution);
        });
    </script>
@endsection
