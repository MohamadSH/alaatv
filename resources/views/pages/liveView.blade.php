@extends('app')

@section('page-css')
{{--    <link href="{{ mix('/css/page-error.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('/acm/videojs/skins/alaa-theme/videojs.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/videojs/skins/nuevo/videojs.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/videojs/plugins/pip/videojs.pip.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/videojs/plugins/pip/videojs.pip.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/videojs/plugins/seek-to-point.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .m-portlet .m-portlet__body {
            padding: 0;
        }
    </style>
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
    <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="m-portlet m-portlet--primary m-portlet--head-solid-bg">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                
                                </span>
                                <h3 class="m-portlet__head-text">
                                    پخش آنلاین هندسه پایه
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
                                       preload="auto" height='360' width="640"'>
                                    <source src="https://alaatv.arvanlive.com/hls/test/test.m3u8" type="application/x-mpegURL" res="720p" label="111">
                                    <source src="https://alaatv.arvanlive.com/dash/test/test.mpd" type="application/dash+xml" res="721p" label="222">
                                    <p class="vjs-no-js">@lang('content.javascript is disables! we need it to play a video')</p>
                                </video>
                            </div>
                        <div class="m--clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('page-js')
    
    @if($live == 'on' || $live == 'finished')
        
        <script src="{{asset('/acm/videojs/video.min.js')}}"  type="text/javascript"></script>
        <script src="{{asset('/acm/videojs/plugins/pip/videojs.pip.min.js')}}"  type="text/javascript"></script>
        <script src="{{asset('/acm/videojs/nuevo.min.js')}}"  type="text/javascript"></script>
        <script src="{{asset('/acm/videojs/plugins/videojs.p2p.min.js')}}"  type="text/javascript"></script>
        <script src="{{asset('/acm/videojs/plugins/videojs.hotkeys.min.js')}}"  type="text/javascript"></script>
        <script src="{{asset('/acm/videojs/plugins/seek-to-point.js')}}"  type="text/javascript"></script>
        <script src="{{asset('/acm/videojs/lang/fa.js')}}"  type="text/javascript"></script>
        <script type="text/javascript">


            var contentDisplayName = 'پخش آنالین آقای شامی زاده';
            var contentUrl = '{{ asset('/live') }}';
            player = videojs('video-0', {
                language: 'fa'
                @if($live == 'on')
                ,
                liveui: true,
                autoplay: true
                @endif
            });

            @if($live == 'on')
                var lastDuration = Infinity;
                player.on('timeupdate', function() {
                    var duration = player.duration();
                    if(!isFinite(duration)) {
                        var start = player.seekable().start(0);
                        var end = player.seekable().end(0);
                        if(start !== end) {
                            // 1 seconds offset to prevent freeze when seeking all the way to left
                            duration = end - start - 1;
                            if(duration >= 0 && duration !== lastDuration) {
                                player.duration(duration);
                                lastDuration = duration;
                            } else if(isFinite(lastDuration)) {
                                player.duration(lastDuration);
                            }
                        }
                    }
                });
            @endif
            
            player.nuevo({
                // logotitle:"آموزش مجازی آلاء",
                // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
                logocontrolbar: '/acm/extra/Alaa-logo.gif',
                // logoposition:"RT", // logo position (LT - top left, RT - top right)
                logourl:'//sanatisharif.ir',

                shareTitle: contentDisplayName,
                shareUrl: contentUrl,
                // shareEmbed: '<iframe src="' + contentEmbedUrl + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>',



                videoInfo: true,
                // infoSize: 18,
                // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",


                relatedMenu: true,
                zoomMenu: true,
                // related: related_videos,
                // mirrorButton: true,

                closeallow:false,
                mute:true,
                rateMenu:true,
                resume:true, // (false) enable/disable resume option to start video playback from last time position it was left
                // theaterButton: true,
                timetooltip: true,
                mousedisplay: true,
                endAction: 'related', // (undefined) If defined (share/related) either sharing panel or related panel will display when video ends.
                container: "inline",


                // limit: 20,
                // limiturl: "http://localdev.alaatv.com/videojs/examples/basic.html",
                // limitimage : "//cdn.nuevolab.com/media/limit.png", // limitimage or limitmessage
                // limitmessage: "اگه می خوای بقیه اش رو ببینی باید پول بدی :)",


                // overlay: "//domain.com/overlay.html" //(undefined) - overlay URL to display html on each pause event example: https://www.nuevolab.com/videojs/tryit/overlay

            });

            player.hotkeys({
                enableVolumeScroll: false,
                volumeStep: 0.1,
                seekStep: 5
            });

            player.pic2pic();
            
            
        </script>
    @endif
@endsection

