@extends('partials.templatePage',["pageName"=>$pageName])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/profile-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("title")
    <title>آلاء|پنل مشاور</title>
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
                <span>پنل مشاوره</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class = "profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class = "portlet light profile-sidebar-portlet ">
                    <!-- SIDEBAR USERPIC -->
                    <div class = "profile-userpic">
                        <img @if(isset(Auth::user()->photo))  src = "{{ Auth::user()->photo}}" @endif class = "img-responsive" alt = "عکس پروفایل">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class = "profile-usertitle">
                        <div class = "profile-usertitle-name">@if(!isset(Auth::user()->firstName) && !isset(Auth::user()->lastName))
                                کاربر
                                ناشناس @else @if(isset(Auth::user()->firstName)) {{Auth::user()->firstName}} @endif @if(isset(Auth::user()->lastName)){{Auth::user()->lastName}} @endif @endif</div>
                        <div class = "profile-usertitle-name m--font-danger">مشاور</div>
                    </div>
                    <div class = "profile-userbuttons">
                        <button type = "button" class = "btn btn-circle green btn-sm" style = "margin-bottom: 10%">شما به {{$answeredQuestionsCount}} سؤال پاسخ داده اید
                        </button>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->

                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->

                    <!-- END MENU -->
                </div>
                <!-- END PORTLET MAIN -->
                <!-- PORTLET MAIN -->

                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class = "profile-content">

                <div class = "row">
                    <div class = "col-md-12">
                        <!-- BEGIN PORTLET -->
                        <div class = "portlet light ">
                            <div class = "portlet-title">
                                <div class = "caption caption-md">
                                    <i class = "icon-bar-chart theme-font hide"></i>
                                    <span class = "caption-subject font-yellow bold uppercase">لیست سؤالات مشاوره ای</span>
                                </div>

                                {{--<div class="inputs">--}}
                                {{--<div class="portlet-input input-inline input-small ">--}}
                                {{--<div class="input-icon right">--}}
                                {{--<i class="icon-magnifier"></i>--}}
                                {{--<input type="text" class="form-control form-control-solid" placeholder="search..."> </div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div class = "actions">
                                    <div class = "btn-group btn-group-devided" data-toggle = "buttons">
                                        <label class = "btn btn-transparent grey-salsa btn-circle btn-sm active">
                                            <input type = "radio" name = "options" class = "toggle" id = "option1">
                                            امروز
                                        </label>
                                        <label class = "btn btn-transparent grey-salsa btn-circle btn-sm">
                                            <input type = "radio" name = "options" class = "toggle" id = "option2">
                                            این هفته
                                        </label>
                                        <label class = "btn btn-transparent grey-salsa btn-circle btn-sm">
                                            <input type = "radio" name = "options" class = "toggle" id = "option2">
                                            این ماه
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class = "portlet-body">
                                <div class = "row number-stats margin-bottom-30">
                                    <div class = "col-md-6 col-sm-6 col-xs-6">
                                        <div class = "stat-left">
                                            <div class = "stat-chart">
                                                <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                <div id = "sparkline_total"></div>
                                            </div>
                                            <div class = "stat-number">
                                                <div class = "title">کل سؤالات</div>
                                                <div class = "number">{{$questions->count()}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "col-md-6 col-sm-6 col-xs-6">
                                        <div class = "stat-right">
                                            <div class = "stat-chart">
                                                <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                <div id = "sparkline_new"></div>
                                            </div>
                                            <div class = "stat-number">
                                                <div class = "title">سؤالات جدید</div>
                                                <div class = "number">{{$newQuestionsCount}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "scroller" style = "height: 300px;" data-always-visible = "1" data-rail-visible1 = "0" data-handle-color = "#D7DCE2">
                                    <div class = "general-item-list">
                                        @include("userUpload.index" )
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET -->
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery.sparkline.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/profile.min.js" type = "text/javascript"></script>
@endsection

@section("extraJS")
    <script type = "text/javascript">
        $("#sparkline_total").sparkline([0, 0, 0, 0, 0, 0, 0.5, 0.5, 0.5, 0.5, 0.5, 0.6, 1], {
            type: 'bar',
            width: '100',
            barWidth: 6,
            height: '45',
            barColor: '#F36A5B',
            negBarColor: '#e02222'
        });

        $("#sparkline_new").sparkline([0, 0, 0, 0, 0, 0, 0.5, 0.5, 0.5, 0.5, 0.5, 0.6, 1], {
            type: 'bar',
            width: '100',
            barWidth: 6,
            height: '45',
            barColor: '#5C9BD1',
            negBarColor: '#e02222'
        });
    </script>
@endsection

