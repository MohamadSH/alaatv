@extends('partials.templatePage' , ["pageName" => "profile"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/profile-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
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
                <span>پروفایل</span>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>اسناد فنی من</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class = "col-md-3">
            @include("partials.userPanelSideBar",["user" => $user])
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class = "col-lg-9 col-xs-12 col-sm-12">
            {{--<div class="portlet light portlet-fit ">--}}
            {{--<div class="portlet-title" style="border-bottom: 0px">--}}
            {{--<div class="caption">--}}
            {{--<span class="caption-subject bold font-dark ">اسناد فنی</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="portlet-body">--}}
            {{--<div class="row">--}}
            {{--@if(isset($belongings) && !$belongings->isEmpty() )--}}
            {{--@foreach($belongings as $belonging)--}}
            {{--<div class="col-md-4">--}}
            {{--<div class="mt-widget-4">--}}
            {{--<div class="mt-img-container">--}}
            {{--<img src="../acm/extra/elevator.jpg" /> </div>--}}
            {{--<div class="mt-container bg-purple-opacity">--}}
            {{--<div class="mt-head-title"> {{$belonging->name}} </div>--}}
            {{--<div class="mt-body-icons">تاریخ ثبت :--}}
            {{--{{$belonging->CreatedAt_Jalali()}}--}}
            {{--</div>--}}
            {{--<div class="mt-footer-button">--}}
            {{--<a href="{{action("Web\HomeController@download" , ["content"=>"سند فنی دارایی","fileName"=>$belonging->file ])}}"  class="btn btn-circle btn-danger btn-sm">دانلود سند فنی</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endforeach--}}
            {{--@else--}}
            {{--<div class="col-md-12">--}}
            {{--<div class="note bg-font-blue bg-blue">--}}
            {{--<h3 class="block text-center bold">برای شما اسناد فنی ثبت نشده است</h3>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endif--}}
            {{----}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class = "mt-element-list bg-white">
                <div class = "mt-list-head list-default green-haze">
                    <div class = "row">
                        <div class = "col-xs-8">
                            <div class = "list-head-title-container">
                                <h3 class = "list-title  sbold">اسناد فنی شما</h3>
                                {{--<div class="list-date">Nov 8, 2015</div>--}}
                            </div>
                        </div>
                        {{--<div class="col-xs-4">--}}
                        {{--<div class="list-head-summary-container">--}}
                        {{--<div class="list-pending">--}}
                        {{--<div class="badge badge-default list-count">3</div>--}}
                        {{--<div class="list-label">Pending</div>--}}
                        {{--</div>--}}
                        {{--<div class="list-done">--}}
                        {{--<div class="list-count badge badge-default last">2</div>--}}
                        {{--<div class="list-label">Completed</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class = "mt-list-container list-default">
                    {{--<div class="mt-list-title ">--}}
                    {{--<span class="badge badge-default pull-right bg-hover-green-jungle">--}}
                    {{--<a class="font-white" href="javascript:;">--}}
                    {{--<i class="fa fa-plus"></i>--}}
                    {{--</a>--}}
                    {{--</span>--}}
                    {{--</div>--}}
                    @if(isset($belongings) && !$belongings->isEmpty() )
                        <ul>
                            @foreach($belongings as $belonging)
                                <li class = "mt-list-item">
                                    <div class = "list-icon-container done">
                                        {{--<a href="javascript:;">--}}
                                        <i class = "fa fa-file-text font-green"></i>
                                        {{--</a>--}}
                                    </div>
                                    <div class = "list-datetime">
                                        <br/> {{$belonging->CreatedAt_Jalali()}} </div>
                                    <div class = "list-item-content">
                                        <h3 class = " bold">
                                            <a href = "javascript:">{{$belonging->name}}</a>
                                        </h3>
                                        <p>
                                            <a href = "{{action("Web\HomeController@download" , ["content"=>"سند فنی دارایی","fileName"=>$belonging->file ])}}" class = "btn btn-circle btn-danger btn-sm">دانلود سند فنی</a>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class = "col-md-12">
                            <div class = "note bg-font-blue bg-blue">
                                <h3 class = "block text-center bold">برای شما اسناد فنی ثبت نشده است</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->

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
