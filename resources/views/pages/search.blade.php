@extends("app",["pageName"=>"search"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/search-extra-all.css') }}">
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

@section('custom-menu')
    <div class="right_menu">
        <div class="button_search">
            <a class="close_menu hidden-lg hidden-md hidden-sm">
                <i>×</i>
            </a>
            <div class="clearfix"></div>
            <div class="button_top">
                <button class="btn btn_green pull-left">
                    جستجو
                </button>
                <div id="close_filter" class="close_filter pull-right hidden-xs">
                    <i class="fa fa-angle-right right_icon"></i>
                    <i class="fa fa-angle-left left_icon"></i>
                </div>
                <div id="filterClear" class="riset pull-right" title="پاک کردن فرم">
                    <i class="fa fa-eraser"></i>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div id="content-rds" class="content">
            <div class="info">
                <ul class="list_fillters">
                    <li>
                        <h4 class="titel_fillter center mrg_20">
                            نوع محتوا
                        </h4>
                        <div class="Type_content item_th thumbnail">
                            <ul class="books list-inline center item3">
                                <li class="check_item">
                                    فیلم
                                </li>
                                <li class="check_item">
                                    جزوه
                                </li>
                                <li class="check_item">
                                    فلش کارت
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                    <li>
                        <h4 class="titel_fillter center mrg_20">
                            انتخاب نوع سوال
                        </h4>
                        <div class="select mrg_20">
                            <select class="form-control">
                                <option>
                                    نوع سوال
                                </option>
                                <option>
                                    سوال یک
                                </option>
                                <option>
                                    سوال دو
                                </option>
                            </select>
                        </div>
                        <div class="Level_box thumbnail">
                            <div class="right_titel pull-left">
                                همه
                            </div>
                            <div class="left_level pull-left">
                                <ul class="list-inline center">
                                    <li>
                                        <div class="filter--brand search_popup">
                                            <div class="search_checkbox not_fill">
                                                <input name="a" value="1" id="Rules1" type="checkbox">
                                                <label class="ch_label" for="Rules1">
                                                    دشوار
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="filter--brand search_popup">
                                            <div class="search_checkbox not_fill">
                                                <input name="b" value="1" id="Rules2" type="checkbox">
                                                <label class="ch_label" for="Rules2">
                                                    متوسط
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="filter--brand search_popup">
                                            <div class="search_checkbox not_fill">
                                                <input name="c" value="1" id="Rules3" type="checkbox">
                                                <label class="ch_label" for="Rules3">
                                                    آسان
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                    <li>
                        <h4 class="titel_fillter center mrg_20">
                            جستجو بر اساس رشته , پایه و کتاب درسی
                        </h4>
                        <div class="Curriculum">
                            <div class="item_th thumbnail">
                                <ul class="books list-inline item3">
                                    <li class="check_item">
                                        ریاضی فیزیک
                                    </li>
                                    <li class="check_item">
                                        علوم تجربی
                                    </li>
                                    <li class="check_item">
                                        علوم انسانی
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="item_th thumbnail">
                                <ul class="Base_class list-inline item4 center">
                                    <li class="check_item">
                                        اول
                                    </li>
                                    <li class="check_item">
                                        دوم
                                    </li>
                                    <li class="check_item">
                                        سوم
                                    </li>
                                    <li class="check_item">
                                        چهارم
                                    </li>
                                    <li class="check_item w33">
                                        دهم
                                    </li>
                                    <li class="check_item w33">
                                        یازدهم
                                    </li>
                                    <li class="check_item w33">
                                        دوازدهم
                                    </li>
                                </ul>
                                <div class="clearfix"></div>

                            </div>
                            <ul class="Textbook mrg_20 thumbnail item_th">
                                <li>
                                    <button class="accordion not_before titel_button">
                                        مباحث درسی
                                    </button>
                                    <div class="panel panel_list">
                                        <ul class="list">
                                            <li>
                                                <button class="accordion">
                                                            <span>
                                                                متوسطه دو
                                                            </span>
                                                </button>
                                                <div class="panel panel_list">
                                                    <ul class="list">
                                                        <li>
                                                            <button class="accordion">
                                                                        <span>
                                                                            ریاضی فیزیک
                                                                        </span>
                                                            </button>
                                                            <div class="panel panel_list">
                                                                <ul class="list">
                                                                    <li>
                                                                        <button class="accordion">
                                                                                    <span>
                                                                                        دهم
                                                                                    </span>
                                                                        </button>
                                                                        <div class="panel panel_list">
                                                                            <ul class="list">
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <button class="accordion">
                                                                                    <span>
                                                                                        دهم
                                                                                    </span>
                                                                        </button>
                                                                        <div class="panel panel_list">
                                                                            <ul class="list">
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <button class="accordion">
                                                                        <span>
                                                                            ریاضی فیزیک
                                                                        </span>
                                                            </button>
                                                            <div class="panel panel_list">
                                                                <ul class="list">
                                                                    <li>
                                                                        <button class="accordion">
                                                                                    <span>
                                                                                        دهم
                                                                                    </span>
                                                                        </button>
                                                                        <div class="panel panel_list">
                                                                            <ul class="list">
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <button class="accordion">
                                                                                    <span>
                                                                                        دهم
                                                                                    </span>
                                                                        </button>
                                                                        <div class="panel panel_list">
                                                                            <ul class="list">
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <button class="accordion">
                                                                        <span>
                                                                            ریاضی فیزیک
                                                                        </span>
                                                            </button>
                                                            <div class="panel panel_list">
                                                                <ul class="list">
                                                                    <li>
                                                                        <button class="accordion">
                                                                                    <span>
                                                                                        دهم
                                                                                    </span>
                                                                        </button>
                                                                        <div class="panel panel_list">
                                                                            <ul class="list">
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <button class="accordion">
                                                                                    <span>
                                                                                        دهم
                                                                                    </span>
                                                                        </button>
                                                                        <div class="panel panel_list">
                                                                            <ul class="list">
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <button class="accordion">
                                                                        <span>
                                                                            ریاضی فیزیک
                                                                        </span>
                                                            </button>
                                                            <div class="panel panel_list">
                                                                <ul class="list">
                                                                    <li>
                                                                        <button class="accordion">
                                                                                    <span>
                                                                                        دهم
                                                                                    </span>
                                                                        </button>
                                                                        <div class="panel panel_list">
                                                                            <ul class="list">
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <button class="accordion">
                                                                                    <span>
                                                                                        دهم
                                                                                    </span>
                                                                        </button>
                                                                        <div class="panel panel_list">
                                                                            <ul class="list">
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="accordion not_after">
                                                                                                <span>
                                                                                                    دین و زندگی
                                                                                                </span>
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <h4 class="titel_fillter center mrg_20">
                            انتخاب منابع
                        </h4>
                        <div class="Select_resources">
                            <div class="item_th thumbnail">
                                <ul class="exams list-inline item2 center">
                                    <li class="check_item">
                                        امتحان نهایی
                                    </li>
                                    <li class="check_item">
                                        کنکور سراسری
                                    </li>
                                    <li class="check_item">
                                        گزینه دو
                                    </li>
                                    <li class="check_item">
                                        قلمچی
                                    </li>
                                    <li class="check_item">
                                        آزمایش سنجش
                                    </li>
                                    <li class="check_item">
                                        تالیفی
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="item_th thumbnail">
                                <ul class="months list-inline item3 center">
                                    <li class="check_item">
                                        دی
                                    </li>
                                    <li class="check_item">
                                        خرداد
                                    </li>
                                    <li class="check_item">
                                        شهریور
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="item_th thumbnail">
                                <ul class="years list-inline item3 center">
                                    <li class="check_item">
                                        1395
                                    </li>
                                    <li class="check_item">
                                        1396
                                    </li>
                                    <li class="check_item">
                                        1397
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('custom-menu-footer')
    <div class="hidden-lg hidden-md hidden-sm button_fillter_respon">
        <button class="btn btn-block btn_green click_menu">
            فیلتر و جستجو در سایت
        </button>
    </div>
@endsection
@section("content")
    {{--<div class="search-page search-content-4">
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
                        <span class="tag label label-info tag_{{$key}}"
                              style="display: inline-block; margin: 2px; padding: 10px;">
                            <a class="removeTagLabel" data-role="{{$key}}" style="padding-left: 10px">
                                <i class="fa fa-remove"></i>
                            </a>
                        <span>
                                <a href="{{action("ContentController@index")}}?tags[]={{$extraTag}}"
                                   class="font-white">{{$extraTag}}</a>
                        </span>
                            <input id="tagInput_{{$key}}" class="extraTag" name="tags[]" type="hidden"
                                   value="{{$extraTag}}">
                        </span>
                    @endforeach
                @endif
                {!! Form::close() !!}
                <div class="row text-center">
                    <img id="content-search-loading" src="/assets/extra/load2.GIF" alt="loading"
                         style="display: none ; width: 20px;">
                </div>
            </div>
        </div>
    </div>--}}
    <div class="row">

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
                <div class="portlet-body " id="tab_contentset">
                </div>
            </div>
        </div>
    </div>
    @foreach($ads1 as $image => $link)
        @include('partials.bannerAds', ['img'=>$image , 'link'=>$link])
    @endforeach

    <div class="row">
        <!-- BEGIN PORTLET-->
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
                        <a href="#tab_content_video" data-toggle="tab">Video</a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body ">
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
    <!--
    -- js variables
    -->
    <div style="display: none">

        <input id="js-var-tags" type="hidden" value='@json($tags,JSON_UNESCAPED_UNICODE)'>
        <input id="js-var-extraTags" type="hidden" value='@json($extraTags,JSON_UNESCAPED_UNICODE)'>
        <input id="js-var-contentIndexUrl" type="hidden" value='{{action('ContentController@index')}}'>
        <input id="js-var-productIndexUrl" type="hidden" value='{{action('ProductController@index')}}'>
        <input id="js-var-setIndexUrl" type="hidden" value='{{action('ContentsetController@index')}}'>
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
    <script src="{{ mix('/js/search-extra-all.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection