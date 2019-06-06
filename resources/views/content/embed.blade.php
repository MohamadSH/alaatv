<!DOCTYPE html>
<!--[if IE 8]>
<html lang="fa-IR" class="ie8 no-js">
<![endif]-->
<!--[if IE 9]>
<html lang="fa-IR" class="ie9 no-js">
<![endif]-->
<!--[if !IE]>
<!-->
<html lang="fa-IR" dir="rtl">
<head>
    <link href="{{ mix('/css/all.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ mix('/css/product-content-embed.css') }}" rel="stylesheet" type="text/css"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    {!! SEO::generate(true) !!}
</head>
<body>
<div data-vjs-player>
    
    <video
            id="video-{{$video->id}}"
            @if($video->thumbnails->isNotEmpty())
            poster="{{$video->thumbnails->first()->name}}"
            @else
            poster="https://cdn.sanatisharif.ir/media/204/240p/204054ssnv.jpg"
            @endif
            class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered"
            controls
            {{-- preload="auto"--}}
            preload="none">
    
            @foreach($video->files as $source)
                <source label = "{{ $source->label }}" src = "{{ $source->name }}" type = 'video/mp4'>
            @endforeach
            
            <p class="vjs-no-js">جهت پخش آنلاین فیلم، ابتدا مطمئن شوید که جاوا اسکریپت در مرور گر شما فعال است و از آخرین نسخه ی مرورگر استفاده می کنید.</p>
    </video>
</div>
<script src="{{ mix('/js/all.js') }}"></script>
<script src="{{ mix('/js/product-content-embed.js') }}"></script>
<script>
    var related_videos = [
        @foreach($contentsWithSameSet->whereIn("type" , "video" )->random( min(13,$contentsWithSameSet->whereIn("type" , "video" )->count())) as $item)
            @if($item["content"]->id == $video->id)
            @else
                {
                    thumb: '{{(isset($item["thumbnail"]))?$item["thumbnail"]:""}}',
                    url: '{{action("Web\ContentController@show" , $item["content"])}}',
                    title: ' {{($item["content"]->display_name)}}',
                    duration: '20:00'
                },
            @endif
        @endforeach
    ];

    player = videojs('video-{{$video->id}}', {language: 'fa'});
    player.nuevo({
        // logotitle:"آموزش مجازی آلاء",
        // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
        logocontrolbar: '/acm/extra/Alaa-logo.png',
        // logoposition:"RT", // logo position (LT - top left, RT - top right)
        logourl:'//alaatv.com',

        videoInfo: true,
        // infoSize: 18,
        // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",


        videoInfo: true,
        relatedMenu: true,
        zoomMenu: true,
        related: related_videos,
        endAction: 'related',
        
        closeallow:false,
        mute:true,
        rateMenu:true,
        resume:true, // (false) enable/disable resume option to start video playback from last time position it was left
        // theaterButton: true,
        timetooltip: true,
        mousedisplay: false,
        endAction: 'related', // (undefined) If defined (share/related) either sharing panel or related panel will display when video ends.
        container: "inline",


        shareTitle: '{{ $video->display_name }}',
        shareUrl: '{{action("Web\ContentController@show" , $video)}}',
        shareEmbed: '<iframe src="{{action('Web\ContentController@embed' , $video)}}" width="640" height="360" frameborder="0" allowfullscreen></iframe>'
        
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
    player.on('resolutionchange', function () {
        var last_resolution = param.label;
    });
</script>
</body>
</html>