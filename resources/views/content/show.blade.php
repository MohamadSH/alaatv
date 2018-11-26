@extends("app")

@section("page-css")
    <link href = "/acm/video-js/video-js.min.css" rel = "stylesheet">
@endsection

@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("HomeController@index")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <i class = "flaticon-photo-camera m--padding-right-5"></i>
                <a class = "m-link" href = "{{ action("ContentController@index") }}">@lang('content.Educational Content Of Alaa')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> {{ $content->displayName }} </a>
            </li>
        </ol>
    </nav>
    <input id = "js-var-contentId" class = "m--hide" type = "hidden" value = '{{ $content->id }}'>
    <input id = "js-var-contentDName" class = "m--hide" type = "hidden" value = '{{ $content->displayName }}'>
    <input id = "js-var-contentUrl" class = "m--hide" type = "hidden" value = '{{action("ContentController@show" , $content)}}'>
    <input id = "js-var-contentEmbedUrl" class = "m--hide" type = "hidden" value = '{{action("ContentController@embed" , $content)}}'>
@endsection


@section("content")
    <div class = "row row-eq-height">
        <div class = "col-xl-8 col-lg-8 col-md-8 col-sm-6">
            <!--begin::Portlet-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__body">
                    <div class = "m-portlet__body-progress">Loading</div>
                    <video id = "video-{{ $content->id }}" class = "video-js vjs-fluid vjs-default-skin vjs-big-play-centered" controls preload = "auto" height = '360' width = "640" poster = '{{ $content->thumbnail }}'>
                        @foreach($content->getVideos() as $source)
                            <source src = "{{ $source->link }}" type = 'video/mp4' res = "{{ $source->res }}" @if(strcmp( $source->res,"240p") == 0) default @endif label = "{{ $source->caption }}"/>
                        @endforeach
                        <p class = "vjs-no-js">@lang('content.javascript is disables! we need it to play a video')</p>
                    </video>
                    <div class = "m--clearfix"></div>
                    <div class = "m--margin-top-10">
                        @if(isset($videosWithSameSet) and $videosWithSameSet->isNotEmpty())
                            <nav aria-label = "Page navigation" class="table-responsive">
                                <ul class = "pagination justify-content-center">
                                    <li class = "page-item">
                                        <a class = "page-link" href = "{{action("ContentController@show" , $videosWithSameSet->first()["content"])}}" aria-label = "اولین">
                                            <span aria-hidden = "true">&laquo;</span>
                                            <span class = "sr-only">اولین</span>
                                        </a>
                                    </li>
                                    @foreach($videosWithSameSetL->take(-5) as $item)

                                        <li class = "page-item @if($item["content"]->id == $content->id) active @endif">
                                            <a class = "page-link" href = "{{action("ContentController@show" , $item["content"])}}">{{ $item["content"]->order }}</a>
                                        </li>

                                    @endforeach
                                    @foreach($videosWithSameSetR->take(6) as $item)

                                        <li class = "page-item @if($item["content"]->id == $content->id) active @endif">
                                            <a class = "page-link" href = "{{action("ContentController@show" , $item["content"])}}">{{ $item["content"]->order }}</a>
                                        </li>

                                    @endforeach
                                    <li class = "page-item">
                                        <a class = "page-link" href = "{{action("ContentController@show" , $videosWithSameSet->last()["content"])}}" aria-label = "آخرین">
                                            <span aria-hidden = "true">&raquo;</span>
                                            <span class = "sr-only">آخرین</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                    <h1 class = "m--regular-font-size-lg3 m--font-bold m--font-focus">{{ $content->displayName }}</h1>
                    @if(isset($content->author_id))
                        <div class = "m-widget3">
                            <div class = "m-widget3__item">
                                <div class = "m-widget3__header">
                                    <div class = "m-widget3__user-img">
                                        <img class = "m-widget3__img" src = "/assets/app/media/img/users/user1.jpg" alt = "">
                                    </div>
                                    <div class = "m-widget3__info">
                                            <span class = "m-widget3__username">
                                            {{ $author }}
                                            </span>
                                        @if(isset($contentSetName))
                                            <br>
                                            <h3 class = "m-widget3__time m--font-info">
                                                {{ $contentSetName }}
                                            </h3>
                                        @endif
                                    </div>
                                    @if($userCanSeeCounter)
                                        <span class = "m-widget3__status m--font-info m--block-inline">
                                                <i class = "fa fa-eye"> {{ $seenCount }}</i>
                                            </span>
                                    @endif
                                </div>
                                <div class = "m-widget3__body">
                                    <div class = "m-widget3__text">
                                        {!! $content->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif
                    @if(!empty($tags))
                        @include("partials.search.tagLabel" , ["tags"=>$tags])
                    @endif
                </div>
            </div>
            <!--end::Portlet-->
        </div>
        <div class = "col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <!--begin::Portlet-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                فیلم ها
                                @if(isset($contentSetName))
                                    <small>
                                        {{ $contentSetName }}
                                    </small>
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    <div id = "playListScroller" class = "m-scrollable" data-scrollable = "true" data-height = "350" data-scrollbar-shown = "true">
                        <div class = "m-portlet__body-progress">Loading</div>
                    @if(isset($videosWithSameSet))
                        <!--begin::m-widget5-->
                            <div class = "m-widget5">
                                @foreach($videosWithSameSet as $item)
                                    <div class = "m-widget5__item" id = "playlistItem_{{ $item["content"]->id }}">
                                        <div class = "m-widget5__content">
                                            <div class = "m-widget5__pic">
                                                <img class = "m-widget7__img" src = "{{ isset($item["thumbnail"]) ? $item["thumbnail"]."?w=210&h=118":'' }}" alt = "{{ $item["content"]->name }}">
                                            </div>
                                            <div class = "m-widget5__section">
                                                <h4 class = "m-widget5__title">
                                                    {{ $item["content"]->display_name }}
                                                </h4>
                                                <div class = "m-widget5__info">
                                                    <a href = "{{action("ContentController@show" , $item["content"])}}"> link</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "m-widget5__content"></div>
                                    </div>
                                @endforeach

                            </div>
                            <!--end::m-widget5-->
                        @else
                            <p>این مجموعه فیلم دیگری فعلا ندارد.</p>
                        @endif
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
            <!--begin:: Widgets/Download Files-->
            <div class = "m-portlet">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                لینک های مستقیم دانلود این فیلم
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    @if(isset($content->file) and $content->file->isNotEmpty())
                        <div class = "text-justify">
                            <p>
                                پیشنهاد می کنیم برای دانلود، از نرم افزار Internet Download Manager در ویندوز و یا ADM در اندروید و یا wget در لینوکس استفاده بفرمایید.
                            </p>
                            <p>
                                جهت دانلود روی یکی از دکمه های زیر کلیک کنید:
                            </p>
                        @foreach($content->file->get('video') as $file)
                            <!--begin::m-widget4-->
                                <div class = "m-widget4">
                                    <div class = "m-widget4__item">
                                        <div class = "m-widget4__img m-widget4__img--icon">
                                            <img src = "/assets/app/media/img/files/mp4.svg" alt = "">
                                        </div>
                                        <div class = "m-widget4__info">
                                            <a href = "{{ $file->link }}?download=1" class = "m-link">
                                            <span class = "m-widget4__text">
                                            فایل {{$file->caption}}{{ isset($file->size[0]) ? "(".$file->size. ")":""  }}
                                            </span>
                                            </a>
                                        </div>
                                        <div class = "m-widget4__ext">
                                            <a href = "{{ $file->link }}?download=1" class = "m-widget4__icon">
                                                <i class = "la la-download"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <!--end::Widget 4-->
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
            <!--end:: Widgets/Download Files-->
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
							<i class="flaticon-statistics"></i>
						</span>
                            <h3 class="m-portlet__head-text">
                                {{ $contentSetName }}
                            </h3>
                            <h2 class="m-portlet__head-label m-portlet__head-label--danger">
                                <span>لیست جزوات</span>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    {{--<div class = "row">
        @if(isset($content->template))
            @if(optional($content->template)->name == "video1")
                <div class = "row">
                    <div class = "col-md-12">
                        <div class = "row">
                            <div class = "col-md-12">
                                <div class = "portlet light ">
                                    <div class = "portlet-title">
                                        <div class = "caption">
                                            <i class = "fa fa-download" aria-hidden = "true"></i>
                                            لینک های دانلود
                                        </div>
                                    </div>

                                    @if(isset($content->file) and $content->file->isNotEmpty())
                                        <div class = "portlet-body text-justify">
                                            <p>
                                                پیشنهاد می کنیم برای دانلود، از نرم افزار Internet Download Manager در ویندوز و یا ADM در اندروید و یا wget در لینوکس استفاده بفرمایید.
                                            </p>
                                            <p>
                                                جهت دانلود روی یکی از دکمه های زیر کلیک کنید:
                                            </p>
                                            <div class = "row">


                                                @foreach($content->file->get('video') as $file)
                                                    <div class = "col-md-4">
                                                        <a href = "{{$file->link}}?download=1" class = "btn red margin-bottom-5" style = "width: 250px;">
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
                @if(isset($pamphletsWithSameSet) && $pamphletsWithSameSet->isNotEmpty())
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "portlet light ">
                                <div class = "portlet-title">
                                    <div class = "caption">
                                        <i class = "fa fa-comment-o" aria-hidden = "true"></i>
                                        جزوات این درس
                                    </div>
                                </div>
                                <div class = "portlet-body text-justify">
                                    <div class = "m-grid m-grid-demo">
                                        @foreach($pamphletsWithSameSet->chunk(5) as $chunk)
                                            <div class = "m-grid-row">
                                                @foreach($chunk as $item)
                                                    <div class = "m-grid-col m-grid-col-middle m-grid-col-center">

                                                        <img width = "80" alt = "{{$item["content"]->name}}" src = "{{( ( isset($item["thumbnail"]) && ( strlen($item["thumbnail"]) > 0 ) ) ? $item["thumbnail"] : '/img/extra/orange-pdf-icon-32.png' )}}"/>
                                                        <br/>
                                                        <a href = "{{action("ContentController@show" , $item["content"])}}">
                                                            <i class = "fa fa-angle-left"></i>
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
                <div class = "row">
                    <div class = "col-md-8">
                        <div class = "portlet light ">
                            <div class = "portlet-title">
                                <div class = "caption">
                                    <i class = "fa fa-file-text-o" aria-hidden = "true"></i>
                                    {{ $content->displayName  }}
                                </div>
                                <div class = "actions">
                                    @if($content->file->count() == 1)

                                        <a target = "_blank" href = "{{ $content->getPamphlets()->first()->link }}" class = "btn btn-circle green btn-outline btn-sm">
                                            <i class = "fa fa-download"></i>
                                            دانلود
                                        </a>
                                    @else
                                        <div class = "btn-group">
                                            <button class = "btn btn-circle green btn-outline btn-sm" data-toggle = "dropdown" aria-expanded = "true">دانلود
                                                <i class = "fa fa-angle-down"></i>
                                            </button>
                                            <ul class = "dropdown-menu">
                                                @foreach($content->getPamphlets() as $file)
                                                    <li>
                                                        <a target = "_blank" href = "{{ $file->link }}">{{ $file->caption }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class = "portlet-body">
                                @if($content->getPamphlets()->first()->ext === 'pdf')
                                    <iframe class = "google-docs" src = 'https://docs.google.com/viewer?url={{$content->getPamphlets()->first()->link}}&embedded=true' width = '100%' height = '760' style = 'border: none;'>

                                    </iframe>
                                @endif
                                <div class = "row">
                                    <div class = "col-md-12">
                                        @if(!empty($tags))
                                            <hr>
                                            @include("partials.search.tagLabel" , ["tags"=>$tags])
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class = "col-md-4">
                        <div class = "portlet light ">
                            <div class = "portlet-title">
                                <div class = "caption">
                                    <i class = "fa fa-comment-o" aria-hidden = "true"></i>
                                    درباره فایل
                                </div>
                            </div>
                            <div class = "portlet-body text-justify">
                                <div class = "scroller" style = "height:200px" data-rail-visible = "1" data-rail-color = "black" data-handle-color = "#a1b2bd">
                                    @if(isset($content->description[0]))
                                        {!! $content->description !!}
                                    @else
                                        به زودی ...
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class = "col-md-4 margin-bottom-15">
                        @if(isset($videosWithSameSet) && $videosWithSameSet->isNotEmpty())
                            <div class = "mt-element-list">
                                <div class = "mt-list-head list-news ext-1 font-white bg-yellow-crusta">
                                    <div class = "list-head-title-container">
                                        <h3 class = "list-title">فیلم های درس</h3>
                                    </div>
                                    <div class = "list-count pull-right bg-yellow-saffron"></div>
                                </div>
                                <div class = "mt-list-container list-news ext-2" id = "otherSessions">
                                    <div id = "playListScroller" class = "scroller" style = "min-height: 50px; max-height:500px" data-always-visible = "1" data-rail-visible = "1" data-rail-color = "red" data-handle-color = "green">
                                        <ul>

                                            @foreach($videosWithSameSet as $item)
                                                <li class = "mt-list-item @if($item["content"]->id == $content->id) bg-grey-mint @endif " id = "playlistItem_{{$item["content"]->id}}">
                                                    <div class = "list-icon-container">
                                                        <a href = "{{action("ContentController@show" , $item["content"])}}">
                                                            <i class = "fa fa-angle-left"></i>
                                                        </a>
                                                    </div>
                                                    <div class = "list-thumb">
                                                        <a href = "{{action("ContentController@show" , $item["content"])}}">
                                                            <img alt = "{{$item["content"]->name}}" src = "{{(isset($item["thumbnail"]))?$item["thumbnail"]:''}}"/>
                                                        </a>
                                                    </div>
                                                    <div class = "list-datetime bold uppercase font-yellow-casablanca"> {{($item["content"]->display_name)}} </div>
                                                    <div class = "list-item-content">
                                                        <h3 class = "uppercase bold">
                                                            <a href = "javascript:">&nbsp;</a>
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
                            <div class = "portlet light margin-top-10">
                                <div class = "portlet-title">
                                    <div class = "caption">
                                        <i class = "fa fa-video-camera" aria-hidden = "true"></i>
                                        نمونه همایش های طلایی 97
                                    </div>
                                </div>

                                <div class = "portlet-body">
                                    @include("content.partials.adSideBar" , ["items" => $adItems])
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if(isset($pamphletsWithSameSet) && $pamphletsWithSameSet->where("content.id" , "<>",$content->id)->isNotEmpty())
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "portlet light ">
                                <div class = "portlet-title">
                                    <div class = "caption">
                                        <i class = "fa fa-comment-o" aria-hidden = "true"></i>
                                        جزوات دیگر
                                    </div>
                                </div>
                                <div class = "portlet-body text-justify">
                                    <div class = "m-grid m-grid-demo">
                                        @foreach($pamphletsWithSameSet->chunk(5) as $chunk)
                                            <div class = "m-grid-row">
                                                @foreach($chunk as $item)
                                                    <div class = "m-grid-col m-grid-col-middle m-grid-col-center">

                                                        <img width = "80" alt = "{{$item["content"]->name}}" src = "{{( ( isset($item["thumbnail"]) && ( strlen($item["thumbnail"]) > 0 ) ) ? $item["thumbnail"] : '/img/extra/orange-pdf-icon-32.png' )}}"/>
                                                        <br/>
                                                        <a href = "{{action("ContentController@show" , $item["content"])}}">
                                                            <i class = "fa fa-angle-left"></i>
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
                <div class = "row">
                    <div class = "col-md-8">
                        <div class = "portlet light ">
                            <div class = "portlet-title">
                                <div class = "caption">
                                    <i class = "fa fa-file-text-o" aria-hidden = "true"></i>
                                    {{$content->name}}
                                </div>
                            </div>
                            <div class = "portlet-body">
                                {!! $content->context !!}
                                <div class = "row">
                                    <div class = "col-md-12">
                                        @if(!empty($tags))
                                            <hr>
                                            @include("partials.search.tagLabel" , ["tags"=>$tags])
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class = "col-md-4">
                        <div class = "portlet light ">
                            <div class = "portlet-title">
                                <div class = "caption">
                                    <i class = "fa fa-comment-o" aria-hidden = "true"></i>
                                    درباره مقاله
                                </div>
                            </div>
                            <div class = "portlet-body text-justify">
                                <div class = "scroller" style = "height:200px" data-rail-visible = "1" data-rail-color = "black" data-handle-color = "#a1b2bd">
                                    @if(isset($content->description[0])) {!! $content->description !!} @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class = "col-md-4"></div>
                </div>
            @endif
        @else
            قالب محتوا تنظیم نشده است
        @endif
    </div>--}}
@endsection

@section("page-js")
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
            @endif
        ];
    </script>
    <script src = "{{ mix("/js/content-show.js") }}" type = "text/javascript"></script>

@endsection

