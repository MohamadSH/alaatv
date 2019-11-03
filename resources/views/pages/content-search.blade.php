@extends('app',['pageName'=> $pageName ])

@section('page-css')
    <link href="{{ mix('/css/content-search.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/SearchBoxFilter/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/SearchBoxFilter/searchResult.css') }}" rel="stylesheet">
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/ScrollCarousel/itemStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('/acm/AlaatvCustomFiles/css/page/pages/content-search.css') }}" rel="stylesheet">
    <style>
        .ribbon {
            position: absolute !important;
            right: -5px !important;
            top: -5px !important;
            z-index: 5 !important;
        }
        .ribbon > span {
            position: absolute !important;
        }
        .glow {
            position: absolute !important;
            background: #fff !important;
            z-index: 999 !important;
        }
    </style>
@endsection

@section('content')
    
    <div class="row">
        <div class="col notFoundMessage">
            <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-warning alert-dismissible fade show" role="alert">
                <div class="m-alert__icon">
                    <i class="fa fa-sad-tear"></i>
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
        <div class="col-md-2">
            <div class="SearchBoxFilter">
            
            </div>
        </div>
        <div class="col-md-10">
            <div class="searchResult">
                <div class="carouselType">
                    <div class="ScrollCarousel">
                        
                    </div>
                </div>
                <hr>
                <div class="listType">
{{--                    <div class="item">--}}
{{--                        <div class="pic">--}}
{{--                            <img data-src="https://cdn.alaatv.com/upload/contentset/departmentlesson/tavarogh_zist11_201927071808.jpg" alt="" class="lazy-image" width="453" height="254">--}}
{{--                        </div>--}}
{{--                        <div class="content">--}}
{{--                            <div class="title">--}}
{{--                                <h2>صفر تا صد فیزیک یازدهم (نظام آموزشی جدید) (98-1397) فرشید داداشی</h2>--}}
{{--                            </div>--}}
{{--                            <div class="detailes">--}}
{{--                                <div class="lesson">--}}
{{--                                    فیلم جلسه 2 - فصل اول: الکتریستۀ ساکن (قسمت دوم)، روش باردار کردن اجسام--}}
{{--                                </div>--}}
{{--                                <div class="summary">--}}
{{--                                    تو سری جدیدی که براتون تو آلا تتو بعضی از موارسابی واتر میره.--}}
{{--                                </div>--}}
{{--                                <div class="publishedDate">--}}
{{--                                    آخرین به روز رسانی: 1398/2/12--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="itemHover"></div>--}}
{{--                        <div class="clearfix"></div>--}}
{{--                    </div>--}}
                
                    
                </div>
    
                <div class="row">
                    <div class="col pageTags">
                        @include("partials.search.tagLabel" , ["tags"=>$tags])
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('page-js')
    <script>
        var contentData = {!! json_encode($result) !!};
        var tags = {!! json_encode($tags) !!};
    </script>
    <script src="{{ mix('/js/content-search.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/SearchBoxFilter/script.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/aSticky/aSticky.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/page/pages/content-search.js') }}"></script>
    <script>
        // shave('.carouselType .ScrollCarousel .item', 120, {character: '✁'});
        // shave('.carouselType .ScrollCarousel .item .content .detailes .summary', 120);
    </script>
@endsection