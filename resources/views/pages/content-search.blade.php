@extends("app",["pageName"=> $pageName ])

@section('right-aside')
@endsection

@section("pageBar")
@endsection

@section("page-js")
    <script src = "/acm/page-content-search.js" type = "text/javascript"></script>
@endsection

@section('content')

    <style>
        .itemSelector {
            background-color: #ddd;
            border-radius: 4px;
            -webkit-box-shadow: 0px 0px 5px 2px rgba(221,221,221,1);
            -moz-box-shadow: 0px 0px 5px 2px rgba(221,221,221,1);
            box-shadow: 0px 0px 5px 2px rgba(221,221,221,1);
        }
        .itemSelector .subItem:hover {
            -webkit-box-shadow: 0px 0px 15px 0px #7FDBFF;
            -moz-box-shadow: 0px 0px 15px 0px #7FDBFF;
            box-shadow: 0px 0px 15px 0px #7FDBFF;
            -moz-transform: scale(1.05);
            -webkit-transform: scale(1.05);
            -o-transform: scale(1.05);
            -ms-transform: scale(1.05);
            transform: scale(1.05);
        }
        .itemSelector .subItem {
            white-space: nowrap;
            text-align: center;
            margin: 5px;
            padding: 5px;
            background-color: #7FDBFF;
            border-radius: 4px;
            cursor: pointer;
            -webkit-box-shadow: 0px 0px 5px 0px #7FDBFF;
            -moz-box-shadow: 0px 0px 5px 0px #7FDBFF;
            box-shadow: 0px 0px 5px 0px #7FDBFF;
            transition-property: all;
            transition-duration: 0.3s;
        }
    </style>

    <div class="row">
        <div class="col">

            <div class="row itemSelector" data-select="selector1">
                <div class="col subItem">همه مقاطع</div>
                <div class="col subItem">دهم</div>
                <div class="col subItem">یازدهم</div>
                <div class="col subItem">کنکوری</div>
                <div class="col subItem">اول دبیرستان</div>
                <div class="col subItem">دوم دبیرستان</div>
                <div class="col subItem">سوم دبیرستان</div>
                <div class="col subItem">چهارم دبیرستان</div>
                <div class="col subItem">المپیاد</div>
            </div>

        </div>
    </div>


    <div class="row">
        @include('partials.search.contentset',['items' => $result->get('set')])
    </div>
    <div class="row">
        @include('partials.search.video',['items' => $result->get('video')])
    </div>
    <div class="row">
        @include('partials.search.pamphlet',['items' => $result->get('pamphlet')])
    </div>
    <div class="row">
        @include('partials.search.article',['items' => $result->get('article')])
    </div>
@endsection
{{--
@section("content")
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
    </div>
    <div class="row">
        <!-- BEGIN PORTLET-->
        <div class="portlet light contentPortlet">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-globe font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">فیلم ها و جزوات آموزشی آلاء</span>
                    --}}
{{--{!! $tagLabels !!}--}}{{--

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
@endsection--}}
