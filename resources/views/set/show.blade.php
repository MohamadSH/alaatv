@extends('app')

@section('page-css')
    <link href="{{ mix("/css/set-show.css") }}" rel="stylesheet">
    <style>
        .contentsetListHead {
            height: auto !important;
        }
        .contentsetListHead .m-portlet__head-tools {
            display: flex;
            flex-flow: column;
            padding: 5px 0;
        }
        .FavoriteAndOrder {
            display: flex;
            flex-flow: row;
            align-items: center;
            justify-content: center;
        }
        .FavoriteAndOrder .btnFavorite {

        }
        .FavoriteAndOrder .Order {
            margin-left: 10px;
        }
        .FavoriteAndOrder .Order a i {
            font-size: 25px;
        }
        .countOfItems {
            display: flex;
            flex-flow: row;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('page-head')
    @if(isset($jsonLdArray))
        <!-- JSON-LD markup generated by Google Structured Data Markup Helper. -->
        <script type="application/ld+json">
            {!! json_encode($jsonLdArray , JSON_UNESCAPED_SLASHES) !!}
        </script>
    @endif
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="fa fa-video-camera m--padding-right-5"></i>
                <a class="m-link"
                   href="{{ action("Web\ContentController@index") }}">@lang('content.Educational Content Of Alaa')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="fa fa-video-camera m--padding-right-5"></i>
                <a class="m-link" href="#">{{ $contentSet->name }}</a>
            </li>
        </ol>
    </nav>
    <input id="js-var-setId" class="m--hide" type="hidden" value='{{ $contentSet->id }}'>
    <input id="js-var-setName" class="m--hide" type="hidden" value='{{ $contentSet->name }}'>
    <input id="js-var-setUrl" class="m--hide" type="hidden"
           value='{{action("Web\ContentController@show" , $contentSet)}}'>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__head contentsetListHead">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h1 class="m-portlet__head-text">
                                {{ $contentSet->name }}
                            </h1>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <div class="FavoriteAndOrder">
                            <div class="Order">
                                @if($order == 'desc')
                                    <a href="?order=asc" id="sort-ascending">
                                        <i class="fa fa-sort-amount-up"></i>
                                    </a>
                                @else
                                    <a href="?order=desc" id="sort-descending">
                                        <i class="fa fa-sort-amount-down"></i>
                                    </a>
                                @endif
                            </div>

                            <input type="hidden" name="favoriteActionUrl" value="{{ route('web.mark.favorite.set', [ 'set' => $contentSet->id ]) }}">
                            <input type="hidden" name="unFavoriteActionUrl" value="{{ route('web.mark.unfavorite.set', [ 'set' => $contentSet->id ]) }}">

                            <div class="btnFavorite">
                                <img class="btnFavorite-on {{ ($isFavored) ? '' : 'a--d-none' }}" src="https://cdn.alaatv.com/upload/fav-on.svg" width="50">
                                <img class="btnFavorite-off {{ ($isFavored) ? 'a--d-none' : '' }}" src="https://cdn.alaatv.com/upload/fav-off.svg" width="50">
                            </div>
                        </div>
                        <div class="countOfItems">

                            @if($videos->isNotEmpty())
                                فیلم ها : {{$videos->count()}} @if($pamphlets->isNotEmpty())|@endif
                            @endif
                            @if($pamphlets->isNotEmpty())
                                جزوه ها: {{$pamphlets->count()}} @if($articles->isNotEmpty())|@endif
                            @endif
                            @if($articles->isNotEmpty())
                                مقاله ها: {{$articles->count()}}
                            @endif

                        </div>

                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget5">
                        @foreach($videos as $video)
                            <div class="m-widget5__item">
                                <div class="m-widget5__content">
                                    <a href="{{ route('c.show' , ['content'=>$video]) }}" style="display: inherit">
                                        <div class="m-widget5__pic  a--full-width" style="display: contents" >
                                            <img class="img-fluid a--full-width lazy-image" width="453" height="254"  src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{$video->thumbnail}}" alt="{{$video->displayName}}" data-container="body" data-toggle="m-tooltip" data-placement="top" title="دانلود یا تماشا فیلم">
                                        </div>
                                    </a>
                                    <div class="m-widget5__section">
                                        <h2 class="m-widget5__title m--margin-top-10-mobile">
                                            <a href="{{ route('c.show' , ['content'=>$video]) }}">{{$video->displayName}}</a>
                                        </h2>
                                        <div class="m-widget5__info font-weight-bold">
                                            @if($video->isFree)
                                                <span class="m-badge m-badge--accent m-badge--wide">رایگان</span>
                                            @else
                                                <span class="m-badge m-badge--warning m-badge--wide">ویژه شما</span>
                                            @endif
                                            <span>|</span>
                                            <span class="m-widget5__info-date m--font-info">آخرین به روز رسانی: {{$video->UpdatedAt_Jalali()}}</span>
                                            <span>| آلاء</span>
                                        </div>
                                        <span class="m-widget5__desc">
                                                    {!! $video->metaDescription !!}...
                                                </span>
                                        <div class="m--clearfix"></div>
                                    </div>
                                </div>
                                <div class="m-widget5__content">
                                    <div>
                                        <button type="button" class="btn m-btn--pill  btn-primary btn-block"  onclick="window.location = '{{route('c.show' , ['content'=>$video])}}';" data-container="body" data-toggle="m-tooltip" data-placement="top" title="دانلود یا تماشا فیلم">فیلم</button>
                                        @foreach($pamphlets->where('session' , $video->session) as $pamphlet)
                                            <button type="button" class="btn m-btn--pill  btn-focus btn-block" onclick="window.location = '{{route('c.show' , ['content'=>$pamphlet])}}';" data-container="body" data-toggle="m-tooltip" data-placement="top" title="دانلود جزوه">جزوه</button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($articles as $article)
                            <div class="m-widget5__item">
                                <div class="m-widget5__content">
                                    <a href="{{ route('c.show' , ['content'=>$article]) }}" style="display: inherit">
                                        <div class="m-widget5__pic  a--full-width" style="display: contents" >
                                            <img class="img-fluid a--full-width lazy-image" width="453" height="254"  src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{$article->thumbnail}}" alt="{{$article->name}}" data-container="body" data-toggle="m-tooltip" data-placement="top" title="خواندن مقاله">
                                        </div>
                                    </a>
                                    <div class="m-widget5__section">
                                        <h2 class="m-widget5__title m--margin-top-10-mobile">
                                            <a href="{{ route('c.show' , ['content'=>$article]) }}">{{$article->name}}</a>
                                        </h2>
                                        <div class="m-widget5__info font-weight-bold">
                                            @if($article->isFree)
                                                <span class="m-badge m-badge--accent m-badge--wide">رایگان</span>
                                            @else
                                                <span class="m-badge m-badge--warning m-badge--wide">ویژه شما</span>
                                            @endif
                                            <span>|</span>
                                            <span class="m-widget5__info-date m--font-info">آخرین به روز رسانی: {{$article->UpdatedAt_Jalali()}}</span>
                                            <span>| آلاء</span>
                                        </div>
                                        <span class="m-widget5__desc">
                                         {!! $article->metaDescription !!}...
                                </span>
                                        <div class="m--clearfix"></div>
                                    </div>
                                </div>
                                <div class="m-widget5__content">
                                    <div>
                                        <button type="button" class="btn m-btn--pill  btn-primary btn-block"  onclick="window.location = '{{route('c.show' , ['content'=>$article])}}';" data-container="body" data-toggle="m-tooltip" data-placement="top" title="خواندن مقاله">خواندن</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-js')
    <script src="{{ mix('/js/set-show.js') }}" type="text/javascript"></script>
@endsection

