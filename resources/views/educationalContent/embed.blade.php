<!DOCTYPE html>
<!--[if IE 8]> <html lang="fa-IR" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="fa-IR" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fa-IR" dir="rtl">
    <head>
        <script src="{{ mix('/js/core_all.js') }}" type="text/javascript"></script>
        <link rel="stylesheet" href="/videojs/video.js/dist/video-js.min.css">
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
    </head>
    <body>
        <div data-vjs-player>
            <video
                    id="video-{{$video->id}}"
                    poster="@if(isset( $video->thumbnails )){{$video->thumbnails->first()->name}}@endif"
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
            <script>
                $(document).ready(function(){
                    console.log( "ready!" );
                    options = {
                        controlBar: {
                            children: [
                                'playToggle',
                                'progressControl',
                                'volumePanel',
                                'fullscreenToggle',
                            ],
                        },
                    };
                    var player = videojs('video-{{$video->id}}',options);
                    player.qualityLevels();
                });
            </script>
        </div>
        <script type="text/javascript" src="/videojs/video.js/dist/video.min.js"></script>
    </body>
</html>