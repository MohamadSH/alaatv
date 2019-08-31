@extends("app" , ["pageName" => "profile"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/profile-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("title")
    <title>آلاء|فایل های من</title>
@endsection

@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>فیلم ها و جزوه ها</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class = "profile-sidebar">
                @include('partials.profileSidebar' , [
                                        "withRegisterationDate"=>true ,
                                        "withNavigation" => true,
                                        ]
                                        )
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->

            <!-- BEGIN PROFILE CONTENT -->
            <div class = "profile-content">
                <div class = "row">
                    <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class = "dashboard-stat2 ">
                            <div class = "display">
                                <div class = "number">
                                    <h4 class = "bold" style = "color: #04abe7">
                                        اگه با کامپیوتر هستید
                                    </h4>
                                    <small>اینجوری دانلود کنید</small>
                                </div>
                                <div class = "icon">
                                    <i class = "fa fa-windows" aria-hidden = "true" style = "color: #04abe7"></i>
                                </div>
                            </div>
                            <div class = "progress-info" style = "text-align: justify ; color:#768086">
                                با مرورگر کروم وارد سایت
                                <a href = "https://k96.ir">k96.ir</a>
                                بشید بعد از ورود (یعنی وارد کردن شماره موبایل و کد ملی خودتون) به قسمت فیلم ها و جزوات پروفایل خودتون مراجعه کنید یعنی لینک
                                <a href = "https://k96.ir/asset">K96.ir/asset</a>
                                بعد رو هر لینکی که کلیک کنید می تونید راحت با نرم افزار IDM دانلود کنید.
                            </div>
                        </div>
                    </div>
                    <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class = "dashboard-stat2 ">
                            <div class = "display">
                                <div class = "number">
                                    <h4 class = "bold" style = "color: #8bc34a">
                                        اگه با گوشی اندروید هستید
                                    </h4>
                                    <small>اینجوری دانلود کنید</small>
                                </div>
                                <div class = "icon">
                                    <i class = "fa fa-android" aria-hidden = "true" style = "color: #8bc34a"></i>
                                </div>
                            </div>
                            <div class = "progress-info" style = "text-align: justify ; color: #768086;">
                                ابتدا نرم افزار ADM رو باز کنید، از تو منوی نرم افزار browser یا همون مرورگر رو انتخاب کنید. بعد بزنید
                                <a href = "https://k96.ir">k96.ir</a>
                                و ادامه ی راه شبیه کامپیوتر است. فقط دقت کنید با گوشی اگه می خواهید با ADM دانلود کنید با مرورگر دیگه سایت رو باز نکنید و حتما از مرورگر خود ADM استفاده کنید.
                            </div>
                        </div>
                    </div>
                </div>
                @if($isEmptyProducts)
                    <div class = "row">
                        <div class = "col-md-12 text-center">
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <h2 class = "block bold font-yellow">شما محصولی سفارش نداده اید!</h2>
                            <a href = "{{action("Web\ProductController@search")}}" class = "btn yellow-casablanca btn-outline">اردوها و همایش ها</a>
                            <!-- END SAMPLE FORM PORTLET-->
                        </div>
                    </div>
                @else
                    <style>
                        #pamphletPortlet .slimScrollBar {
                            background: rgb(181, 73, 61) !important;
                        }

                        #pamphletPortlet .slimScrollRail {
                            display: inherit !important;
                            background-color: #5f5c5c !important;
                        }
                    </style>
                    @if(!$pamphlets->isEmpty())
                        <div class = "portlet light " id = "pamphletPortlet">
                            <div class = "portlet-title">
                                <div class = "caption caption-md">
                                    <i class = "fa fa-book m--font-danger"></i>
                                    <span class = "caption-subject m--font-danger bold uppercase">جزوه های شما</span>
                                </div>
                            </div>
                            <div class = "portlet-body">
                                <div class = "row">
                                    @foreach($pamphlets as $productPamphlets)
                                        <div class = "col-md-6" style = "margin-bottom: 10px">
                                            <div class = "mt-element-list">
                                                <div class = "mt-list-head list-simple font-white bg-red-flamingo-opacity">
                                                    <div class = "list-head-title-container">
                                                        <h4 class = "list-title" style = "line-height: inherit">{{$productPamphlets["productName"]}}</h4>
                                                    </div>
                                                </div>
                                                <div class = "mt-list-container list-simple scroller" style = "height: 100px">
                                                    <ul>
                                                        @foreach($productPamphlets["pamphlets"] as $pamphlet)
                                                            @if(isset($pamphlet["file"]))
                                                                <li class = "mt-list-item">
                                                                    <div class = "list-icon-container">
                                                                        <i class = "fa fa-download"></i>
                                                                    </div>
                                                                    <div class = "list-item-content">
                                                                        <p class = "uppercase" style = "    font-size: 16px;">
                                                                            <a href = "{{action("Web\HomeController@download" , ["content"=>"فایل محصول","fileName"=>$pamphlet["file"] , "pId"=>$pamphlet["product_id"] ])}}">دانلود {{$pamphlet["name"]}}</a>
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <style>
                        #videoPortlet .slimScrollBar {
                            background: rgb(37, 108, 156) !important;
                        }

                        #videoPortlet .slimScrollRail {
                            display: inherit !important;
                            background-color: #5f5c5c !important;
                        }
                    </style>
                    @if(!$videos->isEmpty())
                        <div class = "portlet light" id = "videoPortlet">
                            <div class = "portlet-title">
                                <div class = "caption caption-md">
                                    <i class = "fa fa-video-camera font-blue-madison"></i>
                                    <span class = "caption-subject font-blue-madison bold uppercase">فیلم های شما</span>
                                </div>
                            </div>
                            <div class = "portlet-body">
                                <div class = "row">

                                    @foreach($videos as $productVideos)
                                        <div class = "col-md-6" style = "margin-bottom: 10px">
                                            <div class = "mt-element-list">
                                                <div class = "mt-list-head list-simple font-white bg-blue" style = "line-height: inherit">
                                                    <div class = "list-head-title-container">
                                                        <h4 class = "list-title" style = "line-height: inherit">{{$productVideos["productName"]}}</h4>
                                                    </div>
                                                </div>
                                                <div class = "mt-list-container list-simple scroller" style = "height: 200px">
                                                    <ul>
                                                        @foreach($productVideos["videos"] as $video)
                                                            @if(isset($video["file"]))
                                                                <li class = "mt-list-item">
                                                                    <div class = "list-icon-container">
                                                                        <i class = "fa fa-download"></i>
                                                                    </div>
                                                                    <div class = "list-item-content">
                                                                        <p class = "uppercase" style = "    font-size: 16px;">
                                                                            <a href = "{{action("Web\HomeController@download" , ["content"=>"فایل محصول","fileName"=>$video["file"] , "pId"=>$video["product_id"]  ])}}">دانلود {{$video["name"]}}</a>
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>

@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery.sparkline.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/counterup/jquery.waypoints.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/counterup/jquery.counterup.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/morris/morris.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/profile.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/dashboard.min.js" type = "text/javascript"></script>

@endsection
