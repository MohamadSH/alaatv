<!DOCTYPE html>
<!--[if IE 8]> <html lang="fa-IR" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="fa-IR" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fa-IR" dir="rtl">
    <head>
        <script src="{{ mix('/js/core_all.js') }}" type="text/javascript"></script>
        <link href="/video-js/video-js.min.css" rel="stylesheet">
        <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
        <script src="/video-js/videojs-ie8.min.js"></script>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        {!! SEO::generate(true) !!}
    </head>
    <body>
        <div data-vjs-player>
            <video
                    id="video-{{$video->id}}"
                    poster="@if($video->thumbnails->isNotEmpty()){{$video->thumbnails->first()->name}}@endif"
                    width='100%'
                    height='450px'
                    style="width: 100%"
                    class="video-js vjs-default-skin" controls>

                @foreach($files as $source)
                    <source label="{{ $source->label }}" src="{{ $source->name }}" type='video/mp4'>
                @endforeach
                <p class="vjs-no-js">جهت پخش آنلاین فیلم، ابتدا مطمئن شوید که جاوا اسکریپت در مرور
                    گر شما فعال است و از آخرین نسخه ی مرورگر استفاده می کنید.</p>
            </video>
        </div>
        <script src="/video-js/video.min.js"></script>
        <script src="/video-js/nuevo/nuevo.min.js"></script>
        <script>
            var related_videos = [
                    @foreach($contentsWithSameSet->whereIn("type" , "video" )->random( min(13,$contentsWithSameSet->whereIn("type" , "video" )->count())) as $item)
                    @if($item["content"]->id == $video->id)
                    @else
                {
                    thumb: '{{(isset($item["thumbnail"]))?$item["thumbnail"]:""}}',
                    url: '{{action("EducationalContentController@show" , $item["content"])}}',
                    title: ' {{($item["content"]->display_name)}}',
                    duration: '20:00'
                },
                @endif
                @endforeach
            ];
            var player = videojs('video-{{$video->id}}',{nuevo : true} ,function(){
                this.nuevoPlugin({
                    // plugin options here
                    logocontrolbar: '/assets/extra/Alaa-logo.gif',
                    logourl: '//sanatisharif.ir',

                    videoInfo: true,
                    relatedMenu: true,
                    zoomMenu: true,
                    mirrorButton: true,
                    related: related_videos,
                    endAction: 'related',

                    shareTitle: '{{ $video->display_name }}',
                    shareUrl: '{{action("EducationalContentController@show" , $video)}}',
                    shareEmbed: '<iframe src="{{action('EducationalContentController@embed' , $video)}}" width="640" height="360" frameborder="0" allowfullscreen></iframe>'
                });
            });
            player.on('resolutionchange', function(){
                var last_resolution = param.label;
                console.log(last_resolution);
            });
        </script>
    </body>
</html>