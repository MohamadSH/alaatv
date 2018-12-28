@extends("app",["pageName"=> $pageName ])

@section('right-aside')
@endsection

@section("pageBar")
@endsection

@section("page-js")
    <script src = "/acm/page-content-search.js" type = "text/javascript"></script>
@endsection

@section("content")
    <div class="row">
        @include('partials.search.video',['items' => $result->get('video')])
    </div>
    <div class="row">

    </div>
    <div class="row">

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
