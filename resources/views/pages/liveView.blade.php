@extends('app')

@section('page-css')
    <link href="{{ mix('/css/page-live.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> پخش زنده</a>
            </li>
        </ol>
    </nav>
@endsection

@section("content")

    @if(isset($live) && $live === true)
        <div class="row">
                <div class="col-12 col-md-8 mx-auto">
                    <div class="m-portlet m-portlet--primary m-portlet--head-solid-bg">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon"></span>
                                    <h3 class="m-portlet__head-text">
                                        پخش زنده  @if(isset($title)) {{$title}} @endif
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            
                            <div class="a--video-wraper">
                                <video id="video-0"
                                       class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered" controls
                                       preload="auto" height='360' width="640" poster='{{ (isset($poster))?$poster:'' }}'>
                                    <source src="{{ (isset($xMpegURL))?$xMpegURL:'' }}" type="application/x-mpegURL" res="x-mpegURL" label="x-mpegURL">
                                    <source src="{{ (isset($dashXml))?$dashXml:'' }}" type="application/dash+xml" res="dash+xml" label="dash+xml">
                                    <p class="vjs-no-js">@lang('content.javascript is disables! we need it to play a video')</p>
                                </video>
                            </div>
                            <div class="m--clearfix"></div>
                            
                        </div>
                    </div>
                </div>
            </div>

        @permission((config('constants.LIVE_STOP_ACCESS')))
        <div class="row">
            <div class="col text-center">
                <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning">
                    <i class="fa fa-stop"></i>
                    توقف
                </button>
            </div>
        </div>
        @endpermission
    
    @else
    
    
        @permission((config('constants.LIVE_PLAY_ACCESS')))
        <div class="row">
            <div class="col text-center">
                <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info mx-auto">
                    <i class="fa fa-play"></i>
                    پخش
                </button>
            </div>
        </div>
        @endpermission
        
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            </button>
            <strong>
                در حال حاضر پخش زنده وجود ندارد
            </strong>
        </div>
    @endif

    <div class="row">
        <div class="col">
            
            <div class="m-divider">
                <span></span>
                <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                    <h5 class="display-5">
                        برنامه پخش زنده
                    </h5>
                </span>
                <span></span>
            </div>
            
            <div id="a--fullcalendar"></div>
        </div>
    </div>
    
@endsection

@section('page-js')
    <script type="text/javascript">
        var contentDisplayName = '{{(isset($title)?$title:'')}}';
        var contentUrl = '{{ asset('/live') }}';
        var playLiveAjaxUrl = '{{ $playLiveAjaxUrl }}';
        var stopLiveAjaxUrl = '{{ $stopLiveAjaxUrl }}';
        var liveData = @if(isset($schedule)) {!! $schedule !!} @else [] @endif;
    </script>
    <script src="{{mix('/js/page-live.js')}}" type="text/javascript"></script>
@endsection

