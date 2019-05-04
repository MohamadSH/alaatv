@extends("app",["pageName"=> $pageName ])

@section('right-aside')
@endsection


@section('page-css')
    {{--<link href="{{ mix('/css/user-dashboard.css') }}" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/css/owl-carousel.css" rel="stylesheet" type="text/css"/>--}}

    <style>

        .owl-carousel-fileTitle {
            margin: 0 -30px !important;
            padding: 5px 30px;
            background: #000000b3;
        }

        .owl-carousel-fileTitle a {
            color: white;
            transition-property: all;
            transition-duration: 0.3s;
        }

        .owl-carousel-fileTitle a:hover {
            color: #8bccfe;
        }

        .owl-carousel-fileTitle a:hover::after {
            border-bottom: 1px solid #fff;
            opacity: 1;
        }


        .notFoundMessage .m-alert__icon i {
            font-size: 60px;
        }
    </style>
@endsection

@section("pageBar")
@endsection

@section('content')

    <style>
        .a--multi-level-search {
            display: none;
            margin-bottom: 20px;
            padding-top: 5px;
        }

        .a--multi-level-search .selectorItem {
            margin-top: 10px;
        }

        .a--multi-level-search .selectorItem .selectorItemTitle {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            display: none;
        }

        .a--multi-level-search .selectorItem .subItem:hover {
            background-color: #2bbbad;
            box-shadow: 0 5px 15px 15px rgba(0,0,0,.18),0 4px 15px 0 rgba(0,0,0,.15);
            z-index: 2;
        }

        .a--multi-level-search .selectorItem .subItem {
            white-space: nowrap;
            text-align: center;
            margin: 0px;
            padding: 10px 50px;
            background-color: #4285f4;
            cursor: pointer;
            transition-property: all;
            transition-duration: 0.3s;
            color: white;
            box-shadow: 0 5px 11px 0 rgba(0,0,0,.18),0 4px 15px 0 rgba(0,0,0,.15);
        }

        .a--multi-level-search .selectorItem .select2 {
            max-width: 100%;
            min-width: 100%;
        }

        .a--multi-level-search .selectorItem[data-select-display="select2"] .select2-selection {
            border: none;
        }

        .a--multi-level-search .selectorItem .select2warper {
            margin: 10px 0;
            background: white;
            border: solid 1px #dbdbdb;
            border-radius: 50px;
            -webkit-box-shadow: 0px 5px 10px 2px rgba(196, 197, 214, 0.36) !important;
            box-shadow: 0px 5px 10px 2px rgba(196, 197, 214, 0.36) !important;
        }

        .a--multi-level-search .selectorItem .select2warper > div {
            position: relative;
        }

        .a--owl-carousel-type-1 .m-widget19__header {
            margin-right: -15px;
            margin-left: -15px;
        }

        .a--owl-carousel-type-1 .item .m-portlet > .m-portlet__body {
            padding-bottom: 0px;
        }

        .a--owl-carousel-type-1 .item > .m-portlet {
            margin-bottom: 0;
        }

        .a--vw-Loading {
            text-align: center;
            padding: 10px;
        }


    </style>

    <div class = "row">
        <div class = "col a--multi-level-search" id = "contentSearchFilter">
            <style>
                .a--multi-level-search .filterNavigationWarper {
                    /*background: #4c4c4c;*/
                    background: #ffffff;
                    display: table;
                    padding: 5px 20px;
                    border-radius: 1px;
                    margin: auto;
                    -webkit-box-shadow: 0px 5px 10px 2px rgba(196, 197, 214, 0.36) !important;
                    box-shadow: 0px 5px 10px 2px rgba(196, 197, 214, 0.36) !important;
                }

                .a--multi-level-search .filterNavigationWarper,
                .a--multi-level-search .filterNavigationWarper .filterNavigationStep {
                    list-style: none;
                }

                .a--multi-level-search .filterNavigationWarper .filterNavigationStep {
                    margin: 10px 5px;
                    display: table-cell;
                    vertical-align: middle;
                    cursor: pointer;
                }

                .a--multi-level-search .filterNavigationWarper .filterNavigationStep.active {
                    color: #36a3f7 !important;
                }

                .a--multi-level-search .filterNavigationWarper .filterNavigationStep.current {
                    color: #34bfa3 !important;
                }

                .a--multi-level-search .filterNavigationWarper .filterNavigationStep.deactive {
                    color: #ffb822 !important;
                }

                .a--multi-level-search .filterNavigationWarper .filterNavigationStep:after {
                    content: '\f111';
                    font: normal normal normal 16px/1 "LineAwesome";
                    font-size: 20px;
                    vertical-align: middle;
                    cursor: default;
                    margin-left: 15px;
                    margin-right: 5px;
                }

                .a--multi-level-search .filterNavigationWarper .filterNavigationStep:last-child:after {
                    content: '';
                }

                /*.a--multi-level-search .subItem[selected="selected"] {*/
                /*background-color: #fd7e14;*/
                /*}*/
            </style>

            <div class = "row">
                <div class = "col">
                    <ol class = "filterNavigationWarper">

                    </ol>
                </div>
            </div>

            <div class = "row justify-content-center selectorItem maghtaSelector" data-select-order = "0" data-select-title = "مقطع" data-select-display = "grid"></div>

            <div class = "row justify-content-center selectorItem majorSelector" data-select-order = "1" data-select-title = "رشته" data-select-display = "grid"></div>

            <div class = "row justify-content-center selectorItem lessonSelector" data-select-order = "2" data-select-title = "درس" data-select-display = "select2"></div>

            <div class = "row justify-content-center selectorItem teacherSelector" data-select-order = "3" data-select-title = "دبیر" data-select-display = "select2"></div>

        </div>
    </div>

    <div class = "row">
        <div class = "col pageTags">
            @include("partials.search.tagLabel" , ["tags"=>$tags])
        </div>
    </div>


    <div class = "row">
        <div class = "col notFoundMessage">
            <div class = "m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-warning alert-dismissible fade show" role = "alert">
                <div class = "m-alert__icon">
                    <i class = "la la-frown-o"></i>
                    <span></span>
                </div>
                <div class = "m-alert__text">
                    <strong>متاسفیم!</strong> با توجه به خواسته شما موردی یافت نشد.
                </div>
                <div class = "m-alert__close">
                    <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"></button>
                </div>
            </div>
        </div>
    </div>

    <div class = "row">
        <div class = "ProductAndSetAndVideoWraper
            @if(optional($result->get('pamphlet'))->isNotEmpty() || optional($result->get('article'))->isNotEmpty())col-12 col-md-9
            @elsecol
            @endif">

            <div class = "row" id = "product-carousel-warper">
                @include('partials.search.video',[
                'items' => $result->get('product'),
                'title' => 'محصولات',
                'carouselType' => 'a--owl-carousel-type-1',
                'widgetId'=>'product-carousel',
                'type' => 'product',
                'loadChild' => false
                ])
            </div>
            <div class = "row" id = "set-carousel-warper">
                @include('partials.search.contentset',[
                'items' => $result->get('set'),
                'type' => 'set',
                'loadChild' => false
                ])
            </div>
            <div class = "row" id = "video-carousel-warper">
                @include('partials.search.video',[
                'items' => $result->get('video'),
                'loadChild' => false
                ])
            </div>

        </div>

        <div class = "col-12 col-md-3 PamphletAndArticleWraper
            @if(optional($result->get('pamphlet'))->isEmpty() && optional($result->get('article'))->isEmpty())d-none
            @endif">
            <div class = "row">

                <div class = "m-portlet m-portlet--tabs a--full-width">
                    <div class = "m-portlet__head">
                        <div class = "m-portlet__head-tools">
                            <ul class = "nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x" role = "tablist">
                                <li class = "nav-item m-tabs__item" id = "pamphlet-vertical-tab">
                                    <a class = "nav-link m-tabs__link active" data-toggle = "tab" href = "#pamphlet-vertical-tabpanel" role = "tab">
                                        <i class = "la la-file-pdf-o"></i>
                                        جزوات آلاء
                                    </a>
                                </li>
                                <li class = "nav-item m-tabs__item" id = "article-vertical-tab">
                                    <a class = "nav-link m-tabs__link" data-toggle = "tab" href = "#article-vertical-tabpanel" role = "tab">
                                        <i class = "la la-comment"></i>
                                        مقالات آموزشی
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class = "m-portlet__body">
                        <input type = "hidden" id = "vertical-widget--js-var-next-page-pamphlet-url" value = "{{ optional($result->get('pamphlet'))->nextPageUrl() }}">
                        <input type = "hidden" id = "vertical-widget--js-var-next-page-article-url" value = "{{ optional($result->get('article'))->nextPageUrl() }}">
                        <div class = "tab-content">
                            <div class = "m-portlet__body tab-pane m--padding-5 active" role = "tabpanel" id = "pamphlet-vertical-tabpanel">
                                <div class = "m-scrollable" data-scrollable = "true" style = "height: 500px">
                                    <div class = "m-widget4" id = "pamphlet-vertical-widget"></div>
                                </div>
                            </div>
                            <div class = "m-portlet__body tab-pane m--padding-5" role = "tabpanel" id = "article-vertical-tabpanel">
                                <div class = "m-scrollable" data-scrollable = "true" style = "height: 500px">
                                    <div class = "m-widget4" id = "article-vertical-widget"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
@section('page-js')

    <script>
        var contentData = {!! $result !!};
    </script>

    <script src = "{{ asset('/acm/AlaatvCustomFiles/js/page-content-search.js') }}"></script>

    <script>
        jQuery(document).ready(function () {

        });
    </script>
@endsection