@extends('partials.templatePage')

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/profile-2-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "index.html">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>نمایش سؤالات مشاوره ای دانش آموز</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "profile">
        {{--<ul class="nav nav-tabs">--}}
        {{--<li class="active">--}}
        {{--<a href="#tab_1_1" data-toggle="tab">  </a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="#tab_1_3" data-toggle="tab"> Account </a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="#tab_1_6" data-toggle="tab"> Help </a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        <div class = "row">
            <div class = "col-md-3">

                <ul class = "list-unstyled profile-nav">
                    <li>
                        <img @if(strlen($user->photo)>0) src = "{{ $user->photo}}" @endif class = "img-responsive pic-bordered" alt = "عکس پروفایل"/>
                    </li>
                    <li style = "text-align: center">
                        <a class = "font-green sbold uppercase" href = "javascript:">@if(isset($user->id)) @if(isset($user->firstName) && strlen($user->firstName)>0 || isset($user->lastName) && strlen($user->lastName)>0) @if(isset($user->firstName) && strlen($user->firstName)>0) {{ $user->firstName}} @endif @if(isset($user->lastName) && strlen($user->lastName)>0) {{$user->lastName}} @endif @else
                                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> کاربر ناشناس </span> @endif @endif
                        </a>
                    </li>
                    <li>
                        <a href = "javascript:"> تعداد سؤالات
                            <span> {{$user->useruploads->count()}} </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class = "col-md-9">
                <!--end row-->
                <div class = "tabbable-line tabbable-custom-profile">
                    <ul class = "nav nav-tabs">
                        <li class = "active">
                            <a href = "#tab_1_11" data-toggle = "tab"> لیست سؤالات دانش آموز</a>
                        </li>

                    </ul>
                    <div class = "tab-content">
                        <div class = "tab-pane active" id = "tab_1_11">
                            <div class = "portlet-body">
                                <div class = "table-scrollable table-scrollable-borderless">
                                    <table class = "table table-hover table-light">
                                        <thead>
                                        <tr>
                                            <th style = "text-align: center">#</th>
                                            <th style = "text-align: center">
                                                عنوان
                                            </th>
                                            <th class = "hidden-xs" style = "text-align: center">
                                                <i class = "fa fa-calendar" aria-hidden = "true"></i>
                                                تاریخ
                                            </th>
                                            <th style = "text-align: center">
                                                <i class = "fa fa-play"></i>
                                                پخش سؤال
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody style = "text-align: center">
                                        @foreach($user->useruploads as $consultation)
                                            <tr>
                                                <td>{{++$counter}}</td>
                                                <td>
                                                    @if(isset($consultation->title)) {{$consultation->title}} @else
                                                        <span class = "m-badge m-badge--wide m-badge--danger label-sm"> بدون عنوان </span> @endif
                                                </td>
                                                <td class = "hidden-xs"> {{$consultation->CreatedAt_Jalali()}} </td>
                                                <td style = "direction: ltr; width: 25%;">
                                                    <a class = "hidden" href = "{{action("Web\HomeController@download" , ["content"=>"سؤال مشاوره ای","fileName"=>$consultation->file ])}}" id = "link_{{$counter}}"></a>
                                                    <div id = "jquery_jplayer_{{$counter}}" class = "jp-jplayer"></div>
                                                    <div id = "jp_container_{{$counter}}" class = "jp-audio-stream" role = "application" aria-label = "media player" style = "width: 100%;">
                                                        <div class = "jp-type-single">
                                                            <div class = "jp-gui jp-interface">
                                                                <div class = "jp-controls">
                                                                    <button class = "jp-play" role = "button" tabindex = "0">
                                                                        play
                                                                    </button>
                                                                </div>
                                                                <div class = "jp-volume-controls">
                                                                    <button class = "jp-mute" role = "button" tabindex = "0">
                                                                        mute
                                                                    </button>
                                                                    <button class = "jp-volume-max" role = "button" tabindex = "0">max volume
                                                                    </button>
                                                                    <div class = "jp-volume-bar">
                                                                        <div class = "jp-volume-bar-value"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class = "jp-details">
                                                                <div class = "jp-title" aria-label = "title">&nbsp;</div>
                                                            </div>
                                                            <div class = "jp-no-solution">
                                                                <span>Update Required</span>
                                                                To play the media you will need to either update your browser to a recent version or update your
                                                                <a href = "http://get.adobe.com/flashplayer/" target = "_blank">Flash plugin</a>
                                                                .
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--tab-pane-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
@endsection

@section("extraJS")

    <script src = "/acm/extra/jplayer/dist/jplayer/jquery.jplayer.min.js" type = "text/javascript"></script>
    @while($counter)
        <script type = "text/javascript">
            $(document).ready(function () {
                var stream = {
//                    mp3: "http://listen.radionomy.com/abc-jazz"
                        mp3: $("#link_{{$counter}}").attr("href")
                    },
                    ready = false;

                $("#jquery_jplayer_{{$counter}}").jPlayer({
                    ready: function (event) {
                        ready = true;
                        $(this).jPlayer("setMedia", stream);
                    },
                    pause: function () {
                        $(this).jPlayer("clearMedia");
                    },
                    error: function (event) {
                        if (ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
                            // Setup the media stream again and play it.
                            $(this).jPlayer("setMedia", stream).jPlayer("play");
                        }
                    },
                    swfPath: "/acm/extra/jplayer/dist/jplayer",
                    cssSelectorAncestor: "#jp_container_{{$counter--}}",
                    supplied: "mp3",
                    preload: "none",
                    wmode: "window",
                    useStateClassSkin: true,
                    autoBlur: false,
                    keyEnabled: true
                });

            });
        </script>
    @endwhile
@endsection


