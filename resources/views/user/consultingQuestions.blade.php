@extends("app" , ["pageName"=>"ConsultingQuestion"])

@section("headPageLevelPlugin")
    <link href = "/acm/extra/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("title")
    <title>آلاء|سؤالات مشاوره ای من</title>
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
                <span>سؤالات مشاوره ای من</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-2"></div>
        <div class = "col-md-8">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class = "portlet light ">
                <div class = "portlet-title">
                    <div class = "caption font-yellow-casablanca">
                        <i class = "fa fa-list-alt font-yellow-casablanca" aria-hidden = "true"></i>
                        <span class = "caption-subject font-yellow-casablanca bold uppercase">لیست سؤالهای مشاوره ای شما</span>
                    </div>

                </div>
                <div class = "portlet-body">
                    <div class = "table-scrollale">
                        <table class = "table table-hover">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> عنوان</th>
                                <th> دانلود</th>
                                <th> پخش</th>
                                <th> وضعیت</th>
                                <th> تاریخ پرسش</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($questions->isEmpty())
                                <tr style = "text-align: center">
                                    <td colspan = "6">
                                        شما تاکنون سؤالی درج نکرده اید
                                    </td>
                                </tr>
                            @else
                                @foreach($questions as $question)
                                    <tr>
                                        <td> {{$counter}} </td>
                                        <td>@if(strlen($question->title) > 0)  {{$question->title}} @else
                                                <span class = "m-badge m-badge--wide label-sm m-badge--danger">بدون عنوان </span> @endif
                                        </td>
                                        <td> @if(strlen($question->file) > 0)
                                                <a target = "_blank" href = "{{action("Web\HomeController@download" , ["content"=>"سؤال مشاوره ای","fileName"=>$question->file ])}}" id = "link_{{$counter}}" class = "btn btn-icon-only blue">
                                                    <i class = "fa fa-download"></i>
                                                </a>@else
                                                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> بدون فایل </span> @endif
                                        </td>
                                        <td style = "direction: ltr">
                                            <div id = "jquery_jplayer_{{$counter}}" class = "jp-jplayer"></div>
                                            <div id = "jp_container_{{$counter++}}" class = "jp-audio-stream" role = "application" aria-label = "media player">
                                                <div class = "jp-type-single">
                                                    <div class = "jp-gui jp-interface">
                                                        <div class = "jp-controls">
                                                            <button class = "jp-play" role = "button" tabindex = "0">play
                                                            </button>
                                                        </div>
                                                        <div class = "jp-volume-controls">
                                                            <button class = "jp-mute" role = "button" tabindex = "0">mute
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
                                        <td>@if(isset($question->useruploadstatus->id)) @if(strcmp($question->useruploadstatus->name , "done")==0)
                                                <span class = "m-badge m-badge--wide label-sm m-badge--success">پاسخ داده شده </span> @elseif(strcmp($question->useruploadstatus->name , "processing")==0)
                                                <span class = "m-badge m-badge--wide label-sm m-badge--warning">در حال بررسی مشاور </span> @elseif(strcmp($question->useruploadstatus->name , "pending")==0)
                                                <span class = "m-badge m-badge--wide label-sm label m-badge--metal">مشاور ندیده</span> @endif
                                            @else
                                                <span class = "m-badge m-badge--wide label-sm m-badge--warning">نامشخص </span> @endif
                                        </td>
                                        <td>
                                            {{$question->CreatedAt_Jalali()}}
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section("extraJS")

    <script src = "/acm/extra/jplayer/dist/jplayer/jquery.jplayer.min.js" type = "text/javascript"></script>
    @while(--$counter)
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
                    cssSelectorAncestor: "#jp_container_{{$counter}}",
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
