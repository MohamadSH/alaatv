@extends('app')

@section('page-css')
    <link href = "{{ mix("/css/content-show.css") }}" rel = "stylesheet">
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <i class = "flaticon-photo-camera m--padding-right-5"></i>
                <a class = "m-link" href = "{{ action("Web\ContentController@index") }}">@lang('content.Educational Content Of Alaa')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> {{ $content->displayName }} </a>
            </li>
        </ol>
    </nav>
    <input id = "js-var-contentId" class = "m--hide" type = "hidden" value = '{{ $content->id }}'>
    <input id = "js-var-contentDName" class = "m--hide" type = "hidden" value = '{{ $content->displayName }}'>
    <input id = "js-var-contentUrl" class = "m--hide" type = "hidden" value = '{{action("Web\ContentController@show" , $content)}}'>
    <input id = "js-var-contentEmbedUrl" class = "m--hide" type = "hidden" value = '{{action("Web\ContentController@embed" , $content)}}'>
@endsection


@section('content')
    <div class = "row">
        <div class = "col-xl-8 col-lg-8 col-md-8 col-sm-6">
        @if(isset($content->template))
            @if(optional($content->template)->name == "video1")
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
                                    <nav aria-label = "Page navigation" class = "table-responsive">
                                        <ul class = "pagination justify-content-center">
                                            <li class = "page-item">
                                                <a class = "page-link" href = "{{action("Web\ContentController@show" , $videosWithSameSet->first()["content"])}}" aria-label = "اولین">
                                                    <span aria-hidden = "true">&laquo;</span>
                                                    <span class = "sr-only">اولین</span>
                                                </a>
                                            </li>
                                            @foreach($videosWithSameSetL->take(-5) as $item)

                                                <li class = "page-item @if($item["content"]->id == $content->id) active @endif">
                                                    <a class = "page-link" href = "{{action("Web\ContentController@show" , $item["content"])}}">{{ $item["content"]->order }}</a>
                                                </li>

                                            @endforeach
                                            @foreach($videosWithSameSetR->take(6) as $item)

                                                <li class = "page-item @if($item["content"]->id == $content->id) active @endif">
                                                    <a class = "page-link" href = "{{action("Web\ContentController@show" , $item["content"])}}">{{ $item["content"]->order }}</a>
                                                </li>

                                            @endforeach
                                            <li class = "page-item">
                                                <a class = "page-link" href = "{{action("Web\ContentController@show" , $videosWithSameSet->last()["content"])}}" aria-label = "آخرین">
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
                                                <img class = "m-widget3__img" src = "{{ $content->author->photo }}" alt = "">
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
                                <div class = "m-separator m-separator--space m-separator--dashed"></div>
                            @endif
                            <h3 class = "m--regular-font-size-lg4 m--font-boldest2 m--font-focus">
                                لینک های مستقیم دانلود این فیلم
                            </h3>
                            @if(isset($content->file) and $content->file->isNotEmpty())
                                <div class = "col-xl-4 text-justify">

                                    <p>
                                        با IDM یا ADM و یا wget دانلود کنید.
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
                                                دانلود فایل {{$file->caption}}{{ isset($file->size[0]) ? "(".$file->size. ")":""  }}
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
                            <div class = "m-separator m-separator--space m-separator--dashed"></div>
                            @if(!empty($tags))
                                @include("partials.search.tagLabel" , ["tags"=>$tags])
                            @endif
                        </div>
                    </div>
                    <!--end::Portlet-->

            @elseif(optional($content->template)->name == "pamphlet1" )
                <!--begin::Portlet-->
                    <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class = "m-portlet__body">
                            <div class = "m-portlet__body-progress">Loading</div>
                            <!--begin::m-widget5-->
                            <div class = "m-widget5">
                                <div class = "m-widget5__item">
                                    <div class = "m-widget5__content">
                                        <div class = "m-widget5__pic">
                                            <img class = "m-widget7__img img-fluid" src = "/assets/app/media/img/files/pdf.svg" alt = "pdf">
                                        </div>
                                        <div class = "m-widget5__section">
                                            <h4 class = "m-widget5__title">
                                                {{ $content->displayName  }}
                                            </h4>
                                            <div class = "m-widget5__info">
                                                <div class = "btn-group m-btn-group" role = "group" aria-label = "...">
                                                    @foreach($content->getPamphlets() as $file)
                                                        <a href = "{{ $file->link }}" target = "_blank" title = "دانلود مستقیم">
                                                            <button type = "button" class = "btn btn-primary">دانلود {{ $file->caption }}</button>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "m-widget5__content"></div>
                                </div>
                            </div>
                            <!--end::m-widget5-->
                            <div class = "m-separator m-separator--space m-separator--dashed"></div>
                            @if(!empty($tags))
                                @include("partials.search.tagLabel" , ["tags"=>$tags])
                            @endif
                        </div>
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                    <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class = "m-portlet__head">
                            <div class = "m-portlet__head-caption">
                                <div class = "m-portlet__head-title">
                                    <h3 class = "m-portlet__head-text">
                                        درباره
                                        @if(isset($contentSetName))
                                            <small>
                                                {{ $content->displayName  }}
                                            </small>
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class = "m-portlet__body">
                            <div class = "m-portlet__body-progress">Loading</div>
                            <div>
                                @if(isset($content->description[0]))
                                    {!! $content->description !!}
                                @else
                                    توضیحی برای این فایل ثبت نشده است.
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end::Portlet-->
            @elseif(optional($content->template)->name == "article1")
                <!--begin::Portlet-->
                    <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class = "m-portlet__head">
                            <div class = "m-portlet__head-caption">
                                <div class = "m-portlet__head-title">
                                    <h3 class = "m-portlet__head-text">
                                        {{$content->name}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class = "m-portlet__body">
                            <div class = "m-portlet__body-progress">Loading</div>
                            <div>
                                {!! $content->context !!}
                            </div>
                            <div class = "m-separator m-separator--space m-separator--dashed"></div>
                            @if(!empty($tags))
                                @include("partials.search.tagLabel" , ["tags"=>$tags])
                            @endif
                        </div>

                    </div>
                    <!--end::Portlet-->
                @endif
            @else
                <div class = "alert alert-danger" role = "alert">
                    <strong>خطا!</strong> خطا لطفا لینک این صفحه را برای ما ارسال کنید تا بررسی شود.
                </div>
            @endif
            @if($pamphletsWithSameSet->count() > 0 and $pamphletsWithSameSet->where("content.id" , "<>",$content->id)->isNotEmpty())
            <!--begin::Portlet-->
                <div class = "m-portlet m-portlet--collapsed m-portlet--head-sm" m-portlet = "true" id = "m_portlet_tools_7">
                    <div class = "m-portlet__head">
                        <div class = "m-portlet__head-caption">
                            <div class = "m-portlet__head-title">
                            <span class = "m-portlet__head-icon">
                                <i class = "flaticon-share"></i>
                            </span>
                                <h3 class = "m-portlet__head-text m--icon-font-size-sm3">
                                    جزوات {{ $contentSetName }}
                                </h3>
                            </div>
                        </div>
                        <div class = "m-portlet__head-tools">
                            <ul class = "m-portlet__nav">
                                <li class = "m-portlet__nav-item">
                                    <a href = "#" m-portlet-tool = "toggle" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                        <i class = "la la-angle-down"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class = "m-portlet__body">
                        <div class = "m-scrollable" data-scrollable = "true" data-height = "450" data-scrollbar-shown = "true">
                        @foreach($pamphletsWithSameSet as  $item)
                            <!--begin::m-widget4-->
                                <div class = "m-widget4">
                                    <div class = "m-widget4__item">
                                        <div class = "m-widget4__img m-widget4__img--icon">
                                            <img src = "/assets/app/media/img/files/pdf.svg" alt = "">
                                        </div>
                                        <div class = "m-widget4__info">
                                            <a href = "{{ action("Web\ContentController@show" , $item["content"]) }}" class = "m-link m--font-light">
                                                <span class = "m-widget4__text ">
                                                {{ $item["content"]->name }}
                                                </span>
                                            </a>

                                        </div>
                                        <div class = "m-widget4__ext">
                                            <a href = "{{ $item["content"]->name }}" class = "m-widget4__icon">
                                                <i class = "m--link la 	la-long-arrow-left"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <!--end::Widget 4-->
                                <div class = "m-separator m-separator--space m-separator--dashed"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                    <!--end::Portlet-->
            @endif
        </div>
        <div class = "col-xl-4 col-lg-4 col-md-4 col-sm-6">
        @if(isset($videosWithSameSet) and $videosWithSameSet->count() > 0)
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
                    <div class = "m-portlet__body m--padding-10">
                        <div id = "playListScroller" class = "m-scrollable" data-scrollable = "true" data-height = "{{ min($videosWithSameSet->count(),(optional($content->template)->name == "video1" ?  11 : 4)) * 103 }}" data-scrollbar-shown = "true">
                            <div class = "m-portlet__body-progress">Loading</div>

                            <!--begin::m-widget5-->
                            <div class = "a-widget5">
                                @foreach($videosWithSameSet as $item)
                                    <div class = "a-widget5__item" id = "playlistItem_{{ $item["content"]->id }}">
                                        <div class = "a-widget5__content  {{ $item["content"]->id == $content->id ? 'm--bg-primary' : '' }}">
                                            <div class = "a-widget5__pic">
                                                <a class = "m-link" href = "{{action("Web\ContentController@show" , $item["content"])}}">
                                                    <img class = "m-widget7__img" src = "{{ isset($item["thumbnail"]) ? $item["thumbnail"]."?w=210&h=118":'' }}" alt = "{{ $item["content"]->name }}">
                                                </a>
                                            </div>
                                            <div class = "a-widget5__section">
                                                <h4 class = "a-widget5__title">
                                                    <a class = "m-link" href = "{{action("Web\ContentController@show" , $item["content"])}}">
                                                        {{ $item["content"]->display_name }}
                                                    </a>
                                                </h4>
                                                <div class = "a-widget5__info">
                                                    <div class = "content-description">
                                                        {!! $item["content"]->description !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "clearfix"></div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <!--end::m-widget5-->

                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            @else
                <div class = "alert alert-info" role = "alert">
                    <strong>حیف!</strong> این مجموعه فیلم ندارد.
                </div>
                <p></p>
            @endif
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        var related_videos = [
                @if(!is_null(min(13,$videosWithSameSet->count())))
                @foreach($videosWithSameSet->random( min(13,$videosWithSameSet->count())) as $item)
                @if($item["content"]->id == $content->id)
                @else
            {
                thumb: '{{(isset($item["thumbnail"]))?$item["thumbnail"]:""}}',
                url: '{{action("Web\ContentController@show" , $item["content"])}}',
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

