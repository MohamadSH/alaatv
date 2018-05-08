@extends("app",["pageName"=>"search"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="/assets/extra/slick/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/assets/extra/slick/slick/slick-theme.css">
    <style type="text/css">
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
            margin: 0px 20px;
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

@section("bodyClass")
    class = "page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("pageBar")
    {{--<div class="page-bar">--}}
    {{--<ul class="page-breadcrumb">--}}
    {{--<li>--}}
    {{--<i class="icon-home"></i>--}}
    {{--<a href="{{action("HomeController@index")}}">خانه</a>--}}
    {{--<i class="fa fa-angle-left"></i>--}}
    {{--</li>--}}
    {{--<li>--}}
    {{--<span>جستجو</span>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
@endsection
@section("content")
    <div class="search-page search-content-4">
        <div class="search-bar bordered">
            <div class="row">

                {!! Form::open(['action'=> 'EducationalContentController@index'  ,'role'=>'form' , 'id' => 'itemFilterForm'  ]) !!}
                <div class="form-body">
                    {{--CHECKBOXES FOR BUCKETS--}}
                    {{--<div class="form-group form-md-line-input form-md-floating-label has-info">--}}
                    {{--<div class="col-md-12 itemType hidden">--}}
                    {{--<input type="checkbox" name="itemTypes[]" value="contentset" >دسته محتوا--}}
                    {{--<input type="checkbox" name="itemTypes[]" value="content">محتوا--}}
                    {{--<input type="checkbox" name="itemTypes[]" value="product">محصول--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12">
                            <div class="form-group form-md-line-input form-md-floating-label has-info">
                                {!! Form::select('tags[]',$grades,null,['class' => 'form-control itemFilter' , 'placeholder'=>'همه مقاطع' ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12">
                            <div class="form-group form-md-line-input form-md-floating-label has-info">
                                {!! Form::select('tags[]',$majors,null,['class' => 'form-control itemFilter' , 'id'=>'majorSelect' , 'placeHolder'=>'همه رشته ها' ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12">
                            <div class="form-group form-md-line-input form-md-floating-label has-info">
                                {!! Form::select('tags[]',["همه دروس"],null,['class' => 'form-control itemFilter'  , 'id'=> 'lessonSelect'  ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12">
                            <div class="form-group form-md-line-input form-md-floating-label has-info">
                                {!! Form::select('tags[]',["همه دبیرها"],null,['class' => 'form-control itemFilter' , 'id'=> 'teacherSelect' ]) !!}
                            </div>
                        </div>
                    </div>
                    @if(!empty($extraTagArray))
                        <div class="row">
                            <div class="col-md-12">
                                @include("partials.search.tagLabel" , ["tags"=>$extraTagArray , "withCloseIcon"=>true  , "withInput"=>true])
                            </div>
                        </div>
                    @endif
                </div>
                {!! Form::close() !!}
                <div class="row text-center">
                    <img id="content-search-loading" src="/assets/extra/load2.GIF" alt="loading"  style="display: none ; width: 20px;">
                </div>
            </div>
            {{--TEXT SEARCH--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<div class="input-group " >--}}
                        {{--<input type="text" class="form-control" placeholder="اینجا بنویسید . . . ">--}}
                        {{--<span class="input-group-btn">--}}
                            {{--<button class="btn blue uppercase bold" type="button">بگرد</button>--}}
                        {{--</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
    {{--<div class="search-page search-content-2">--}}
        {{--<div class="search-bar ">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<div class="input-group">--}}
                        {{--<input type="text" class="form-control" placeholder="Search for...">--}}
                        {{--<span class="input-group-btn">--}}
                                            {{--<button class="btn blue uppercase bold" type="button">Search</button>--}}
                                        {{--</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="row" >

        @if($items->where("type" , "product")->first()["totalitems"] > 0)
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <!-- BEGIN PORTLET-->
                <div class="portlet light " id="productPortlet">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-globe font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">محصولات آلاء</span>
                        </div>
                    </div>
                    <div class="portlet-body" id="productDiv">
                        <div class="row">
                            <section class="productSlider slider" style="width: 95%;margin-top: 0px ; margin-bottom: 15px;">
                                {!!  $items->where("type" , "product")->first()["view"]  !!}
                            </section>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        @endif
        @if($items->where("type" , "contentset")->first()["totalitems"] > 0)
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-globe font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase">دوره های آموزشی آلاء</span>
                            </div>
                        </div>
                        <div class="portlet-body " id="tab_contentset" >
                            {!! $items->where("type" , "contentset")->first()["view"]  !!}
                        </div>
                    </div>
                </div>
        @endif
    </div>
        @foreach($ads1 as $image => $link)
            @include('partials.bannerAds', ['img'=>$image , 'link'=>$link])
        @endforeach
            <!-- BEGIN PORTLET-->
    <div class="row" >
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-globe font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">فیلم ها و جزوات آموزشی آلاء</span>
                    </div>
                    <ul class="nav nav-tabs">
                        @if($items->where("type" , "article")->first()["totalitems"] > 0)
                            <li>
                                <a href="#tab_content_article" data-toggle="tab"> Article </a>
                            </li>
                        @endif
                        <li>
                            <a href="#tab_content_pamphlet" data-toggle="tab"> PDF </a>
                        </li>
                        <li class="active">
                            <a href="#tab_content_video"  data-toggle="tab">Video</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body " >
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_content_video">
                            {!!  $items->where("type" , "video")->first()["view"] !!}
                        </div>
                        <div class="tab-pane text-center" id="tab_content_pamphlet">
                            {!! $items->where("type" , "pamphlet")->first()["view"]  !!}
                        </div>
                        <div class="tab-pane text-center" id="tab_content_article">
                            {!! $items->where("type" , "article")->first()["view"]  !!}
                        </div>
                    </div>

                </div>
            </div>
            <!-- END PORTLET-->
            @foreach($ads2 as $image => $link)
                @include('partials.bannerAds', ['img'=>$image , 'link'=>$link])
            @endforeach
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="{{ mix('/js/footer_Page_Level_Plugin.js') }}" type="text/javascript"></script>
    <script src="/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/js/extraJS/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="{{ mix('/js/Page_Level_Script_all.js') }}" type="text/javascript"></script>
    <script src="/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/search.min.js" type="text/javascript"></script>
    <script src="/assets/extra/slick/slick/slick.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        var majorLesson = {!!  json_encode($majorLesson)!!};
        var lessonTeacher = {!!  json_encode($lessonTeacher)!!};
        var defaultLesson = "{!!$defaultLesson!!}";
        var defaultTeacher = "{!!$defaultTeacher!!}";
        $(document).ready(function()
        {
            initialSlick($(".productSlider"));
            initialVideoPortfolio();
            makeLessonSelect( $("#majorSelect").val());
            makeTeacherSelect($("#lessonSelect").val());
        });

        function makeLessonSelect() {
            var major = $("#majorSelect").val() ;
            var lessons = majorLesson[major];
            // console.log(lessons);
            $("#lessonSelect").empty();
            $.each(lessons , function (index , value)
            {
                $("#lessonSelect").append($("<option></option>")
                    .attr("value", value.value).text(value.index));
            });
            if(defaultLesson.length > 0)
                $("#lessonSelect").val(defaultLesson);
        }

        function makeTeacherSelect() {
            var lesson = $("#lessonSelect").val() ;
            var teachers = lessonTeacher[lesson];
            $("#teacherSelect").empty();
            $.each(teachers , function (index , value)
            {
                $("#teacherSelect").append($("<option></option>")
                    .attr("value", value.value).text(value.index));
            });
            if(defaultTeacher.length > 0)
                $("#teacherSelect").val(defaultTeacher);
        }

        function destroySlick(element) {
            element.slick('unslick');
        }

        function initialSlick(element) {
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

        function initialVideoPortfolio() {
            (function($, window, document, undefined) {
                'use strict';

                // init cubeportfolio
                $('#js-grid-juicy-projects').cubeportfolio({
                    // filters: '#js-filters-juicy-projects',
                    // loadMore: '#js-loadMore-juicy-projects',
                    // loadMoreAction: 'click',
                    layoutMode: 'grid',
                    defaultFilter: '*',
                    animationType: 'quicksand',
                    gapHorizontal: 35,
                    gapVertical: 30,
                    gridAdjustment: 'responsive',
                    mediaQueries: [{
                        width: 1500,
                        cols: 4
                    }, {
                        width: 1100,
                        cols: 4
                    }, {
                        width: 800,
                        cols: 3
                    }, {
                        width: 480,
                        cols: 3
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
                    lightboxCounter: '<div class="cbp-popup-lightbox-counter"> of </div>',

                    // singlePage popup
                    singlePageDelegate: '.cbp-singlePage',
                    singlePageDeeplinking: true,
                    singlePageStickyNavigation: true,
                    singlePageCounter: '<div class="cbp-popup-singlePage-counter"> of </div>',
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
        }

        function contentLoadAjaxRequest(url , formData) {
            $.ajax({
                type: "GET",
                cache: false,
                url: url ,
                data:formData,
                statusCode:
                    {
                        200:function (response) {
                            var items = response.items;
                            // var itemTypes = response.itemTypes;
                            // location.hash = page;
                            $.each(items , function (key , item) {
                                var totalItems = item.totalitems;
                                switch(item.type) {
                                    case "contentset":
                                        $("#tab_contentset").html(item.view);
                                        break;
                                    case "video":
                                        $("#js-grid-juicy-projects").cubeportfolio('destroy');
                                        $("#tab_content_video").html(item.view);
                                        initialVideoPortfolio();
                                        break;
                                    case "pamphlet":
                                        $("#tab_content_pamphlet").html(item.view);
                                        break;
                                    case "product":
                                        if(totalItems > 0)
                                        {
                                            $("#productPortlet").show();
                                            var element = $(".productSlider");
                                            destroySlick(element) ;
                                            $("#productDiv .row .productSlider").html(item.view);
                                            initialSlick(element);
                                        }
                                        else
                                        {
                                            $("#productPortlet").hide();
                                        }

                                        break;
                                    case "article":
                                        if(totalItems > 0)
                                        {
                                            $("#tab_content_article").html(item.view);
                                            $("#tab_content_article").show();
                                            $('a[href^="#tab_content_article]').show();
                                        }
                                        else
                                        {
                                            $("#tab_content_article").hide();
                                            $('a[href^="#tab_content_article]').hide();
                                        }
                                        break;
                                    default:
                                        break;
                                }
                            });
                            $("#content-search-loading").hide();

                        },
                        422:function (response) {
                            console.log(response);
                        },
                        503:function (response) {
                            console.log(response);
                        }
                    }
            });
        }

        function contentLoad(pageName , pageNumber, itemType) {
            // initiated from url
            var formData = $("#itemFilterForm").find(':not(input[name=_token])').filter(function(index, element) {
                return $(element).val() != '';
            }).serialize();
            formData =  decodeURIComponent(formData);
            if( pageNumber != undefined && pageNumber > 0 )
            {
                var numberQuery  ;
                if (pageName.length > 0)
                {
                    numberQuery = [ pageName+"="+pageNumber ] ;
                }
                else
                {
                    numberQuery = [ "page="+pageNumber ] ;
                }
                formData = formData + "&" + numberQuery.join('&') ;
            }else
            {
                $("#content-search-loading").show();
            }

            changeUrl(formData);
            if( itemType != undefined &&  itemType.length > 0 )
            {
                var typesQuery = [ "itemTypes[]="+itemType ] ;
                formData = formData + "&" + typesQuery.join('&') ;
            }

            // console.log(formData);
            contentLoadAjaxRequest('{{action("HomeController@search")}}',formData);
            return false;
        }

        function changeUrl(appendUrl)
        {
            var newUrl = "{{action("HomeController@search")}}"+"?"+appendUrl;
            window.history.pushState({formData: appendUrl},"Title",newUrl);
            document.title=newUrl;
        }
        $(window).on("popstate", function(e) {
            window.location.reload();
        });
        $(document).on('click', '.pagination a', function (e) {
            var query = $(this).attr('href').split('?')[1];
            var parameters = query.split('=');
            var pageName = parameters[0];
            var itemType = pageName.split('page');
            contentLoad(parameters[0] , parameters[1] , itemType[0]);
            e.preventDefault();
        });

        $(document).on("change", ".itemFilter", function (){
            contentLoad();
        });

        $(document).on("click", ".itemType", function (){
            contentLoad();
        });

        $(document).on("click", ".removeTagLabel", function (){
            var id = $(this).data("role");
            $("#tag_"+id).remove();
            contentLoad();
        });

        $(document).on("change", "#majorSelect", function (){
            makeLessonSelect();
        });

        $(document).on("change", "#lessonSelect", function (){
            makeTeacherSelect();
        });

    </script>
@endsection