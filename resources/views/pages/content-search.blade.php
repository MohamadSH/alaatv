@extends('app',['pageName'=> $pageName ])

@section('page-css')
    <link href="{{ mix('/css/content-search.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    
    <div class="row">
        <div class="col a--multi-level-search" id="contentSearchFilter">

            <div class="row">
                <div class="col">
                    <ol class="filterNavigationWarper">

                    </ol>
                </div>
            </div>
    
            <div class="row justify-content-center selectorItem nezamSelector" data-select-order="0" data-select-title="نظام" data-select-display="grid"></div>
            
            <div class="row justify-content-center selectorItem maghtaSelector" data-select-order="1" data-select-title="مقطع" data-select-display="grid"></div>

            <div class="row justify-content-center selectorItem majorSelector" data-select-order="2" data-select-title="رشته" data-select-display="grid"></div>

            <div class="row justify-content-center selectorItem lessonSelector" data-select-order="3" data-select-title="درس" data-select-display="select2"></div>

            <div class="row justify-content-center selectorItem teacherSelector" data-select-order="4" data-select-title="دبیر" data-select-display="select2"></div>

        </div>
    </div>
    
    <div class="row">
        <div class="col notFoundMessage">
            <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-warning alert-dismissible fade show" role="alert">
                <div class="m-alert__icon">
                    <i class="la la-frown-o"></i>
                    <span></span>
                </div>
                <div class="m-alert__text">
                    <strong>متاسفیم!</strong> با توجه به خواسته شما موردی یافت نشد.
                </div>
                <div class="m-alert__close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="ProductAndSetAndVideoWraper
            @if(optional($result->get('pamphlet'))->isNotEmpty() || optional($result->get('article'))->isNotEmpty())
            
            @else
                col
            @endif">

            <div class="row" id="product-carousel-warper">
                @include('partials.search.video',[
                'items' => $result->get('product'),
                'title' => 'محصولات',
                'carouselType' => 'a--owl-carousel-type-1',
                'widgetId'=>'product-carousel',
                'type' => 'product',
                'perPage' => 9,
                'loadChild' => false
                ])
            </div>
            <div class="row" id="set-carousel-warper">
                @include('partials.search.contentset',[
                'items' => $result->get('set'),
                'type' => 'set',
                'loadChild' => false
                ])
            </div>
            <div class="row" id="video-carousel-warper">
                @include('partials.search.video',[
                'items' => $result->get('video'),
                'loadChild' => false
                ])
            </div>

        </div>

        <div class="PamphletAndArticleWraper
            @if(optional($result->get('pamphlet'))->isEmpty() && optional($result->get('article'))->isEmpty())
                d-none
            @endif">
            <div class="row">

                <div class="m-portlet m-portlet--tabs a--full-width">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x" role="tablist">
                                <li class="nav-item m-tabs__item" id="pamphlet-vertical-tab">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#pamphlet-vertical-tabpanel" role="tab">
                                        <i class="la la-file-pdf-o"></i>
                                        جزوات آلاء
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item" id="article-vertical-tab">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#article-vertical-tabpanel" role="tab">
                                        <i class="la la-comment"></i>
                                        مقالات آموزشی
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <input type="hidden" id="vertical-widget--js-var-next-page-pamphlet-url" value="{{ optional($result->get('pamphlet'))->nextPageUrl() }}">
                        <input type="hidden" id="vertical-widget--js-var-next-page-article-url" value="{{ optional($result->get('article'))->nextPageUrl() }}">
                        <div class="tab-content">
                            <div class="m-portlet__body tab-pane m--padding-5 active" role="tabpanel" id="pamphlet-vertical-tabpanel">
                                <div class="m-scrollable" data-scrollable="true" style="max-height: 995px">
                                    <div class="m-widget4" id="pamphlet-vertical-widget"></div>
                                </div>
                            </div>
                            <div class="m-portlet__body tab-pane m--padding-5" role="tabpanel" id="article-vertical-tabpanel">
                                <div class="m-scrollable" data-scrollable="true" style="max-height: 995px">
                                    <div class="m-widget4" id="article-vertical-widget"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col pageTags">
            @include("partials.search.tagLabel" , ["tags"=>$tags])
        </div>
    </div>
    
@endsection

@section('page-js')
    <script>
        var contentData = {!! json_encode($result) !!};
        var tags = {!! json_encode($tags) !!};
    </script>
{{--    <script src="{{ mix('/js/content-search.js') }}"></script>--}}
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/MultiLevelSearch/js.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/page-content-search-filter-data.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/page-content-search.js') }}"></script>
@endsection