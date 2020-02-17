@extends('partials.templatePage')

@section('page-css')
    <link href="{{ mix('/css/faq.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home"></i>
                <a href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                سوالات متداول
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include('systemMessage.flash')

    <div class="a--list1">
        @foreach($faqs as $key=>$item)

            <div class="a--list1-item">
                <div class="a--list1-thumbnail">

                    <video id="video-{{ $key }}"
                           class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered a--full-width"
                           controls
                           preload="none"
                           height="360"
                           width="640"
                           poster="{{$item->photo}}">
                        <source src="{{$item->video}}" type='video/mp4' res="HQ" default label="متوسط"/>
                        <p class="vjs-no-js">@lang('content.javascript is disables! we need it to play a video')</p>
                    </video>

                </div>
                <div class="a--list1-content">
                    <h2 class="a--list1-title">{{$item->title}}</h2>
                    <div class="a--list1-info"></div>
                    <div class="a--list1-desc">{{$item->body}}</div>
                </div>
                <div class="a--list1-action"></div>
            </div>

        @endforeach
    </div>

@endsection

@section('page-js')
    <script>
        var videosId = [
            @foreach($faqs as $key=>$item)
                'video-{{ $key }}',
            @endforeach
        ];
    </script>
    <script src="{{ mix('/js/faq.js') }}" defer></script>
@endsection

