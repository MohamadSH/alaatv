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
    @endif

    <div class="row">
        <div class="col">
            <div id="a--fullcalendar"></div>
        </div>
    </div>
    
@endsection

@section('page-js')
    <script type="text/javascript">
        var contentDisplayName = '{{(isset($title)?$title:'')}}';
        var contentUrl = '{{ asset('/live') }}';
        var liveData = @if(isset($schedule)) {{ $schedule }} @else [] @endif;
        // var liveData = [
        //     {
        //         "id": 4,
        //         "dayofweek_id": 4,
        //         "title": "هندسه پایه آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/hendese_201920071747.jpg",
        //         "start_time": "07:20:00",
        //         "finish_time": "08:40:00",
        //         "first_live": "2019-07-20",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:39:27",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-27",
        //         "day_of_week": {
        //             "id": 4,
        //             "name": "saturday",
        //             "display_name": "شنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 8,
        //         "dayofweek_id": 8,
        //         "title": "گسسته آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/gosaste_201920071747.jpg",
        //         "start_time": "09:45:00",
        //         "finish_time": "10:55:00",
        //         "first_live": "2019-07-21",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:39:27",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-28",
        //         "day_of_week": {
        //             "id": 8,
        //             "name": "sunday",
        //             "display_name": "یکشنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 12,
        //         "dayofweek_id": 8,
        //         "title": "گسسته آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/gosaste_201920071747.jpg",
        //         "start_time": "18:19:00",
        //         "finish_time": "18:20:00",
        //         "first_live": "2019-07-21",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:39:57",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-28",
        //         "day_of_week": {
        //             "id": 8,
        //             "name": "sunday",
        //             "display_name": "یکشنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 40,
        //         "dayofweek_id": 8,
        //         "title": "فوق برنامه ریاضی تجربی آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/riyazi_201920071747.jpg",
        //         "start_time": "12:10:00",
        //         "finish_time": "13:10:00",
        //         "first_live": "2019-07-28",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-28 06:01:02",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-28",
        //         "day_of_week": {
        //             "id": 8,
        //             "name": "sunday",
        //             "display_name": "یکشنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 16,
        //         "dayofweek_id": 12,
        //         "title": "ریاضی آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/riyazi_201920071747.jpg",
        //         "start_time": "07:20:00",
        //         "finish_time": "08:30:00",
        //         "first_live": "2019-07-22",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:41:42",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-29",
        //         "day_of_week": {
        //             "id": 12,
        //             "name": "monday",
        //             "display_name": "دوشنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 20,
        //         "dayofweek_id": 12,
        //         "title": "ریاضی آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/riyazi_201920071747.jpg",
        //         "start_time": "08:35:00",
        //         "finish_time": "09:45:00",
        //         "first_live": "2019-07-22",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:42:10",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-29",
        //         "day_of_week": {
        //             "id": 12,
        //             "name": "monday",
        //             "display_name": "دوشنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 24,
        //         "dayofweek_id": 16,
        //         "title": "هندسه پایه آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/hendese_201920071747.jpg",
        //         "start_time": "09:45:00",
        //         "finish_time": "10:55:00",
        //         "first_live": "2019-07-23",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:43:34",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-30",
        //         "day_of_week": {
        //             "id": 16,
        //             "name": "tuesday",
        //             "display_name": "سه‌شنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 28,
        //         "dayofweek_id": 16,
        //         "title": "هندسه پایه آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/hendese_201920071747.jpg",
        //         "start_time": "10:55:00",
        //         "finish_time": "12:05:00",
        //         "first_live": "2019-07-23",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:43:59",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-30",
        //         "day_of_week": {
        //             "id": 16,
        //             "name": "tuesday",
        //             "display_name": "سه‌شنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 32,
        //         "dayofweek_id": 20,
        //         "title": "ریاضی آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/riyazi_201920071747.jpg",
        //         "start_time": "07:20:00",
        //         "finish_time": "08:30:00",
        //         "first_live": "2019-07-24",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:44:25",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-31",
        //         "day_of_week": {
        //             "id": 20,
        //             "name": "wednesday",
        //             "display_name": "چهارشنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     },
        //     {
        //         "id": 36,
        //         "dayofweek_id": 20,
        //         "title": "ریاضی آقای شامیزاده",
        //         "description": null,
        //         "poster": "https://cdn.alaatv.com/upload/images/live/riyazi_201920071747.jpg",
        //         "start_time": "08:35:00",
        //         "finish_time": "09:45:00",
        //         "first_live": "2019-07-24",
        //         "last_live": "2019-10-31",
        //         "enable": 1,
        //         "created_at": "2019-07-20 12:44:42",
        //         "updated_at": null,
        //         "deleted_at": null,
        //         "date": "2019-07-31",
        //         "day_of_week": {
        //             "id": 20,
        //             "name": "wednesday",
        //             "display_name": "چهارشنبه",
        //             "created_at": "2019-07-20 12:36:33",
        //             "updated_at": "2019-07-20 12:36:33",
        //             "deleted_at": null
        //         }
        //     }
        // ];
    </script>
    <script src="{{mix('/js/page-live.js')}}" type="text/javascript"></script>
@endsection

