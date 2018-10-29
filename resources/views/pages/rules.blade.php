@extends("app",["pageName"=>"rules"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("title")
    <title>@if(isset($wSetting->site->name)) {{$wSetting->site->name}} @endif|قوانین</title>
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>قوانین و مقررارت</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <!-- BEGIN CONTENT HEADER -->
    <div class="row margin-bottom-40 about-header"
         style="background-image: url(/assets/extra/rules.jpg); height: 400px">
        <div class="col-md-12">
            <h1 class="bold">قوانین سایت</h1>
            <h2 class="bold">برای استفاده از وب سایت {{$wSetting->site->name}} تبعیت از قوانین زیر الزامی می باشد</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit solid">
                <div class="portlet-title"></div>
                <div class="portlet-body">
                    <div class="white-bg white-bg">
                        <div class="m-heading-1 border-green m-bordered">
                            <h3 style="line-height: 50px;text-align: justify" class="bold">
                                {!!  $wSetting->site->rules!!}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT HEADER -->
@endsection

