@extends("app" , ["pageName"=>$pageName])


@section("pageBar")

@endsection

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="/assets/extra/slick/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/assets/extra/slick/slick/slick-theme.css">
    <style type="text/css">
        .search-content-3 .tile-container>.tile-thumbnail{
            height: 100px !important;
        }
        /**
         product slider styles
         */

        * {
            box-sizing: border-box;
        }

        .slider {
            width: 70%;
            margin: 100px auto;
        }

        .slick-slide {
            /*margin: 0px 20px;*/
        }

        .slick-slide img {
            width: 100%;
        }

        .slick-prev:before,
        .slick-next:before {
            color: black;
        }


        .slick-slide {
            transition: all ease-in-out .3s;
            opacity: .2;
        }

        .slick-active {
            opacity: 1;
        }

        .slick-current {
            opacity: 1;
        }

    </style>
@endsection

@section("content")
    <h1 class="hidden">همایش اردو فیلم جزوه آلاء سؤال مشاوره ریاضی فیزیک دیفرانسیل شیمی</h1>
    <h2 class="hidden">همایش اردو فیلم جزوه آلاء سؤال مشاوره ریاضی فیزیک دیفرانسیل شیمی</h2>
    @include("partials.slideShow1" ,["marginBottom"=>"25"])
    <div class="clearfix"></div>
    {{--<div class="row">--}}
    {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
    {{--<a class="dashboard-stat dashboard-stat-v2 blue" >--}}
    {{--<div class="visual">--}}
    {{--<i class="fa fa-user"></i>--}}
    {{--</div>--}}
    {{--<div class="details">--}}
    {{--<div class="number">--}}
    {{--<span data-counter="counterup" data-value="@if(isset($userCount)){{$userCount}} @else 0 @endif">0</span>--}}
    {{--</div>--}}
    {{--<div class="desc"> تعداد کل کاربران </div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
    {{--<a class="dashboard-stat dashboard-stat-v2 red">--}}
    {{--<div class="visual">--}}
    {{--<i class="fa fa-question"></i>--}}
    {{--</div>--}}
    {{--<div class="details">--}}
    {{--<div class="number">--}}
    {{--<span data-counter="counterup" data-value="@if(isset($consultingQuestionCount)){{$consultingQuestionCount}}@else 0 @endif">0</span> </div>--}}
    {{--<div class="desc"> تعداد کل سؤالات مشاوره ای </div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
    {{--<a class="dashboard-stat dashboard-stat-v2 green">--}}
    {{--<div class="visual">--}}
    {{--<i class="fa fa-play"></i>--}}
    {{--</div>--}}
    {{--<div class="details">--}}
    {{--<div class="number">--}}
    {{--<span data-counter="counterup" data-value="@if(isset($consultationCount)){{$consultationCount}} @else 0 @endif">0</span>--}}
    {{--</div>--}}
    {{--<div class="desc"> تعداد کل مشاوره ها </div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
    {{--<a class="dashboard-stat dashboard-stat-v2 green">--}}
    {{--<div class="visual">--}}
    {{--<i class="attachPermissions" aria-hidden="true"></i>--}}
    {{--</div>--}}
    {{--<div class="details">--}}
    {{--<div class="number">--}}
    {{--<span data-counter="counterup" data-value="@if(isset($ordooRegisteredCount)){{$ordooRegisteredCount}} @else 0 @endif">0</span>--}}
    {{--</div>--}}
    {{--<div class="desc"> ثبت نام اردو تا الان </div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
    {{--<a class="dashboard-stat dashboard-stat-v2 purple">--}}
    {{--<div class="visual">--}}
    {{--<i class="fa fa-calendar"></i>--}}
    {{--</div>--}}
    {{--<div class="details">--}}
    {{--<div class="number" dir="ltr" >--}}
    {{--<span data-counter="counterup" data-value="@if(isset($currentYear)) {{$currentYear}} @else 0 @endif">0</span>/<span data-counter="counterup" data-value="@if(isset($currentMonth)) {{$currentMonth}} @else 0 @endif">0</span>/<span data-counter="counterup" data-value="@if(isset($currentDay)) {{$currentDay}} @else 0 @endif">0</span> </div>--}}
    {{--<div class="desc"> امروز </div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    <!-- END DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-md-12">
            <div class="portfolio-content portfolio-1" >
                @if($products->isEmpty())
                    <div class="note " style="background-color: #00d4db;">
                        <h4 class="block bold" style="text-align: center">کاربر گرامی در حال حاضر موردی برای ثبت نام وجود ندارد. همایشها و اردوهای بعدی به زودی اعلام خواهند شد.</h4>
                    </div>
                @else
                    @include("partials.portfolioGrid" , ["withFilterButton" => false , "withAd"=>true])
                @endif
            </div>
        </div>
    </div>
    @foreach($sections as $section)
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">
                    {{$section["displayName"]}}
                    <a href="{{action("HomeController@search" , ["tags" => $section["tags"]])}}" class="btn btn-success">بیشتر</a>
                </h3>
                <hr style="border-color: #0c203a">
                <div class="search-page search-content-3">
                    <section class="lessonSlider1 slider" style="width: 95%;margin-top: 0px ; margin-bottom: 15px;">
                        @foreach($section["lessons"] as $lesson)
                            <div class="col-md-4">
                                <div class="tile-container">
                                    <div class="tile-thumbnail">
                                        <a href="{{(isset($lesson["content_id"]) && $lesson["content_id"]>0)?action("EducationalContentController@show", $lesson["content_id"]):""}}">
                                            <img src="
                                            @if(isset($lesson["pic"]) && strlen($lesson["pic"])>0)
                                                    {{$lesson["pic"]}}
                                            @else
                                                    http://via.placeholder.com/195x195
                                            @endif " />
                                        </a>
                                    </div>
                                    <div class="tile-title" style="height: 145px;">
                                        <h5 class="bold">
                                            <a href="{{(isset($lesson["content_id"]) && $lesson["content_id"]>0)?action("EducationalContentController@show", $lesson["content_id"]):""}}">{{$lesson["displayName"]}}</a>
                                        </h5>
                                        {{--<a href="javascript:;">--}}
                                            {{--<i class="icon-question font-blue"></i>--}}
                                        {{--</a>--}}
                                        {{--<a href="javascript:;">--}}
                                            {{--<i class="icon-plus font-green-meadow"></i>--}}
                                        {{--</a>--}}
                                        <div class="tile-desc">
                                            <p>مدرس:
                                                <span class="font-blue">{{$lesson["author"]}}</span>
                                                {{--<span class="font-grey-salt">25 mins ago</span>--}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </section>
                </div>
            </div>
        </div>
        @foreach($section["ads"] as $image => $link)
            @include("partials.bannerAds" ,["marginBottom"=>"15" , "img" => $image , "link" => $link])
        @endforeach
    @endforeach
    {{--<div class="row">--}}
    {{--<div class="col-md-6" id="consultationColumn" >--}}
    {{--<div class="portlet light portlet-fit">--}}
    {{--<div class="portlet-title">--}}
    {{--<div class="caption">--}}
    {{--<i class="fa fa-video-camera font-red"></i>--}}
    {{--<span class="caption-subject bold font-red uppercase"> تایملاین مشاوره</span>--}}
    {{--<span class="caption-helper">فیلمهای مشاوره</span>--}}
    {{--</div>--}}
    {{--<div class="actions">--}}
    {{--<a href="{{action("UserController@uploadConsultingQuestion")}}" class="btn btn-transparent dark btn-outline btn-circle btn-sm active">--}}
    {{--برای پرسیدن سؤال مشاوره ای کلیک کنید</a>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="portlet-body">--}}
    {{--<div class="scroller timeline  white-bg white-bg @if($consultations->count() <= 1) dashboard-consultation-scroll-empty @else dashboard-consultation-scroll-notEmpty @endif">--}}
    {{--@include("consultation.index" , ["pageName"=>$pageName])--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-md-6" >--}}
    {{--<div class="portlet light portlet-fit">--}}
    {{--<div class="portlet-title">--}}

    {{--<div class="caption">--}}

    {{--<i class="fa fa-book font-red"></i>--}}
    {{--<a href="{{action("EducationalContentController@search")}}"><span class="caption-subject bold font-red "> آخرین مطالب </span></a>--}}
    {{--<span class="caption-helper">جزوه ، کتاب ، آزمون</span>--}}

    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="portlet-body">--}}
    {{--@if($educationalContents->isEmpty())--}}
    {{--<div class="timeline  white-bg white-bg">--}}
    {{--<h4 class="block bold text-center" >کاربر گرامی در حال حاضر مطلبی برای مشاهده وجود ندارد.</h4>--}}
    {{--</div>--}}
    {{--@else--}}
    {{--<div class="scroller timeline  white-bg white-bg @if($articles->count() <= 1) height-165 @else height-400 @endif">--}}

    {{--</div>--}}
    {{--<div class="scroller" data-always-visible="1" data-rail-visible="0">--}}
    {{--@include("educationalContent.index" , ["pageName"=>"dashboard"])--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12 ">--}}
    {{--<div class="portlet light portlet-fit ">--}}
    {{--<div class="portlet-title">--}}
    {{--<div class="caption">--}}
    {{--<i class="icon-microphone font-dark hide"></i>--}}
    {{--<span class="caption-subject bold font-yellow uppercase"> همایش های نوروز ۹۵ آلاء</span>--}}
    {{--<span class="caption-helper">برای تماشای فیلم ها بر روی دروس کلیک کنید</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="portlet-body">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-4">--}}
    {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/11/19/">--}}
    {{--<div class="mt-widget-2">--}}
    {{--<div class="mt-head" style="background-image: url(/assets/extra/hamayesh-fizik-95.jpg);">--}}
    {{--<div class="mt-head-user">--}}
    {{--<div class="mt-head-user-img">--}}
    {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
    {{--</div>--}}
    {{--<div class="mt-head-user-info">--}}
    {{--<span class="mt-user-name">آقای کازرانیان</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="mt-body">--}}
    {{--<h3 class="mt-body-title"> همایش فیزیک </h3>--}}
    {{--<p class="mt-body-description"> فیلم های همایش فیزیک در اردوی طلایی نوروز ۹۵  </p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/15/19/">--}}
    {{--<div class="mt-widget-2">--}}
    {{--<div class="mt-head" style="background-image: url(/assets/extra/hamayesh-zist-95.jpg);">--}}
    {{--<div class="mt-head-user">--}}
    {{--<div class="mt-head-user-img">--}}
    {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
    {{--</div>--}}
    {{--<div class="mt-head-user-info">--}}
    {{--<span class="mt-user-name">آقای رحیمی</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="mt-body">--}}
    {{--<h3 class="mt-body-title"> همایش زیست </h3>--}}
    {{--<p class="mt-body-description"> فیلم های همایش زیست در اردوی طلایی نوروز </p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</a>--}}

    {{--</div>--}}
    {{--<div class="col-md-4">--}}
    {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/10/19/">--}}
    {{--<div class="mt-widget-2">--}}
    {{--<div class="mt-head" style="background-image: url(/assets/extra/hamayesh-shimi-95.jpg);">--}}
    {{--<div class="mt-head-user">--}}
    {{--<div class="mt-head-user-img">--}}
    {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
    {{--</div>--}}
    {{--<div class="mt-head-user-info">--}}
    {{--<span class="mt-user-name">آقای آقاجانی</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="mt-body">--}}
    {{--<h3 class="mt-body-title"> همایش شیمی </h3>--}}
    {{--<p class="mt-body-description"> فیلم های همایش شیمی در اردوی طلایی نوروز ۹۵ </p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/5/19/">--}}
    {{--<div class="mt-widget-2">--}}
    {{--<div class="mt-head" style="background-image: url(http://sanatisharif.ir/departmentlesson/arabi-124.jpg);">--}}
    {{--<div class="mt-head-user">--}}
    {{--<div class="mt-head-user-img">--}}
    {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
    {{--</div>--}}
    {{--<div class="mt-head-user-info">--}}
    {{--<span class="mt-user-name">آقای ناصح زاده</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="mt-body">--}}
    {{--<h3 class="mt-body-title"> همایش عربی </h3>--}}
    {{--<p class="mt-body-description"> فیلم های همایش عربی در اردوی طلایی نوروز ۹۵ </p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</a>--}}

    {{--</div>--}}
    {{--<div class="col-md-4">--}}
    {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/45/19/">--}}
    {{--<div class="mt-widget-2">--}}
    {{--<div class="mt-head" style="background-image: url(assets/extra/hamayesh-adabiyat-95.jpg);">--}}
    {{--<div class="mt-head-user">--}}
    {{--<div class="mt-head-user-img">--}}
    {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
    {{--</div>--}}
    {{--<div class="mt-head-user-info">--}}
    {{--<span class="mt-user-name" style="background: rgba(0, 0, 0, 0.6);">آقای حسین خانی</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="mt-body">--}}
    {{--<h3 class="mt-body-title"> جمع بندی آرایه های ادبی </h3>--}}
    {{--<p class="mt-body-description"> فیلم های جمع بندی آرایه های ادبی اردوی طلایی نوروز ۹۵ </p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--<a target="_blank" href="http://sanatisharif.ir/Sanati-Sharif-Lesson/19/19/">--}}
    {{--<div class="mt-widget-2">--}}
    {{--<div class="mt-head" style="background-image: url(http://sanatisharif.ir/departmentlesson/jabr.jpg);">--}}
    {{--<div class="mt-head-user">--}}
    {{--<div class="mt-head-user-img">--}}
    {{--<img src="http://sanatisharif.ir/images/alaa-index.gif" alt="آلاء">--}}
    {{--</div>--}}
    {{--<div class="mt-head-user-info">--}}
    {{--<span class="mt-user-name" style="background: rgba(0, 0, 0, 0.6);">آقای حسین کرد</span>--}}


    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="mt-body">--}}
    {{--<h3 class="mt-body-title"> همایش جبر و احتمال </h3>--}}
    {{--<p class="mt-body-description"> فیلم های همایش جبر رو احتمال در اردوی طلایی نوروز ۹۵ </p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div></div>--}}
    {{--</div>--}}

@endsection
@section("footerPageLevelPlugin")
    <script src="{{ mix('/js/footer_Page_Level_Plugin.js') }}" type="text/javascript"></script>
@endsection
@section("footerPageLevelScript")
    <script src="{{ mix('/js/Page_Level_Script_all.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
                @if(Config::has("constants.SPECIAL_OFFER_DEADLINE"))
        var ComingSoon = function () {

                return {
                    //main function to initiate the module
                    init: function () {
                        var finish = new Date({{Config::get("constants.SPECIAL_OFFER_DEADLINE")}});
                        $('#defaultCountdown').countdown({until:finish  ,format: 'DHMS',
                            layout:  '<span class="countdown_row countdown_show4" >'+
                            '{d<}'+
                            '<span class="countdown_section bg-green" style="width: 24%"  >'+
                            '<label class="countdown_amount" >{dn}</label>'+
                            '<br>{dl}'+
                            '</span>'+
                            '{d>}'+
                            '{h<}'+
                            '<span class="countdown_section bg-green" style="width: 24%">'+
                            '<label class="countdown_amount">{hn}</label>'+
                            '<br>{hl}'+
                            '</span>'+
                            '{h>}'+
                            '{m<}'+
                            '<span class="countdown_section bg-green" style="width: 24%">'+
                            '<label class="countdown_amount">{mn}</label>'+
                            '<br>{ml}'+
                            '</span>'+
                            '{m>}'+
                            '{s<}'+
                            '<span class="countdown_section bg-green" style="width: 24%">'+
                            '<label class="countdown_amount">{sn}</label>'+
                            '<br>{sl}'+
                            '</span>'+
                            '{s>}'+
                            '</span>',
                            description: 'تا پایان'
                        });
                    }

                };

            }();

        jQuery(document).ready(function() {
            ComingSoon.init();
        });
        @endif
    </script>
@endsection

@section("extraJS")
    <script src="/assets/extra/slick/slick/slick.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            initialSlick($(".lessonSlider1"));
        });

        function initialSlick(element)
        {
            element.slick({
                auto:true,
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            dots: false
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ],
                rtl:true
            });
        }

        (function($, window, document, undefined) {
            'use strict';

            // init cubeportfolio
            $('#js-grid-juicy-projects').cubeportfolio({
                filters: '#js-filters-juicy-projects',
                loadMore: '#js-loadMore-juicy-projects',
                loadMoreAction: 'click',
                layoutMode: 'grid',
                defaultFilter: '*',
                animationType: 'quicksand',
                gapHorizontal: 35,
                gapVertical: 30,
                gridAdjustment: 'responsive',
                mediaQueries: [{
                    width: 1500,
                    cols: 5
                }, {
                    width: 1100,
                    cols: 4
                }, {
                    width: 800,
                    cols: 3
                }, {
                    width: 480,
                    cols: 2
                }, {
                    width: 320,
                    cols: 1
                }],
                caption: 'overlayBottomReveal',
                displayType: 'sequentially',
                displayTypeSpeed: 80,

                // lightbox
                lightboxDelegate: '.cbp-lightbox',
                lightboxGallery: true,
                lightboxTitleSrc: 'data-title',
                lightboxCounter: '<div class="cbp-popup-lightbox-counter" style="direction:ltr">@{{current}} of @{{total}}</div>',

                // singlePage popup
                singlePageDelegate: '.cbp-singlePage',
                singlePageDeeplinking: true,
                singlePageStickyNavigation: true,
                singlePageCounter: '<div class="cbp-popup-singlePage-counter" style="direction:ltr">@{{current}} of @{{total}}</div>',
                singlePageCallback: function(url, element) {
                    // to update singlePage content use the following method: this.updateSinglePage(yourContent)
                    var t = this;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'html',
                        timeout: 10000
                    })
                        .done(function(result) {
                            t.updateSinglePage(result);
                        })
                        .fail(function() {
                            t.updateSinglePage('AJAX Error! Please refresh the page!');
                        });
                },
            });

        })(jQuery, window, document);
    </script>
@endsection
