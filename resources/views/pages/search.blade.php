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

        .contentset-thumbnail{
            width: 100%;
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

                {!! Form::open(['action'=> 'ContentController@index'  ,'role'=>'form' , 'id' => 'itemFilterForm'  ]) !!}
                <div class="form-body" id="itemFilterFormBody">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12">
                            <div class="form-group form-md-line-input form-md-floating-label has-info">
                                {!! Form::select('tags[]',$majors,$defaultMajor,['class' => 'form-control itemFilter' , 'id'=>'majorSelect' , 'placeholder'=>'همه رشته ها' ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12">
                            <div class="form-group form-md-line-input form-md-floating-label has-info">
                                {!! Form::select('tags[]',$grades,$defaultGrade,['class' => 'form-control itemFilter' , 'id'=>'gradeSelect' , 'placeholder'=>'همه مقطع ها' ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12">
                            <div class="form-group form-md-line-input form-md-floating-label has-info">
                                {!! Form::select('tags[]',$lessons,$defaultLesson,['class' => 'form-control itemFilter'  , 'id'=> 'lessonSelect' , 'placeholder'=>'همه درس ها' ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12">
                            <div class="form-group form-md-line-input form-md-floating-label has-info">
                                {!! Form::select('tags[]',$teachers,$defaultTeacher,['class' => 'form-control itemFilter' , 'id'=> 'teacherSelect'  , 'placeholder'=>'همه دبیرها']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($extraTags))
                    @foreach($extraTags as $key => $extraTag)
                        <span class="tag label label-info tag_{{$key}}" style="display: inline-block; margin: 2px; padding: 10px;">
                            <a class="removeTagLabel" data-role="{{$key}}" style="padding-left: 10px">
                                <i class="fa fa-remove"></i>
                            </a>
                        <span>
                                <a href="{{action("ContentController@index")}}?tags[]={{$extraTag}}"  class="font-white">{{$extraTag}}</a>
                        </span>
                            <input id="tagInput_{{$key}}" class="extraTag" name="tags[]" type="hidden" value="{{$extraTag}}">
                        </span>
                    @endforeach
                @endif
                {!! Form::close() !!}
                <div class="row text-center">
                    <img id="content-search-loading" src="/assets/extra/load2.GIF" alt="loading"  style="display: none ; width: 20px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row" >

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
                            </section>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <div class="portlet light contentPortlet">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-globe font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase">دوره های آموزشی آلاء</span>
                                {{--{!! $tagLabels !!}--}}
                            </div>
                        </div>
                        <div class="portlet-body " id="tab_contentset" >
                        </div>
                    </div>
                </div>
    </div>
        @foreach($ads1 as $image => $link)
            @include('partials.bannerAds', ['img'=>$image , 'link'=>$link])
        @endforeach
            <!-- BEGIN PORTLET-->
    <div class="row" >
            <div class="portlet light contentPortlet">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-globe font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">فیلم ها و جزوات آموزشی آلاء</span>
                        {{--{!! $tagLabels !!}--}}
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
    <script src="/js/extraJS/slugify/text2slug.js" type="text/javascript" charset="utf-8"></script>

    <script type="text/javascript">
        var tags = {!! json_encode($tags,JSON_UNESCAPED_UNICODE ) !!};
        var extraTags = {!! json_encode($extraTags,JSON_UNESCAPED_UNICODE ) !!};
        var actionUrl = [];
        actionUrl["content"] = "{{action('ContentController@index')}}";
        actionUrl["product"] = "{{action('ProductController@index')}}";
        actionUrl["contentset"] = "{{action('ContentsetController@index')}}";

        $(document).ready(function()
        {

            initialSlick($(".productSlider"));
            initialPortfolio("#js-grid-juicy-contentset");
            initialPortfolio("#js-grid-juicy-projects");
            // makeGradeSelect($("#majorSelect").val());
            // makeLessonSelect( $("#gradeSelect").val());
            // makeTeacherSelect();

            contentLoad( "product" , ["product"],null , actionUrl["product"] , false);
            contentLoad("contentset" , ["contentset"] , null , actionUrl["contentset"] , false);
            $(".contentPortlet .portlet-title .caption").append(makeTagLabels(tags));
            // $("#itemFilterFormBody").append(makeTagLabels(extraTags ,true ) );
        });

        function makeGradeSelect(majorId) {

            //ToDo : Ajax to get grades of this major
            // console.log(lessons);

            var grades = [];  // ToDo : comes from ajax
            $("#gradeSelect").empty();
            $.each(grades , function (index , value)
            {
                var caption = "" ;
                if(value != null && value != undefined)
                    caption = value;

                $("#gradeSelect").append($("<option></option>")
                    .attr("value", index).text(caption));
            });
        }

        function makeLessonSelect(gradeId) {

            //ToDo : Ajax to get grades of this major
            // console.log(lessons);

            var lessons = [];  // ToDo : comes from ajax
            $("#lessonSelect").empty();
            $.each(lessons , function (index , value)
            {
                var caption = "" ;
                if(value != null && value != undefined)
                    caption = value;

                $("#lessonSelect").append($("<option></option>")
                    .attr("value", index).text(caption));
            });
        }

        function makeTeacherSelect() {
            //ToDo
        }

        function makeTagLabels(tags , withInput) {
            var labels = "";
            if(withInput == null || withInput == undefined)
                withInput = false;
            $.each(tags , function (key , value)
            {
                var label = '<span class="tag label label-info tag_'+key+'" style="display: inline-block; margin: 2px; padding: 10px;">\n'  ;
                label += '<a class="removeTagLabel" data-role="'+key+'" style="padding-left: 10px"><i class="fa fa-remove"></i></a>\n' ;
                label += '<span >\n' ;
                label += '<a href="{{action("ContentController@index")}}?tags[]='+value+'"  class="font-white">'+value+'</a>\n' ;
                label += '</span>\n' ;
                if(withInput)
                {
                    label += '<input id="tagInput_'+key+'" class="extraTag" name="tags[]" type="hidden" value="'+value+'">\n' ;
                }
                label += '</span>';

                labels += label
            });
            return labels ;
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

        function initialPortfolio(className) {
            (
                function ($, window, document, className , undefined) {
                    'use strict';

                    // init cubeportfolio
                    $(className).cubeportfolio({
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
                        singlePageCallback: function (url, element) {
                            // to update singlePage content use the following method: this.updateSinglePage(yourContent)
                            var t = this;

                            $.ajax({
                                url: url,
                                type: 'GET',
                                dataType: 'html',
                                timeout: 10000
                            })
                                .done(function (result) {
                                    t.updateSinglePage(result);
                                })
                                .fail(function () {
                                    t.updateSinglePage('AJAX Error! Please refresh the page!');
                                });
                        },
                    });

                }
            )(jQuery, window, document,className);
        }

        function contentLoadAjaxRequest(url , formData,type ) {
            $.ajax({
                type: "GET",
                cache: true,
                url: url ,
                data:formData,
                statusCode:
                    {
                        200:function (response) {
                            var items = response.items;
                            // tags = response.tagLabels;

                            // location.hash = page;
                            $.each(items , function (key , item) {
                                var totalItems = item.totalitems;
                                switch(type) {
                                    case "contentset":
                                        // $("#tab_contentset").html(item.view);
                                        $("#js-grid-juicy-contentset").cubeportfolio('destroy');
                                        $("#tab_contentset").html(item.view);
                                        initialPortfolio("#js-grid-juicy-contentset");
                                        break;
                                    case "content":
                                        if(item.type === "video")
                                        {
                                            $("#js-grid-juicy-projects").cubeportfolio('destroy');
                                            $("#tab_content_video").html(item.view);
                                            initialPortfolio("#js-grid-juicy-projects");
                                        }
                                        else if(item.type === "pamphlet")
                                        {
                                            $("#tab_content_pamphlet").html(item.view);
                                        }
                                        else if(item.type === "article")
                                        {
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
                                        }
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

        function contentLoad(itemType ,pageName, pageNumber , url , setTagLabel)
        {
            var formData = "";

            var extraTags = [] ;
            var tags = [];
            $("#itemFilterForm").find(':not(input[name=_token])').filter(':input').each(function ()
            {
                var elementId = $(this).attr("id");
                var element = $("#"+elementId);

                if(element.hasClass("extraTag"))
                {
                    var tagText = element.val();
                    formData += "tags[]="+ tagText;
                    extraTags.push(tagText);
                    tags.push(tagText);
                }
                else if($("#"+elementId+" option:selected").val() != '')
                {
                    var selectedText = $("#"+elementId+" option:selected").text();
                    var extraTagText = string_to_slug(selectedText);
                    formData += "tags[]="+ extraTagText +"&";
                    tags.push(extraTagText);
                }
            });
            if(setTagLabel)
            {
                $(".tag").remove();
                $(".contentPortlet .portlet-title .caption").append(makeTagLabels(tags));
                $("#itemFilterFormBody").append(makeTagLabels(extraTags , true));
            }
            var addressBarAppend = formData;
            $.each( pageName, function( key, value )
            {
                if( pageNumber != undefined && pageNumber > 0 )
                {
                    var numberQuery  ;
                    numberQuery = [ pageName+"Page="+pageNumber ] ;
                    formData = formData + "&" + numberQuery.join('&') ;
                }else
                {
                    $("#content-search-loading").show();
                }

                if( value != undefined &&  value.length > 0 )
                {
                    var typesQuery = [ "contentType[]="+value ] ;
                    formData = formData + "&" + typesQuery.join('&') ;
                }
            });

            formData =  decodeURIComponent(formData);
            changeUrl(addressBarAppend);

            if(itemType === "video" || itemType === "pamphlet" || itemType === "article")
                        itemType = "content";
            console.log(formData);
            contentLoadAjaxRequest(url,formData,itemType,setTagLabel);
            return false;
        }

        function changeUrl(appendUrl)
        {
            var newUrl = "{{action("ContentController@index")}}"+"?"+appendUrl;
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
            var pageNumber = parameters[1];
            parameters= pageName.split('Page');
            var itemType = parameters[0];

            contentLoad(itemType   , [itemType],pageNumber , actionUrl[itemType],false );
            e.preventDefault();
        });

        // $(document).on("change", "#gradeSelect", function (){
        //     tags.push($("#gradeSelect option:selected").val());
        // });
        //
        // $(document).on("change", "#majorSelect", function (){
        //     tags.push($("#majorSelect option:selected").val());
        //     makeLessonSelect();
        // });
        //
        // $(document).on("change", "#lessonSelect", function (){
        //     tags.push($("#lessonSelect option:selected").val());
        //     makeTeacherSelect();
        // });
        //
        // $(document).on("change", "#teacherSelect", function (){
        //     tags.push($("#teacherSelect option:selected").val());
        // });

        $(document).on("change", ".itemFilter", function (){
            contentLoad( "content" , ["video","pamphlet","article"],null  , actionUrl["content"] , true);
            contentLoad( "product" , ["product"],null , actionUrl["product"], true);
            contentLoad("contentset" , ["contentset"] , null , actionUrl["contentset"], true);
        });

        $(document).on("click", ".removeTagLabel", function ()
        {
            var id = $(this).data("role");
            $(".tag_"+id).remove();
            tags.splice(id, 1);
            var elemets = [
                    "gradeSelect" ,
                    "majorSelect" ,
                    "lessonSelect",
                    "teacherSelect"
            ];


            $.each(elemets , function (key , value)
            {
                $("#"+value).each(function ()
                {
                    if ($.inArray($(this).val(), tags) != -1)
                    {
                        $(this).prop('selected', true);
                    }
                    else
                    {
                        $("#"+value).val($("#"+value+" option:first").val());
                    }
                });
            });

            contentLoad( "content" , ["video","pamphlet","article"],null  , actionUrl["content"] , true);
            contentLoad( "product" , ["product"],null , actionUrl["product"], true);
            contentLoad("contentset" , ["contentset"] , null , actionUrl["contentset"], true);
        });

    </script>
@endsection